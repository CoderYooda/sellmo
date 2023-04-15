<?php

namespace App\Http\Requests\Admin\Lead\Type;

use App\Http\Requests\Admin\AdminRequest;

class DeleteLeadTypeRequest extends AdminRequest
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
            'lead_type_id' => ['required', 'integer', 'exists:lead_types,id'],
        ];
    }

    /**
     * @return int
     */
    public function getLeadTypeId(): int
    {
        return $this->validated()['lead_type_id'];
    }
}
