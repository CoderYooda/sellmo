<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\Admin\AdminRequest;

class UpdateCategoryRequest extends AdminRequest
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
            'parent_id' => ['required', 'integer', 'exists:categories,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['string', 'max:24'],
        ];
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->validated()['parent_id'];
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->validated()['category_id'];
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        if(!isset($this->validated()['name'])){
            return null;
        }

        return preg_replace( "/[^a-zA-ZА-Яа-я0-9\s]+/u", '', $this->validated()['name'] );
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return (int) $this->validated()['company_id'];
    }
}
