<?php

namespace App\Http\Requests\Admin\Person;

use App\Http\Requests\Admin\AdminRequest;

class CreatePersonRequest extends AdminRequest
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
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'middle_name' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->validated()['first_name'];
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->validated()['last_name'];
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->validated()['middle_name'];
    }
}
