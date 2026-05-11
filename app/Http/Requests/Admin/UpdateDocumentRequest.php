<?php

namespace App\Http\Requests\Admin;

class UpdateDocumentRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'thumbnail' => $this->imageRules('nullable'),
            'pdf' => $this->pdfRules('nullable'),
        ];
    }
}
