<?php

namespace App\Http\Requests\Admin;

class StoreInformasiBerkalaRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'kategori' => ['required', 'string', 'in:laporan_ppid,survey_kepuasan,maklumat_pelayanan,standar_pelayanan'],
            'tahun'    => ['required', 'integer', 'min:2000', 'max:2100'],
            'judul'    => ['required', 'string', 'max:255'],
            'pdf'      => $this->pdfRules(),
        ];
    }
}
