<?php

namespace App\Http\Requests;

use App\Models\Photo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Kepemilikan dicek lewat PhotoPolicy di controller.
    }

    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', 'integer', 'exists:categories,id'],
            'title'       => ['sometimes', 'string', 'max:150'],
            'description' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'price'       => ['sometimes', 'integer', 'min:0', 'max:100000000'],
            'status'      => ['sometimes', Rule::in(Photo::STATUSES)],
            'image'       => ['sometimes', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }
}
