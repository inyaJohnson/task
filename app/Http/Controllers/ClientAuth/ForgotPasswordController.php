<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\StoreForgotPasswordRequest;
use App\Jobs\ForgotPasswordJob;
use App\Models\Client;
use App\Traits\HashId;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{

    use HashId;

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $data = response()->error(Response::HTTP_NOT_FOUND, 'User email those not exist');
        $client = Client::where('email', $request->email)->first();
        if ($client !== null) {
            $encoded = $this->encrypt($client->id);
            ForgotPasswordJob::dispatch($client, $encoded['data_token'])->onQueue('task_queue');
            $data = response()->success(Response::HTTP_OK, 'An email has been sent to you.');
        }
        return $data;
    }

    public function storeNewPassword(StoreForgotPasswordRequest $request, $id)
    {
        $decoded = $this->decrypt($id);
        $data = response()->error(Response::HTTP_NOT_FOUND, $decoded['message']);
        if (isset($decoded['data_id'])) {
            $client = Client::find($decoded['data_id']);
            $client->update(['password' => bcrypt($request->password)]);
            $data = response()->success(Response::HTTP_OK, 'Password reset successful');
        }
        return $data;
    }
}

