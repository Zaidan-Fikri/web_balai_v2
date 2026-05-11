<?php

namespace App\Http\Requests\Admin;

class StoreGalleryRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => $this->imageRules(),
        ];
    }
}
