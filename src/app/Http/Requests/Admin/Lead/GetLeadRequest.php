<?php

namespace App\Http\Requests\Admin\Lead\Type;

use App\Http\Requests\Admin\AdminRequest;

class GetLeadRequest extends AdminRequest
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
            'pipeline_id' => ['required', 'exists:pipelines,id']
        ];
    }

    /**
     * @return int
     */
    public function getPipelineId(): int
    {
        return $this->validated()['pipeline_id'];
    }
}
