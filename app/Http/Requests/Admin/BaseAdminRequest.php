<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->session()->has('admin_user_id');
    }

    protected function routeModelId(string $key): ?int
    {
        $value = $this->route($key);

        if (is_object($value) && isset($value->id)) {
            return (int) $value->id;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        return null;
    }
}
