<?php

namespace App\Http\Requests\Admin\Organization;

use App\Http\Requests\Admin\AdminRequest;

class DeleteOrganizationRequest extends AdminRequest
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
        ];
    }

    /**
     * @return int
     */
    public function getOrganizationId(): int
    {
        return $this->validated()['organization_id'];
    }
}
