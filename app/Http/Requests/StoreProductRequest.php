<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'barcode' => 'required|string|max:255|'.Rule::unique('products', 'barcode'), //barcode unico en la tabla products
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'part_number' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return[
            'barcode.unique' => 'Este código de barras ya está registrado en el catálogo.',
            'brand_id.exists' => 'La marca seleccionada no es válida.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
        ];
    }
}
