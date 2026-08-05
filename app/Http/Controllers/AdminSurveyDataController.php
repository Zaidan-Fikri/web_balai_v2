<?php

namespace App\Http\Controllers;

use App\Models\SurveyData;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use ZipArchive;

class AdminSurveyDataController extends Controller
{
    private const TYPES = [
        'geolistrik-2d'   => ['label' => 'Geolistrik 2D',   'db' => 'geolistrik_2d',   'icon' => 'fa-wave-square'],
        'pumping-test'    => ['label' => 'Pumping Test',     'db' => 'pumping_test',     'icon' => 'fa-droplet'],
        'borehole-camera' => ['label' => 'Borehole Camera',  'db' => 'borehole_camera',  'icon' => 'fa-camera'],
        'logging'         => ['label' => 'Logging',           'db' => 'logging',           'icon' => 'fa-chart-bar'],
    ];

    private const PDF_DIR = 'survey-data/pdf';

    public function __construct(private readonly FileUploadService $files)
    {
    }

    public static function allTypes(): array
    {
        return self::TYPES;
    }

    public function index(Request $request, string $typeSlug): View
    {
        $typeConfig  = $this->resolveType($typeSlug);
        $perPage     = max(1, min(100, (int) $request->integer('per_page', 10)));
        $selectedUpt = (string) $request->get('upt', '');

        $query = SurveyData::where('type', $typeConfig['db']);
        if ($selectedUpt !== '') {
            $query->where('upt', $selectedUpt);
        }

        $appends = ['per_page' => $perPage];
        if ($selectedUpt !== '') {
            $appends['upt'] = $selectedUpt;
        }

        $items = $query->latest()->paginate($perPage)->appends($appends);

        $uptCounts = SurveyData::where('type', $typeConfig['db'])
            ->selectRaw('upt, COUNT(*) as total')
            ->groupBy('upt')
            ->pluck('total', 'upt')
            ->toArray();

        $allBalai = AdminGeolistrik1dController::allBalai();

        $sessionKey              = 'survey_import_preview_' . $typeConfig['db'];
        $importPreviewRows       = session($sessionKey, []);
        $importPreviewErrorCount = (int) session($sessionKey . '_error_count', 0);
        $importPreviewWarnCount  = (int) session($sessionKey . '_warn_count', 0);

        return view('pages.admin.survey-data', compact(
            'typeSlug', 'typeConfig', 'items', 'perPage', 'selectedUpt',
            'uptCounts', 'allBalai',
            'importPreviewRows', 'importPreviewErrorCount', 'importPreviewWarnCount',
        ));
    }

    public function store(Request $request, string $typeSlug): RedirectResponse
    {
        $typeConfig = $this->resolveType($typeSlug);
        $data = $this->validatedData($request);
        $data['type'] = $typeConfig['db'];

        SurveyData::create($data);

        return redirect()
            ->route('admin.survey.index', ['typeSlug' => $typeSlug])
            ->with('success', 'Data ' . $typeConfig['label'] . ' berhasil ditambahkan.');
    }

    public function update(Request $request, string $typeSlug, SurveyData $surveyData): RedirectResponse
    {
        $typeConfig = $this->resolveType($typeSlug);
        $surveyData->update($this->validatedData($request, $surveyData));

        return redirect()
            ->route('admin.survey.index', ['typeSlug' => $typeSlug])
            ->with('success', 'Data ' . $typeConfig['label'] . ' berhasil diperbarui.');
    }

    public function destroy(string $typeSlug, SurveyData $surveyData): RedirectResponse
    {
        $typeConfig = $this->resolveType($typeSlug);
        $this->files->delete($surveyData->pdf_path);
        $surveyData->delete();

        return redirect()
            ->route('admin.survey.index', ['typeSlug' => $typeSlug])
            ->with('success', 'Data ' . $typeConfig['label'] . ' berhasil dihapus.');
    }

    public function bulkDestroy(Request $request, string $typeSlug): RedirectResponse
    {
        $typeConfig = $this->resolveType($typeSlug);

        $validator = Validator::make($request->all(), [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.survey.index', ['typeSlug' => $typeSlug])
                ->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }

        $items = SurveyData::where('type', $typeConfig['db'])
            ->whereIn('id', $request->input('ids'))
            ->get();

        DB::transaction(function () use ($items): void {
            foreach ($items as $item) {
                $this->files->delete($item->pdf_path);
                $item->delete();
            }
        });

        return redirect()
            ->route('admin.survey.index', ['typeSlug' => $typeSlug])
            ->with('success', $items->count() . ' data ' . $typeConfig['label'] . ' berhasil dihapus.');
    }

    public function importPreview(Request $request, string $typeSlug): RedirectResponse
    {
        $typeConfig = $this->resolveType($typeSlug);

        $request->validate([
            'excel_file' => ['required', 'file', 'mimes:xlsx,csv,txt', 'max:10240'],
        ]);

        try {
            $rows = $this->parseImportFile($request);
        } catch (\Throwable $exception) {
            return redirect()
                ->route('admin.survey.index', ['typeSlug' => $typeSlug])
                ->with('error', $exception->getMessage());
        }

        if (!count($rows)) {
            return redirect()
                ->route('admin.survey.index', ['typeSlug' => $typeSlug])
                ->with('error', 'File tidak memiliki data untuk diimport.');
        }

        $validUptNames = collect(AdminGeolistrik1dController::allBalai())
            ->flatMap(fn ($group) => $group['items'])
            ->pluck('name')
            ->map(fn ($name) => strtolower(trim($name)))
            ->all();

        $selectedUpt = trim((string) $request->input('selected_upt', ''));

        $previewRows = [];
        $errorCount  = 0;
        $warnCount   = 0;

        foreach ($rows as $index => $row) {
            if ($selectedUpt !== '' && empty($row['upt'])) {
                $row['upt'] = $selectedUpt;
            }

            $validator = Validator::make($row, $this->rules());
            $errors    = $validator->errors()->all();
            $errorCount += count($errors) ? 1 : 0;

            $warnings = [];
            $uptValue = trim((string) ($row['upt'] ?? ''));
            if ($uptValue !== '' && !in_array(strtolower($uptValue), $validUptNames, true)) {
                $warnings[] = 'Nama UPT tidak dikenal — pastikan sesuai dengan nama resmi BBWS/BWS.';
                $warnCount++;
            }
            if ($uptValue === '') {
                $warnings[] = 'UPT kosong — data tidak akan muncul di filter Wilayah manapun.';
                $warnCount++;
            }

            $previewRows[] = [
                'number'   => $index + 1,
                'data'     => $row,
                'errors'   => $errors,
                'warnings' => $warnings,
            ];
        }

        $sessionKey = 'survey_import_preview_' . $typeConfig['db'];
        session()->put($sessionKey, $previewRows);
        session()->put($sessionKey . '_error_count', $errorCount);
        session()->put($sessionKey . '_warn_count', $warnCount);

        return redirect()->route('admin.survey.index', ['typeSlug' => $typeSlug]);
    }

    public function importStore(string $typeSlug): RedirectResponse
    {
        $typeConfig = $this->resolveType($typeSlug);
        $sessionKey = 'survey_import_preview_' . $typeConfig['db'];

        $previewRows = session($sessionKey, []);
        $errorCount  = (int) session($sessionKey . '_error_count', 0);

        if (!count($previewRows)) {
            return redirect()
                ->route('admin.survey.index', ['typeSlug' => $typeSlug])
                ->with('error', 'Tidak ada data preview import yang bisa ditambahkan.');
        }

        if ($errorCount > 0) {
            return redirect()
                ->route('admin.survey.index', ['typeSlug' => $typeSlug])
                ->with('error', 'Perbaiki data Excel terlebih dahulu sebelum menambahkan data.');
        }

        $records = collect($previewRows)
            ->map(function (array $row) use ($typeConfig): array {
                $data                 = $row['data'];
                $data['type']         = $typeConfig['db'];
                $data['created_at']   = now();
                $data['updated_at']   = now();
                return $data;
            })
            ->all();

        DB::transaction(function () use ($records): void {
            SurveyData::insert($records);
        });

        session()->forget([$sessionKey, $sessionKey . '_error_count', $sessionKey . '_warn_count']);

        return redirect()
            ->route('admin.survey.index', ['typeSlug' => $typeSlug])
            ->with('success', count($records) . ' data ' . $typeConfig['label'] . ' berhasil ditambahkan dari Excel.');
    }

    private function resolveType(string $slug): array
    {
        $config = self::TYPES[$slug] ?? null;
        if (!$config) {
            abort(404);
        }
        return $config;
    }

    private function validatedData(Request $request, ?SurveyData $surveyData = null): array
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('pdf_file')) {
            $data['pdf_path'] = $surveyData
                ? $this->files->replace($surveyData->pdf_path, $request->file('pdf_file'), self::PDF_DIR)
                : $this->files->store($request->file('pdf_file'), self::PDF_DIR);
        }

        unset($data['pdf_file']);

        return $data;
    }

    private function rules(): array
    {
        return [
            'kode'                 => ['required', 'string', 'max:255'],
            'kab_kota'             => ['nullable', 'string', 'max:255'],
            'kecamatan'            => ['nullable', 'string', 'max:255'],
            'desa_kelurahan'       => ['nullable', 'string', 'max:255'],
            'upt'                  => ['nullable', 'string', 'max:255'],
            'latitude'             => ['required', 'numeric', 'between:-11.2,6.2'],
            'longitude'            => ['required', 'numeric', 'between:94.6,141.1'],
            'elevasi'              => ['nullable', 'string', 'max:255'],
            'tanggal_akusisi_data' => ['nullable', 'date'],
            'geologi'              => ['nullable', 'string'],
            'cekungan_air_tanah'   => ['nullable', 'string', 'max:255'],
            'hidrogeologi'         => ['nullable', 'string'],
            'lapisan_pembawa_air'  => ['nullable', 'string'],
            'pdf_path'             => ['nullable', 'string', 'max:255'],
            'pdf_file'             => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    private function parseImportFile(Request $request): array
    {
        $file      = $request->file('excel_file');
        $extension = strtolower($file->getClientOriginalExtension());

        $rows = $extension === 'csv' || $extension === 'txt'
            ? $this->parseCsv($file->getRealPath())
            : $this->parseXlsx($file->getRealPath());

        return $this->normalizeImportRows($rows);
    }

    private function parseCsv(string $path): array
    {
        $handle = fopen($path, 'rb');
        if (!$handle) {
            throw new \RuntimeException('File CSV tidak bisa dibaca.');
        }

        $sample    = fgets($handle);
        $delimiter = $sample !== false && substr_count($sample, ';') > substr_count($sample, ',') ? ';' : ',';
        rewind($handle);

        $rows = [];
        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rows[] = $row;
        }

        fclose($handle);
        return $rows;
    }

    private function parseXlsx(string $path): array
    {
        if (!class_exists(ZipArchive::class)) {
            throw new \RuntimeException('Ekstensi PHP ZipArchive belum aktif, file .xlsx tidak bisa dibaca.');
        }

        $zip = new ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \RuntimeException('File Excel tidak bisa dibuka.');
        }

        $sharedStrings = $this->readSharedStrings($zip);
        $sheetXml      = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            throw new \RuntimeException('Sheet pertama tidak ditemukan di file Excel.');
        }

        $sheetDom = new \DOMDocument();
        $sheetDom->preserveWhiteSpace = false;
        $sheetDom->loadXML($sheetXml);

        $sheetXPath = new \DOMXPath($sheetDom);
        $sheetXPath->registerNamespace('main', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $rowNodes = $sheetXPath->query('//main:sheetData/main:row');

        if (!$rowNodes) {
            throw new \RuntimeException('Sheet Excel tidak bisa dibaca.');
        }

        $rows = [];
        foreach ($rowNodes as $rowNode) {
            $values = [];
            foreach ($sheetXPath->query('./main:c', $rowNode) as $cell) {
                $reference   = $cell->attributes?->getNamedItem('r')?->nodeValue ?? '';
                $columnIndex = $this->columnIndex($reference);
                $values[$columnIndex] = $this->readXlsxCellValue($cell, $sharedStrings, $sheetXPath);
            }
            if (!count($values)) continue;

            ksort($values);
            $normalizedRow = [];
            $lastColumn    = max(array_keys($values));
            for ($column = 0; $column <= $lastColumn; $column++) {
                $normalizedRow[] = $values[$column] ?? null;
            }
            $rows[] = $normalizedRow;
        }

        return $rows;
    }

    private function readSharedStrings(ZipArchive $zip): array
    {
        $xml = $zip->getFromName('xl/sharedStrings.xml');
        if ($xml === false) return [];

        $sharedDom = new \DOMDocument();
        $sharedDom->preserveWhiteSpace = false;
        $sharedDom->loadXML($xml);

        $sharedXPath = new \DOMXPath($sharedDom);
        $sharedXPath->registerNamespace('main', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $stringItems = $sharedXPath->query('//main:si');
        if (!$stringItems) return [];

        $strings = [];
        foreach ($stringItems as $stringItem) {
            $strings[] = trim($stringItem->textContent);
        }
        return $strings;
    }

    private function readXlsxCellValue(\DOMElement $cell, array $sharedStrings, \DOMXPath $sheetXPath): ?string
    {
        $type = $cell->getAttribute('t');

        if ($type === 's') {
            $valueNode = $sheetXPath->query('./main:v', $cell)->item(0);
            $index     = (int) ($valueNode?->textContent ?? 0);
            return $sharedStrings[$index] ?? '';
        }

        if ($type === 'inlineStr') {
            $inlineNode = $sheetXPath->query('./main:is/main:t', $cell)->item(0);
            return $inlineNode ? trim($inlineNode->textContent) : '';
        }

        $valueNode = $sheetXPath->query('./main:v', $cell)->item(0);
        return $valueNode ? trim($valueNode->textContent) : '';
    }

    private function columnIndex(string $reference): int
    {
        preg_match('/^[A-Z]+/i', $reference, $matches);
        $letters = strtoupper($matches[0] ?? 'A');
        $index   = 0;
        foreach (str_split($letters) as $letter) {
            $index = ($index * 26) + (ord($letter) - 64);
        }
        return $index - 1;
    }

    private function normalizeImportRows(array $rawRows): array
    {
        $rawRows = array_values(array_filter(
            $rawRows,
            fn (array $row): bool => count(array_filter($row, fn ($v): bool => trim((string) $v) !== '')) > 0,
        ));

        if (!count($rawRows)) return [];

        $headers   = array_map(fn ($h): string => $this->normalizeHeader((string) $h), array_shift($rawRows));
        $headerMap = array_flip($headers);
        $fieldMap  = [
            'kode'                 => ['kode'],
            'kab_kota'             => ['kabkota', 'kabupatenkota'],
            'kecamatan'            => ['kecamatan'],
            'desa_kelurahan'       => ['desakelurahan', 'desakel', 'kelurahan', 'desa'],
            'upt'                  => ['upt'],
            'latitude'             => ['latitude', 'lat'],
            'longitude'            => ['longitude', 'long', 'lng'],
            'elevasi'              => ['elevasi'],
            'tanggal_akusisi_data' => ['tanggalakusisidata', 'tanggalakuisisidata', 'tanggalakusisi', 'tanggalakuisisi'],
            'geologi'              => ['geologi'],
            'cekungan_air_tanah'   => ['cekunganairtanah', 'cat'],
            'hidrogeologi'         => ['hidrogeologi'],
            'lapisan_pembawa_air'  => ['lapisanpembawaair'],
            'pdf_path'             => ['pdf', 'filepdf', 'dokumenpdf'],
        ];

        return collect($rawRows)
            ->map(function (array $row) use ($headerMap, $fieldMap): array {
                $data = [];
                foreach ($fieldMap as $field => $aliases) {
                    $value = null;
                    foreach ($aliases as $alias) {
                        if (array_key_exists($alias, $headerMap)) {
                            $value = $row[$headerMap[$alias]] ?? null;
                            break;
                        }
                    }
                    $data[$field] = $this->cleanImportValue($field, $value);
                }
                return $data;
            })
            ->filter(fn (array $row): bool => count(array_filter($row, fn ($v): bool => trim((string) $v) !== '')) > 0)
            ->values()
            ->all();
    }

    private function normalizeHeader(string $header): string
    {
        return strtolower(preg_replace('/[^a-z0-9]+/i', '', $header) ?? '');
    }

    private function cleanImportValue(string $field, mixed $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') return null;

        if (in_array($field, ['latitude', 'longitude'], true)) {
            return str_replace(',', '.', $value);
        }

        if ($field === 'tanggal_akusisi_data' && is_numeric($value)) {
            $timestamp = ((int) $value - 25569) * 86400;
            return gmdate('Y-m-d', $timestamp);
        }

        return $value;
    }
}
