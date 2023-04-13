<?php

namespace App\Http\Requests\Admin\Pipeline;

use App\Http\Requests\Admin\AdminRequest;

class UpdatePipelineStageRequest extends AdminRequest
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
            'name' => ['required', 'string', 'regex:/^[a-zA-ZА-Яа-я0-9 ]+$/u', 'max:24'],
            'order' => ['integer'],
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->validated()['name'];
    }

    /**
     * @return int
     */
    public function getPipelineStageId(): int
    {
        return $this->validated()['pipeline_stage_id'];
    }

    /**
     * @return ?string
     */
    public function getOrder(): ?string
    {
        return $this->validated()['order'] ?? null;
    }
}
