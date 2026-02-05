<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Obtenemos el ID del producto desde la ruta
        // /products/{product}, $this->product devuelve el ID o el modelo
        $productId = $this->route('product');

        return [
            'barcode' => ['required', 'string', 'max:255', Rule::unique('products', 'barcode')->ignore($productId)],
            'name' => 'required|string|max:255',
            'brand_id'    => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',

        ];
    }
}
 