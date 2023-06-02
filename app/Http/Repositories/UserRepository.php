<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    public function create($data)
    {
        try {
           return User::create($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateUser($email, $data)
    {
        try {
            return User::where('email', $email)->update($data);
         } catch (\Exception $e) {
             return $e->getMessage();
         }
    }
}
