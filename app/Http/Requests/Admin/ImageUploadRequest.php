<?php

namespace App\Http\Requests\Admin;

class ImageUploadRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'image' => $this->imageRules(),
        ];
    }
}
