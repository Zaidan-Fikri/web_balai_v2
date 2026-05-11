<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateSiatabRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        $siatabId = $this->routeModelId('siatab');

        return [
            'judul' => ['required', 'string', 'max:255'],
            'images' => ['nullable', 'array'],
            'images.*' => $this->imageRules(),
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => [
                'integer',
                Rule::exists('siatab_images', 'id')->where(function ($query) use ($siatabId) {
                    $query->where('siatab_id', $siatabId);
                }),
            ],
        ];
    }
}
