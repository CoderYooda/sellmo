<?php

namespace App\Http\Requests\Admin\Pipeline;

use App\Http\Requests\Admin\AdminRequest;

class CreatePipelineRequest extends AdminRequest
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
            'name' => ['required', 'string', 'max:24'],
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return preg_replace( "/[^a-zA-ZА-Яа-я0-9\s]+/u", '', $this->validated()['name'] );
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return (int) $this->validated()['company_id'];
    }
}
