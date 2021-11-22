<?php

namespace App\Actions;

use App\Models\User;

class CreateConsultant
{
    public function __invoke($request)
    {
        return User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => bcrypt($request['password']),
            'user_type_id' => $request['user_type_id']
        ]);
    }
}
