<?php

namespace App\Http\Requests\Admin\Lead\Source;

use App\Http\Requests\Admin\AdminRequest;

class CreateLeadSourceRequest extends AdminRequest
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
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->validated()['name'];
    }
}
