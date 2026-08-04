<?php

namespace App\Http\Requests\Admin;

use App\Models\Buletin;
use Illuminate\Validation\Rule;

class StoreBuletinRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'kategori_edukasi_id' => ['nullable', 'integer', Rule::exists('kategori_edukasis', 'id')],
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'status' => ['required', Rule::in([Buletin::STATUS_DRAFT, Buletin::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => $this->imageRules(),
        ];
    }
}
