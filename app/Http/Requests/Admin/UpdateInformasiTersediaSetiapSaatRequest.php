<?php

namespace App\Http\Requests\Admin;

class UpdateInformasiTersediaSetiapSaatRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'judul' => ['required', 'string', 'max:255'],
            'pdf'   => $this->pdfRules('nullable'),
        ];
    }
}
