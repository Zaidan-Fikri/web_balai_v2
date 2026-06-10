<?php

namespace App\Http\Requests\Admin;

class StoreInformasiSertaMertaRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'judul' => ['required', 'string', 'max:255'],
            'pdf'   => $this->pdfRules(),
        ];
    }
}
