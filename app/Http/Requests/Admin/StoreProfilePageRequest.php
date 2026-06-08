<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class StoreProfilePageRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'max:255'],
            'slug'       => ['nullable', 'string', 'max:255', Rule::unique('profile_pages', 'slug')],
            'content'    => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ];
    }
}
