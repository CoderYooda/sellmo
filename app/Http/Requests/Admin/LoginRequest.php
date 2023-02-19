<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
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
            'email' => ['required', 'email', 'max:28'],
            'password' => ['required']
        ];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->validated()['email'];
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->validated()['password'];
    }
}
