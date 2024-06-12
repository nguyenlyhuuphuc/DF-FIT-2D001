<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:255',
            'slug' => 'required',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ten buoc phai nhap!',
            'name.min' => 'Ten it nhat phai co 3 ky tu',
            'name.max' => 'Ten nhieu nhat phai chi co 255 ky tu', 
        ];
    }
}
