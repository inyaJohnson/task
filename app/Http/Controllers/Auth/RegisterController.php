<?php

namespace App\Http\Controllers\Auth;

use App\Actions\CreateConsultant;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Jobs\RegistrationJob;
use App\Jobs\RegistrationJobAdmin;

class RegisterController extends Controller
{
    public function __invoke(RegistrationRequest $request, CreateConsultant $createConsultant)
    {
        $user = $createConsultant($request);
        RegistrationJob::dispatch($user)->onQueue('task_queue');
        RegistrationJobAdmin::dispatch($user, 'admin@techmozzo.com')->onQueue('task_queue');
        return [
            'access_token' => auth()->guard()->login($user),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource($user)
        ];
    }
}
