<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function store(string $name, string $email, string $password): User
    {
        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }
}
