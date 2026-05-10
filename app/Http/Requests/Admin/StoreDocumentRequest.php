<?php

namespace App\Http\Requests\Admin;

class StoreDocumentRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'thumbnail' => $this->imageRules(),
            'pdf' => $this->pdfRules(),
        ];
    }
}
