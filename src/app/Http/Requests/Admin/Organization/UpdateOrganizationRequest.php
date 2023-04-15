<?php

namespace App\Http\Requests\Admin\Organization;

use App\Http\Requests\Admin\AdminRequest;

class UpdateOrganizationRequest extends AdminRequest
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
            'organization_id' => ['required', 'integer', 'exists:organizations,id'],
            'name' => ['required', 'string', 'regex:/^[a-zA-ZА-Яа-я0-9 ]+$/u', 'max:24'],
        ];
    }

    /**
     * @return int
     */
    public function getOrganizationId(): int
    {
        return $this->validated()['organization_id'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->validated()['name'];
    }
}
