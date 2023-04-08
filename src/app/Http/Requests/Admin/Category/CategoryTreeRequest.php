<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryTreeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
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
            'root_category_id' => ['required'],
            'company_id' => ['required', 'exists:companies,id'],
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
}
