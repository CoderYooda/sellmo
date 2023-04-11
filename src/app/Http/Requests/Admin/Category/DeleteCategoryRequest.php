<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\Admin\AdminRequest;

class DeleteCategoryRequest extends AdminRequest
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
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'recursive' => ['required', 'boolean'],
            'move_to' => ['required_if:recursive,true', 'integer', 'exists:categories,id'],
        ];
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->validated()['category_id'];
    }

    /**
     * @return int
     */
    public function getMoveTo(): int
    {
        return $this->validated()['move_to'];
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return (int) $this->validated()['company_id'];
    }

    /**
     * @return bool
     */
    public function getRecursive(): bool
    {
        return (bool) $this->validated()['recursive'];
    }
}
