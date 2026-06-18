<?php

namespace App\Http\Requests\Admin;

class UpdateGaleriRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'kategori'           => ['nullable', 'string', 'max:255'],
            'judul'              => ['required', 'string', 'max:255'],
            'deskripsi'          => ['nullable', 'string', 'max:1000'],
            'type'               => ['required', 'in:foto,video'],
            'image'              => $this->imageRules('nullable', self::MAX_HERO_IMAGE_KB),
            'video'              => $this->videoRules('nullable'),
            'remove_video'       => ['nullable', 'boolean'],
            'extra_images'       => ['nullable', 'array', 'max:50'],
            'extra_images.*'     => $this->imageRules('nullable', self::MAX_HERO_IMAGE_KB),
            'tanggal_publish'    => ['nullable', 'date'],
            'background_color'   => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }
}
