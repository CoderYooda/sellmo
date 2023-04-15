<?php

namespace App\Http\Requests\Admin\Person;

use App\Http\Requests\Admin\AdminRequest;

class UpdatePersonRequest extends AdminRequest
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
            'person_id' => ['required', 'integer', 'exists:persons,id'],
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'middle_name' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * @return int
     */
    public function getPersonId(): int
    {
        return $this->validated()['person_id'];
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
