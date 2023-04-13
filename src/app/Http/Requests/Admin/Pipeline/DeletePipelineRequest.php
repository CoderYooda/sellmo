<?php

namespace App\Http\Requests\Admin\Pipeline;

use App\Http\Requests\Admin\AdminRequest;

class DeletePipelineRequest extends AdminRequest
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
            'pipeline_id' => ['required', 'integer', 'exists:pipelines,id'],
        ];
    }

    /**
     * @return int
     */
    public function getPipelineId(): int
    {
        return $this->validated()['pipeline_id'];
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return (int) $this->validated()['company_id'];
    }
}
