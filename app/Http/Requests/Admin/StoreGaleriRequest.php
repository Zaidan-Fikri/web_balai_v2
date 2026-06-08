<?php

namespace App\Http\Requests\Admin;

class StoreGaleriRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'judul'              => ['required', 'string', 'max:255'],
            'deskripsi'          => ['nullable', 'string', 'max:1000'],
            'type'               => ['required', 'in:foto,video'],
            'image'              => $this->imageRules(maxKilobytes: self::MAX_HERO_IMAGE_KB),
            'extra_images'       => ['nullable', 'array', 'max:10'],
            'extra_images.*'     => $this->imageRules('nullable', self::MAX_HERO_IMAGE_KB),
            'background_color'   => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }
}
