<?php

namespace App\Http\Requests\Admin;

class UpdateGaleriTileRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'image'            => $this->imageRules('nullable', self::MAX_HERO_IMAGE_KB),
            'background_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }
}
