<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateGemRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        $gemId = $this->routeModelId('gem');

        return [
            'judul' => ['required', 'string', 'max:255'],
            'images' => ['nullable', 'array'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => [
                'integer',
                Rule::exists('gem_images', 'id')->where(function ($query) use ($gemId) {
                    $query->where('gem_id', $gemId);
                }),
            ],
        ];
    }
}
