<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;

class ProductRequest extends FormRequest
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
    public function rules()
    {
        $product = $this->route('product'); // Access the product ID from the route parameter.

        return [
            'name'                      => 'required|string|unique:products,name,' . $product . '|max:255',
            'sku_code'                  => 'nullable|string|max:150|unique:products,sku_code,' . $product,
            'mf_code'                   => 'nullable|string|max:150|unique:products,mf_code,' . $product,
            'product_code'              => 'nullable|string|max:150',
            'barcode_id'                => 'nullable|string|max:150',
            'tags'                      => 'nullable|json',
            'color'                     => 'nullable',
            'short_description'         => 'nullable|string',
            'overview'                  => 'nullable|string',
            'description'               => 'nullable|string',
            'specification'             => 'nullable|string',
            'warranty'                  => 'nullable|string',
            'thumbnail'                 => 'nullable|image|mimes:png,jpg,jpeg|max:3072', // Make this nullable if it’s not required
            'box_stock'                 => 'nullable|numeric',
            'stock'                     => 'nullable|numeric',
            'box_contains'              => 'nullable|numeric',
            'box_price'                 => 'nullable|numeric',
            'box_discount_price'        => 'nullable|numeric',
            'unit_price'                => 'nullable|numeric',
            'unit_discount_price'       => 'nullable|numeric',
            'discount'                  => 'nullable|numeric',
            'deal'                      => 'nullable|string|max:50',
            'is_refurbished'            => 'nullable|in:0,1',
            'product_type'              => 'nullable|string|max:50',
            'category_id'               => 'nullable|exists:categories,id',
            'brand_id'                  => 'nullable|exists:brands,id',
            'create_date'               => 'nullable|date',
            'action_status'             => 'nullable|string|max:50',
            'added_by'                  => 'nullable|string|max:255',
            'status'                    => 'required|in:published,draft,inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sku_code.unique'                   => 'The SKU Code has already been taken.',
            'mf_code.unique'                    => 'The Manufacturer Code has already been taken.',
            'name.required'                     => 'The Product Name field is required.',
            'name.max'                          => 'The Product Name may not be greater than :max characters.',
            'sku_code.max'                      => 'The SKU Code may not be greater than :max characters.',
            'mf_code.max'                       => 'The Manufacturer Code may not be greater than :max characters.',
            'product_code.max'                  => 'The Product Code may not be greater than :max characters.',
            'tags.json'                         => 'The Tags field must be a valid JSON.',
            'color.json'                        => 'The Color field must be a valid JSON.',
            'short_description.max'             => 'The Short Description may not be greater than :max characters.',
            'overview.max'                      => 'The Overview may not be greater than :max characters.',
            'specification.max'                 => 'The Specification may not be greater than :max characters.',
            'thumbnail.max'                     => 'The Thumbnail may not be greater than :max KB.',
            'is_refurbished.in'                 => 'The Refurbished field must be either 0 or 1.',
            'product_type.max'                  => 'The Product Type may not be greater than :max characters.',
            'category_id.exists'                => 'The selected Category is invalid.',
            'brand_id.exists'                   => 'The selected Brand is invalid.',
            'status.required'                   => 'The Status field is required.',
            'status.in'                         => 'The selected Status is invalid.',
            'create_date.date'                  => 'The Create Date must be a valid date.',
            'added_by.max'                      => 'The Added By field may not be greater than :max characters.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'               => 'Product Name',
            'slug'               => 'Slug',
            'sku_code'           => 'SKU Code',
            'mf_code'            => 'Manufacturer Code',
            'product_code'       => 'Product Code',
            'tags'               => 'Tags',
            'barcode_id'         => 'Barcode ID',
            'short_description'  => 'Short Description',
            'overview'           => 'Overview',
            'description'        => 'Description',
            'specification'      => 'Specification',
            'warranty'           => 'Warranty',
            'thumbnail'          => 'Thumbnail',
            'box_stock'          => 'Box Stock',
            'stock'              => 'Stock',
            'box_price'          => 'Box Price',
            'box_discount_price' => 'Box Discount Price',
            'unit_price'         => 'Unit Price',
            'unit_discount_price'=> 'Unit Discount Price',
            'discount'           => 'Discount',
            'deal'               => 'Deal',
            'is_refurbished'     => 'Refurbished',
            'product_type'       => 'Product Type',
            'category_id'        => 'Category',
            'brand_id'           => 'Brand',
            'status'             => 'Status',
            'create_date'        => 'Create Date',
            'added_by'           => 'Added By',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $this->recordErrorMessages($validator);
        parent::failedValidation($validator);
    }

    /**
     * Record the error messages displayed to the user.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function recordErrorMessages(Validator $validator)
    {
        $errorMessages = $validator->errors()->all();

        foreach ($errorMessages as $errorMessage) {
            Session::flash('error', $errorMessage);
        }
    }
}
