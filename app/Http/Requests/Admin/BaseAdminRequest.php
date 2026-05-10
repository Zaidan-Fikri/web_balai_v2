<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

abstract class BaseAdminRequest extends FormRequest
{
    protected const IMAGE_MIMES = ['jpg', 'jpeg', 'png', 'webp'];
    protected const MAX_IMAGE_KB = 5120;
    protected const MAX_HERO_IMAGE_KB = 10240;
    protected const MAX_PDF_KB = 10240;

    public function authorize(): bool
    {
        return $this->session()->has('admin_user_id');
    }

    /**
     * @return array<int, mixed>
     */
    protected function imageRules(string $presence = 'required', int $maxKilobytes = self::MAX_IMAGE_KB): array
    {
        return [
            $presence,
            File::image()
                ->types(self::IMAGE_MIMES)
                ->max($maxKilobytes),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected function pdfRules(string $presence = 'required'): array
    {
        return [
            $presence,
            File::types(['pdf'])->max(self::MAX_PDF_KB),
        ];
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
