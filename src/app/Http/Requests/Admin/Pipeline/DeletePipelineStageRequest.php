<?php

namespace App\Http\Requests\Admin\Pipeline;

use App\Http\Requests\Admin\AdminRequest;

class DeletePipelineStageRequest extends AdminRequest
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
            'pipeline_stage_id' => ['required', 'integer', 'exists:pipeline_stages,id'],
        ];
    }

    /**
     * @return int
     */
    public function getPipelineStageId(): int
    {
        return $this->validated()['pipeline_stage_id'];
    }
}
