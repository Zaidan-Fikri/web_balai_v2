<?php

namespace App\Http\Requests\Admin;

class StoreDocumentRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }
}
