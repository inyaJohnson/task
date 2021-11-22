<?php

namespace App\Http\Controllers\ClientAuth;

use App\Actions\CreateConsultant;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\ClientResource;
use App\Jobs\RegistrationJob;
use App\Jobs\RegistrationJobAdmin;

class RegisterController extends Controller
{
    public function __invoke(RegistrationRequest $request, CreateConsultant $createConsultant)
    {
        $client = $createConsultant($request);
        RegistrationJob::dispatch($client)->onQueue('task_queue');
        RegistrationJobAdmin::dispatch($client, 'admin@techmozzo.com')->onQueue('task_queue');
        return [
            'access_token' => auth()->guard()->login($client),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new ClientResource($client)
        ];
    }
}
