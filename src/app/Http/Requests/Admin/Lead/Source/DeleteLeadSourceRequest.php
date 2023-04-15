<?php

namespace App\Http\Requests\Admin\Lead\Source;

use App\Http\Requests\Admin\AdminRequest;

class DeleteLeadSourceRequest extends AdminRequest
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
            'lead_source_id' => ['required', 'integer', 'exists:pipeline_stages,id'],
        ];
    }

    /**
     * @return int
     */
    public function getLeadSourceId(): int
    {
        return $this->validated()['lead_source_id'];
    }
}
