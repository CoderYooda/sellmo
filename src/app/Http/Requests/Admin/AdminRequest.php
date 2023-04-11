<?php

namespace App\Http\Requests\Admin;

use App\Models\Company;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Текущий пользователь
     * @param $guard
     * @return User
     */
    public function user($guard = null): User
    {
        return parent::user($guard);
    }

    /**
     * Профиль текущего пользователя
     * @param $guard
     * @return Person
     */
    public function person($guard = null): Person
    {
        return $this->user($guard)->person;
    }

    /**
     * Компания текущего пользователя
     * @param $guard
     * @return Company
     */
    public function company($guard = null): Company
    {
        return $this->person($guard)->company;
    }
}
