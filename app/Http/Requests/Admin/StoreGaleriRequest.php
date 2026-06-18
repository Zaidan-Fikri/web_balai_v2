<?php

namespace App\Http\Requests\Admin;

class StoreGaleriRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'kategori'           => ['nullable', 'string', 'max:255'],
            'judul'              => ['required', 'string', 'max:255'],
            'deskripsi'          => ['nullable', 'string', 'max:1000'],
            'type'               => ['required', 'in:foto,video'],
            'image'              => $this->imageRules('nullable', self::MAX_HERO_IMAGE_KB),
            'images'             => $this->input('type') === 'foto'
                                        ? ['required_without:image', 'array', 'min:1', 'max:50']
                                        : ['nullable', 'array', 'max:50'],
            'images.*'           => $this->imageRules('required', self::MAX_HERO_IMAGE_KB),
            'video'              => $this->input('type') === 'video'
                                        ? $this->videoRules('required')
                                        : $this->videoRules('nullable'),
            'extra_images'       => ['nullable', 'array', 'max:50'],
            'extra_images.*'     => $this->imageRules('nullable', self::MAX_HERO_IMAGE_KB),
            'tanggal_publish'    => ['nullable', 'date'],
            'background_color'   => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required_without' => 'Minimal pilih 1 foto galeri.',
            'images.*.image' => 'File galeri harus berupa gambar.',
            'images.*.max' => 'Ukuran setiap foto galeri maksimal 50 MB.',
        ];
    }
}
