<?php

namespace App\Http\Requests\Admin;

class StoreBeritaRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'judul'            => ['required', 'string', 'max:255'],
            'deskripsi'        => ['required', 'string'],
            'images'           => ['nullable', 'array'],
            'images.*'         => $this->imageRules(),
            'video'            => $this->videoRules('nullable'),
            'video_orientasi'  => ['nullable', 'in:landscape,portrait'],
        ];
    }
}
