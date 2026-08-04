<?php

namespace App\Http\Requests\Admin;

use App\Models\Buletin;
use Illuminate\Validation\Rule;

class UpdateBuletinRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        $buletinId = $this->routeModelId('buletin');

        return [
            'kategori_edukasi_id' => ['nullable', 'integer', Rule::exists('kategori_edukasis', 'id')],
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'status' => ['required', Rule::in([Buletin::STATUS_DRAFT, Buletin::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
            'images' => ['nullable', 'array'],
            'images.*' => $this->imageRules(),
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => [
                'integer',
                Rule::exists('buletin_images', 'id')->where(function ($query) use ($buletinId) {
                    $query->where('buletin_id', $buletinId);
                }),
            ],
        ];
    }
}
