<?php

namespace App\Http\Requests\Admin;

class ThumbnailVisibilityRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'selected_thumbnail_ids' => ['nullable', 'array'],
            'selected_thumbnail_ids.*' => ['integer', 'exists:thumbnails,id'],
        ];
    }
}
