<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request)
    {
        $data = response()->error(Response::HTTP_BAD_REQUEST, 'Your password is incorrect');
        if(Hash::check($request->old_password, auth('client')->user()->password)){
            auth('client')->user()->update(['password' => bcrypt($request->new_password)]);
            $data = response()->success(Response::HTTP_OK, 'Password reset was successful' );
        }
        return $data;
    }
}
