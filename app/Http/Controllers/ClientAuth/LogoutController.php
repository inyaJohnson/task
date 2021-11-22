<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    public function __invoke(){
        auth()->logout();
        return response()->success(Response::HTTP_OK, 'Successfully logged out');
    }
}
