<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateInfografisRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        $infografisId = $this->routeModelId('infografis');

        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => $this->imageRules(),
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => [
                'integer',
                Rule::exists('infografis_images', 'id')->where(function ($query) use ($infografisId) {
                    $query->where('infografis_id', $infografisId);
                }),
            ],
        ];
    }
}
