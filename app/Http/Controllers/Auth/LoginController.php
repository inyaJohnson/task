<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->email_or_phone)
            ->OrWhere('phone', $request->email_or_phone )->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->error(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $data = [
            'access_token' => auth()->guard()->login($user),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource($user)
        ];

        return response()->success(Response::HTTP_OK, 'Login Successful', $data);
    }
}
