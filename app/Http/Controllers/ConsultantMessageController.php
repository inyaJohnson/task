<?php

namespace App\Http\Controllers;

use App\Actions\CreateMessage;
use App\Actions\FindClient;
use App\Actions\FindMessage;
use App\Http\Requests\MessageRequest;
use App\Jobs\MessageAdminJob;
use App\Jobs\MessageJob;
use App\Models\Message;
use Symfony\Component\HttpFoundation\Response;

class ConsultantMessageController extends Controller
{
    public function index($clientId, FindClient $findClient)
    {
        $client = $findClient($clientId);
        $messages = Message::with('documents:id,message_id,url')->where([['client_id', $client->id], ['consultant_id', auth()->user()->id]])->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['messages' => $messages]);
    }

    public function store(MessageRequest $request, $clientId, CreateMessage $createMessage, FindClient $findClient)
    {
        $user = auth()->user();
        $client = $findClient($clientId);
        $data = ['consultant_id' => $user->id, 'user_id' => $user->id, 'title' => $request->title, 'message' => $request->message, 'sender' => 'Consultant', 'documents' => $request->documents ?? null];
        $message = $createMessage($data, $clientId);
        MessageJob::dispatch($client)->onQueue('task_queue');
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }

    public function show($clientId, $id, FindMessage $findMessage)
    {
        $message = $findMessage->__invoke($id);
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }
}
