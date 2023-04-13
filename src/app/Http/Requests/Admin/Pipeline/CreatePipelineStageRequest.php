<?php

namespace App\Http\Requests\Admin\Pipeline;

use App\Http\Requests\Admin\AdminRequest;

class CreatePipelineStageRequest extends AdminRequest
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
            'name' => ['required', 'string', 'regex:/^[a-zA-ZА-Яа-я0-9 ]+$/u', 'max:24'],
            'order' => ['integer'],
            'pipeline_id' => ['integer', 'exists:pipelines,id'],
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
     * @return ?string
     */
    public function getOrder(): ?string
    {
        return $this->validated()['order'] ?? null;
    }

    /**
     * @return int
     */
    public function getPipelineId(): int
    {
        return (int) $this->validated()['pipeline_id'];
    }
}
