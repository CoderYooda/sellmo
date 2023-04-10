<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class CategoryTreeRequest extends FormRequest
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
            'root_category_id' => ['integer'],
            'company_id' => ['required_if:force,false'],
            'force' => ['bool'],
        ];
    }

    /**
     * @return int|bool
     */
    public function getRootCategoryId(): int|bool
    {
        return $this->validated()['root_category_id'] ?? false;
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
    public function isForce(): bool
    {
        return $this->validated()['force'] ?? false;
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'company_id' => "Нет доступа к компании"
        ];
    }

    /**
     * @return bool
     */
    public function canAccessIfForce(): bool
    {
        return $this->isForce() ? $this->user()->can(Permission::CAN_VIEW_CATEGORY_TREE_FORCE) : true;
    }
}
