<?php

namespace App\Http\Controllers;

use App\Models\Geolistrik1d;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use ZipArchive;

class AdminGeolistrik1dController extends Controller
{
    private const PDF_DIR = 'geolistrik-1d/pdf';

    public function __construct(private readonly FileUploadService $files)
    {
    }

    public function index(): View
    {
        $perPage     = max(1, min(100, (int) request()->integer('per_page', 10)));
        $selectedUpt = request()->get('upt', '');

        $query = Geolistrik1d::query();
        if ($selectedUpt !== '') {
            $query->where('upt', $selectedUpt);
        }

        $appends = ['per_page' => $perPage];
        if ($selectedUpt !== '') {
            $appends['upt'] = $selectedUpt;
        }

        $geolistrik1ds = $query->latest()->paginate($perPage)->appends($appends);

        $uptCounts = Geolistrik1d::query()
            ->selectRaw('upt, COUNT(*) as total')
            ->groupBy('upt')
            ->pluck('total', 'upt')
            ->toArray();

        $allBalai = self::allBalai();

        $importPreviewRows       = session('geolistrik_import_preview', []);
        $importPreviewErrorCount = (int) session('geolistrik_import_error_count', 0);
        $importPreviewWarnCount  = (int) session('geolistrik_import_warn_count', 0);

        return view('pages.admin.geolistrik-1d', compact(
            'geolistrik1ds', 'perPage', 'selectedUpt', 'uptCounts', 'allBalai',
            'importPreviewRows', 'importPreviewErrorCount', 'importPreviewWarnCount',
        ));
    }

    public static function allBalai(): array
    {
        return [
            ['label' => 'Sumatera', 'icon' => 'fa-mountain-sun', 'items' => [
                ['name' => 'Balai Besar Wilayah Sungai Sumatera II',    'short' => 'BBWS Sumatera II'],
                ['name' => 'Balai Besar Wilayah Sungai Sumatera VIII',  'short' => 'BBWS Sumatera VIII'],
                ['name' => 'Balai Besar Wilayah Sungai Mesuji Sekampung','short' => 'BBWS Mesuji Sekampung'],
                ['name' => 'Balai Wilayah Sungai Sumatera I',           'short' => 'BWS Sumatera I'],
                ['name' => 'Balai Wilayah Sungai Sumatera III',         'short' => 'BWS Sumatera III'],
                ['name' => 'Balai Wilayah Sungai Sumatera IV',          'short' => 'BWS Sumatera IV'],
                ['name' => 'Balai Wilayah Sungai Sumatera V',           'short' => 'BWS Sumatera V'],
                ['name' => 'Balai Wilayah Sungai Sumatera VI',          'short' => 'BWS Sumatera VI'],
                ['name' => 'Balai Wilayah Sungai Sumatera VII',         'short' => 'BWS Sumatera VII'],
                ['name' => 'Balai Wilayah Sungai Bangka Belitung',      'short' => 'BWS Bangka Belitung'],
            ]],
            ['label' => 'Jawa', 'icon' => 'fa-city', 'items' => [
                ['name' => 'Balai Besar Wilayah Sungai Cidanau Ciujung Cidurian','short' => 'BBWS Cidanau Ciujung Cidurian'],
                ['name' => 'Balai Besar Wilayah Sungai Ciliwung Cisadane',       'short' => 'BBWS Ciliwung Cisadane'],
                ['name' => 'Balai Besar Wilayah Sungai Citarum',                 'short' => 'BBWS Citarum'],
                ['name' => 'Balai Besar Wilayah Sungai Citanduy',                'short' => 'BBWS Citanduy'],
                ['name' => 'Balai Besar Wilayah Sungai Cimanuk Cisanggarung',    'short' => 'BBWS Cimanuk Cisanggarung'],
                ['name' => 'Balai Besar Wilayah Sungai Pemali Juana',            'short' => 'BBWS Pemali Juana'],
                ['name' => 'Balai Besar Wilayah Sungai Serayu Opak',             'short' => 'BBWS Serayu Opak'],
                ['name' => 'Balai Besar Wilayah Sungai Bengawan Solo',           'short' => 'BBWS Bengawan Solo'],
                ['name' => 'Balai Besar Wilayah Sungai Brantas',                 'short' => 'BBWS Brantas'],
            ]],
            ['label' => 'Bali & Nusa Tenggara', 'icon' => 'fa-water', 'items' => [
                ['name' => 'Balai Wilayah Sungai Bali Penida',           'short' => 'BWS Bali Penida'],
                ['name' => 'Balai Besar Wilayah Sungai Nusa Tenggara I', 'short' => 'BBWS Nusa Tenggara I'],
                ['name' => 'Balai Besar Wilayah Sungai Nusa Tenggara II','short' => 'BBWS Nusa Tenggara II'],
            ]],
            ['label' => 'Kalimantan', 'icon' => 'fa-tree', 'items' => [
                ['name' => 'Balai Wilayah Sungai Kalimantan I',   'short' => 'BWS Kalimantan I'],
                ['name' => 'Balai Wilayah Sungai Kalimantan II',  'short' => 'BWS Kalimantan II'],
                ['name' => 'Balai Wilayah Sungai Kalimantan III', 'short' => 'BWS Kalimantan III'],
                ['name' => 'Balai Wilayah Sungai Kalimantan IV',  'short' => 'BWS Kalimantan IV'],
                ['name' => 'Balai Wilayah Sungai Kalimantan V',   'short' => 'BWS Kalimantan V'],
            ]],
            ['label' => 'Sulawesi', 'icon' => 'fa-anchor', 'items' => [
                ['name' => 'Balai Besar Wilayah Sungai Pompengan Jeneberang','short' => 'BBWS Pompengan Jeneberang'],
                ['name' => 'Balai Wilayah Sungai Sulawesi I',   'short' => 'BWS Sulawesi I'],
                ['name' => 'Balai Wilayah Sungai Sulawesi II',  'short' => 'BWS Sulawesi II'],
                ['name' => 'Balai Wilayah Sungai Sulawesi III', 'short' => 'BWS Sulawesi III'],
                ['name' => 'Balai Wilayah Sungai Sulawesi IV',  'short' => 'BWS Sulawesi IV'],
                ['name' => 'Balai Wilayah Sungai Sulawesi V',   'short' => 'BWS Sulawesi V'],
            ]],
            ['label' => 'Maluku & Papua', 'icon' => 'fa-globe-asia', 'items' => [
                ['name' => 'Balai Wilayah Sungai Maluku',        'short' => 'BWS Maluku'],
                ['name' => 'Balai Wilayah Sungai Maluku Utara',  'short' => 'BWS Maluku Utara'],
                ['name' => 'Balai Wilayah Sungai Papua',         'short' => 'BWS Papua'],
                ['name' => 'Balai Wilayah Sungai Papua Barat',   'short' => 'BWS Papua Barat'],
                ['name' => 'Balai Wilayah Sungai Papua Merauke', 'short' => 'BWS Papua Merauke'],
            ]],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        Geolistrik1d::create($this->validatedData($request));

        return redirect()
            ->route('admin.geolistrik-1d.index')
            ->with('success', 'Data Geolistrik 1D berhasil ditambahkan.');
    }

    public function update(Request $request, Geolistrik1d $geolistrik1d): RedirectResponse
    {
        $geolistrik1d->update($this->validatedData($request, $geolistrik1d));

        return redirect()
            ->route('admin.geolistrik-1d.index')
            ->with('success', 'Data Geolistrik 1D berhasil diperbarui.');
    }

    public function destroy(Geolistrik1d $geolistrik1d): RedirectResponse
    {
        $this->files->delete($geolistrik1d->pdf_path);
        $geolistrik1d->delete();

        return redirect()
            ->route('admin.geolistrik-1d.index')
            ->with('success', 'Data Geolistrik 1D berhasil dihapus.');
    }

    public function importPreview(Request $request): RedirectResponse
    {
        $request->validate([
            'excel_file' => ['required', 'file', 'mimes:xlsx,csv,txt', 'max:10240'],
        ]);

        try {
            $rows = $this->parseImportFile($request);
        } catch (\Throwable $exception) {
            return redirect()
                ->route('admin.geolistrik-1d.index')
                ->with('error', $exception->getMessage());
        }

        if (!count($rows)) {
            return redirect()
                ->route('admin.geolistrik-1d.index')
                ->with('error', 'File tidak memiliki data untuk diimport.');
        }

        // Daftar nama UPT valid (38 BBWS/BWS)
        $validUptNames = collect(self::allBalai())
            ->flatMap(fn ($group) => $group['items'])
            ->pluck('name')
            ->map(fn ($name) => strtolower(trim($name)))
            ->all();

        // Pre-fill UPT dari filter aktif (jika admin upload dari halaman balai tertentu)
        $selectedUpt = trim((string) $request->input('selected_upt', ''));

        $previewRows = [];
        $errorCount  = 0;
        $warnCount   = 0;

        foreach ($rows as $index => $row) {
            // Auto-fill UPT kosong dengan filter aktif
            if ($selectedUpt !== '' && empty($row['upt'])) {
                $row['upt'] = $selectedUpt;
            }

            $validator = Validator::make($row, $this->rules());
            $errors    = $validator->errors()->all();
            $errorCount += count($errors) ? 1 : 0;

            // Periksa apakah UPT dikenal
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

        session()->put('geolistrik_import_preview', $previewRows);
        session()->put('geolistrik_import_error_count', $errorCount);
        session()->put('geolistrik_import_warn_count', $warnCount);

        return redirect()
            ->route('admin.geolistrik-1d.index');
    }

    public function importStore(): RedirectResponse
    {
        $previewRows = session('geolistrik_import_preview', []);
        $errorCount = (int) session('geolistrik_import_error_count', 0);

        if (!count($previewRows)) {
            return redirect()
                ->route('admin.geolistrik-1d.index')
                ->with('error', 'Tidak ada data preview import yang bisa ditambahkan.');
        }

        if ($errorCount > 0) {
            return redirect()
                ->route('admin.geolistrik-1d.index')
                ->with('error', 'Perbaiki data Excel terlebih dahulu sebelum menambahkan data.');
        }

        $records = collect($previewRows)
            ->map(function (array $row): array {
                $data = $row['data'];
                $data['created_at'] = now();
                $data['updated_at'] = now();

                return $data;
            })
            ->all();

        DB::transaction(function () use ($records): void {
            Geolistrik1d::insert($records);
        });
        session()->forget(['geolistrik_import_preview', 'geolistrik_import_error_count']);

        return redirect()
            ->route('admin.geolistrik-1d.index')
            ->with('success', count($records) . ' data Geolistrik 1D berhasil ditambahkan dari Excel.');
    }

    private function validatedData(Request $request, ?Geolistrik1d $geolistrik1d = null): array
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('pdf_file')) {
            $data['pdf_path'] = $geolistrik1d
                ? $this->files->replace($geolistrik1d->pdf_path, $request->file('pdf_file'), self::PDF_DIR)
                : $this->files->store($request->file('pdf_file'), self::PDF_DIR);
        }

        unset($data['pdf_file']);

        return $data;
    }

    private function rules(): array
    {
        return [
            'kode' => ['required', 'string', 'max:255'],
            'kab_kota' => ['nullable', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'desa_kelurahan' => ['nullable', 'string', 'max:255'],
            'upt' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-11.2,6.2'],
            'longitude' => ['required', 'numeric', 'between:94.6,141.1'],
            'elevasi' => ['nullable', 'string', 'max:255'],
            'tanggal_akusisi_data' => ['nullable', 'date'],
            'geologi' => ['nullable', 'string'],
            'cekungan_air_tanah' => ['nullable', 'string', 'max:255'],
            'hidrogeologi' => ['nullable', 'string'],
            'lapisan_pembawa_air' => ['nullable', 'string'],
            'potensi' => ['nullable', 'string'],
            'pdf_path' => ['nullable', 'string', 'max:255'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    private function parseImportFile(Request $request): array
    {
        $file = $request->file('excel_file');
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

        $sample = fgets($handle);
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
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $sheetRelsXml = $zip->getFromName('xl/worksheets/_rels/sheet1.xml.rels');
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

        // Sel dengan hyperlink (mis. teks "Lihat PDF" yang di-link ke Google Drive)
        // menyimpan URL asli terpisah dari teks yang ditampilkan, jadi harus dibaca dari sini.
        $hyperlinkTargets = $this->readHyperlinkTargets($sheetXPath, $sheetRelsXml);

        $rows = [];

        foreach ($rowNodes as $rowNode) {
            $values = [];

            foreach ($sheetXPath->query('./main:c', $rowNode) as $cell) {
                $reference = $cell->attributes?->getNamedItem('r')?->nodeValue ?? '';
                $columnIndex = $this->columnIndex($reference);
                $values[$columnIndex] = $hyperlinkTargets[$reference]
                    ?? $this->readXlsxCellValue($cell, $sharedStrings, $sheetXPath);
            }

            if (!count($values)) {
                continue;
            }

            ksort($values);
            $normalizedRow = [];
            $lastColumn = max(array_keys($values));

            for ($column = 0; $column <= $lastColumn; $column++) {
                $normalizedRow[] = $values[$column] ?? null;
            }

            $rows[] = $normalizedRow;
        }

        return $rows;
    }

    /**
     * Peta referensi sel (mis. "N2") ke URL hyperlink asli, dibaca dari
     * <hyperlinks> pada sheet1.xml dan diresolusi lewat sheet1.xml.rels.
     */
    private function readHyperlinkTargets(\DOMXPath $sheetXPath, string|false $sheetRelsXml): array
    {
        if ($sheetRelsXml === false) {
            return [];
        }

        $relsDom = new \DOMDocument();
        $relsDom->preserveWhiteSpace = false;
        $relsDom->loadXML($sheetRelsXml);

        $relsXPath = new \DOMXPath($relsDom);
        $relsXPath->registerNamespace('main', 'http://schemas.openxmlformats.org/package/2006/relationships');

        $relationshipTargets = [];
        foreach ($relsXPath->query('//main:Relationship') as $node) {
            $id = $node->attributes?->getNamedItem('Id')?->nodeValue;
            $target = $node->attributes?->getNamedItem('Target')?->nodeValue;

            if ($id && $target) {
                $relationshipTargets[$id] = $target;
            }
        }

        if (!count($relationshipTargets)) {
            return [];
        }

        $targets = [];
        foreach ($sheetXPath->query('//main:hyperlinks/main:hyperlink') as $node) {
            $ref = $node->attributes?->getNamedItem('ref')?->nodeValue;
            $relationshipId = $node->getAttributeNS(
                'http://schemas.openxmlformats.org/officeDocument/2006/relationships',
                'id'
            );

            if ($ref && $relationshipId && isset($relationshipTargets[$relationshipId])) {
                $targets[$ref] = $relationshipTargets[$relationshipId];
            }
        }

        return $targets;
    }

    private function readSharedStrings(ZipArchive $zip): array
    {
        $xml = $zip->getFromName('xl/sharedStrings.xml');

        if ($xml === false) {
            return [];
        }

        $sharedDom = new \DOMDocument();
        $sharedDom->preserveWhiteSpace = false;
        $sharedDom->loadXML($xml);

        $sharedXPath = new \DOMXPath($sharedDom);
        $sharedXPath->registerNamespace('main', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        $stringItems = $sharedXPath->query('//main:si');

        if (!$stringItems) {
            return [];
        }

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
            $index = (int) ($valueNode?->textContent ?? 0);
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
        $index = 0;

        foreach (str_split($letters) as $letter) {
            $index = ($index * 26) + (ord($letter) - 64);
        }

        return $index - 1;
    }

    private function normalizeImportRows(array $rawRows): array
    {
        $rawRows = array_values(array_filter($rawRows, fn (array $row): bool => count(array_filter($row, fn ($value): bool => trim((string) $value) !== '')) > 0));

        if (!count($rawRows)) {
            return [];
        }

        $headers = array_map(fn ($header): string => $this->normalizeHeader((string) $header), array_shift($rawRows));
        $headerMap = array_flip($headers);
        $fieldMap = [
            'kode' => ['kode'],
            'kab_kota' => ['kabkota', 'kabupatenkota'],
            'kecamatan' => ['kecamatan'],
            'desa_kelurahan' => ['desakelurahan', 'desakel', 'kelurahan', 'desa'],
            'upt' => ['upt'],
            'latitude' => ['latitude', 'lat'],
            'longitude' => ['longitude', 'long', 'lng'],
            'elevasi' => ['elevasi'],
            'tanggal_akusisi_data' => ['tanggalakusisidata', 'tanggalakuisisidata', 'tanggalakusisi', 'tanggalakuisisi'],
            'geologi' => ['geologi'],
            'cekungan_air_tanah' => ['cekunganairtanah', 'cat'],
            'hidrogeologi' => ['hidrogeologi'],
            'lapisan_pembawa_air' => ['lapisanpembawaair'],
            'potensi' => ['potensi'],
            'pdf_path' => ['pdf', 'filepdf', 'dokumenpdf', 'foto', 'link', 'linkpdf', 'url'],
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
            ->filter(fn (array $row): bool => count(array_filter($row, fn ($value): bool => trim((string) $value) !== '')) > 0)
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

        if ($value === '') {
            return null;
        }

        if (in_array($field, ['latitude', 'longitude'], true)) {
            return str_replace(',', '.', $value);
        }

        if ($field === 'tanggal_akusisi_data' && is_numeric($value)) {
            $timestamp = ((int) $value - 25569) * 86400;
            return gmdate('Y-m-d', $timestamp);
        }

        if ($field === 'tanggal_akusisi_data') {
            $normalizedDate = $this->normalizeIndonesianDate($value);

            if ($normalizedDate) {
                return $normalizedDate;
            }
        }

        return $value;
    }

    private function normalizeIndonesianDate(string $value): ?string
    {
        $months = [
            'januari' => '01',
            'februari' => '02',
            'maret' => '03',
            'april' => '04',
            'mei' => '05',
            'juni' => '06',
            'juli' => '07',
            'agustus' => '08',
            'september' => '09',
            'oktober' => '10',
            'november' => '11',
            'desember' => '12',
        ];

        $normalized = strtolower(trim($value));

        if (!preg_match('/^(\d{1,2})\s+([a-z]+)\s+(\d{4})$/', $normalized, $matches)) {
            return null;
        }

        $month = $months[$matches[2]] ?? null;

        if (!$month) {
            return null;
        }

        return $matches[3] . '-' . $month . '-' . str_pad($matches[1], 2, '0', STR_PAD_LEFT);
    }
}
