<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Permission;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'company_id' => ['required'],
            'name' => ['required', 'string', 'max:24'],
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
     * @return string
     */
    public function getName(): string
    {
        return preg_replace( "/[^a-zA-ZА-Яа-я0-9\s]+/u", '', $this->validated()['name'] );
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
    public function canCreateCategory(): bool
    {
        return $this->user()->can(Permission::CAN_CREATE_CATEGORY);
    }
}
