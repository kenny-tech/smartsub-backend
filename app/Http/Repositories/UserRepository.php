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
}
