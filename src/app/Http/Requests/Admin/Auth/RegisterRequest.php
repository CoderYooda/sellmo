<?php

namespace App\Http\Requests\Admin\Auth;

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
            'password' => ['required', 'confirmed', 'max:14'],
            'first_name' => ['required', 'max:20'],
            'last_name' => ['required', 'max:20'],
            'middle_name' => ['required', 'max:20'],
            'company_name' => ['required', 'max:28'],
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

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->validated()['company_name'];
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->validated()['password'];
    }
}
