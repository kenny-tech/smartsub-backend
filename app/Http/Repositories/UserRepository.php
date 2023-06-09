<?php

namespace App\Http\Repositories;

use App\Models\User;
use Carbon\Carbon;

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

    public function verifyUserToken($email_token)
    {
        try {
            return User::where('email_token', $email_token)->first();
         } catch (\Exception $e) {
             return $e->getMessage();
         }
    }

    public function activateAccount($email)
    {
        try {
            return User::where('email', $email)->update(['active' => 1, 'email_verified_at' => Carbon::now(), 'email_token' => null]);
         } catch (\Exception $e) {
             return $e->getMessage();
         }
    }
}
