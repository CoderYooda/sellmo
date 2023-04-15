<?php

namespace App\Http\Requests\Admin\Person;

use App\Http\Requests\Admin\AdminRequest;

class DeletePersonRequest extends AdminRequest
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
        ];
    }

    /**
     * @return int
     */
    public function getPersonId(): int
    {
        return $this->validated()['person_id'];
    }
}
