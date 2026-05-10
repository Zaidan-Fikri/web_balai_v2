<?php

namespace App\Http\Requests\Admin;

class StoreBeritaRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => $this->imageRules(),
        ];
    }
}
