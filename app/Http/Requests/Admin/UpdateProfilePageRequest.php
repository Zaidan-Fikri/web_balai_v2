<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateProfilePageRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        $profilePageId = $this->routeModelId('profilePage');

        return [
            'title'      => ['required', 'string', 'max:255'],
            'slug'       => ['nullable', 'string', 'max:255', Rule::unique('profile_pages', 'slug')->ignore($profilePageId)],
            'content'    => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ];
    }
}
