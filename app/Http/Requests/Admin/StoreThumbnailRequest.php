<?php

namespace App\Http\Requests\Admin;

class StoreThumbnailRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'image' => $this->imageRules(maxKilobytes: self::MAX_HERO_IMAGE_KB),
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
