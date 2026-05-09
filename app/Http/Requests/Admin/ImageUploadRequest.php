<?php

namespace App\Http\Requests\Admin;

class ImageUploadRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }
}
