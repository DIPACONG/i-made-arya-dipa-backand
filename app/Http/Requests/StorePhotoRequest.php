<?php

namespace App\Http\Requests;

use App\Models\Photo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Akses sudah dijaga middleware auth:sanctum.
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'integer', 'min:0', 'max:100000000'],
            'status'      => ['required', Rule::in(Photo::STATUSES)],
            'image'       => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }
}
