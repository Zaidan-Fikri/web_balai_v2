<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateBeritaRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        $beritaId = $this->routeModelId('berita');

        return [
            'judul'            => ['required', 'string', 'max:255'],
            'deskripsi'        => ['required', 'string'],
            'tanggal_publish'  => ['nullable', 'date'],
            'images'           => ['nullable', 'array'],
            'images.*'         => $this->imageRules(),
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => [
                'integer',
                Rule::exists('berita_images', 'id')->where(function ($query) use ($beritaId) {
                    $query->where('berita_id', $beritaId);
                }),
            ],
            'video'            => $this->videoRules('nullable'),
            'video_orientasi'  => ['nullable', 'in:landscape,portrait'],
            'remove_video'     => ['nullable', 'boolean'],
        ];
    }
}
