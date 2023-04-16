<?php

namespace App\Http\Requests\Admin\Product;

use App\Http\Requests\Admin\AdminRequest;

class CreateProductRequest extends AdminRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'regex:/^[a-zA-ZА-Яа-я0-9 ]+$/u', 'max:24'],
            'sku' => ['required', 'string', 'regex:/^[a-zA-ZА-Яа-я0-9 ]+$/u', 'max:24'],
            'type' => ['required', 'string', 'regex:/^[a-zA-ZА-Яа-я0-9 ]+$/u', 'max:24'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->validated()['name'];
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->validated()['sku'];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->validated()['type'];
    }

    /**
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->validated()['category_id'];
    }
}
