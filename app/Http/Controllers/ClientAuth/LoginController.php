<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $client = Client::where('email', $request->email_or_phone)
            ->OrWhere('phone', $request->email_or_phone )->first();

        if(!$client || !Hash::check($request->password, $client->password)){
            return response()->error(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $data = [
            'access_token' => auth()->guard()->login($client),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'client' => new ClientResource($client)
        ];

        return response()->success(Response::HTTP_OK, 'Login Successful', $data);
    }
}
