<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users', 'max:28'],
            'password' => ['required', 'confirmed', 'max:14']
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->validated()['name'] ?? stristr($this->getEmail(), '@', true);
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
