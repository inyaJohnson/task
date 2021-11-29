<?php

namespace App\Http\Controllers;

use App\Actions\CreateMessage;
use App\Actions\FindMessage;
use App\Http\Requests\MessageRequest;
use App\Jobs\MessageAdminJob;
use App\Jobs\MessageJob;
use App\Models\Message;
use Symfony\Component\HttpFoundation\Response;

class ClientMessageController extends Controller
{
    public function index()
    {
        $client = auth('client')->user();
        $messages = Message::with('documents:id,message_id,url')->where([['client_id', $client->id], ['consultant_id', $client->consultant_id]])->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['messages' => $messages]);
    }

    public function store(MessageRequest $request, CreateMessage $createMessage)
    {
        $client = auth('client')->user();
        $data = ['consultant_id' => $client->consultant_id, 'client' => $client->id, 'title' => $request->title, 'message' => $request->message, 'sender' => 'Client', 'documents' => $request->documents ?? null];
        $message = $createMessage($data, $client->id);
        MessageJob::dispatch($client)->onQueue('task_queue');
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }

    public function show($id, FindMessage $findMessage)
    {
        $message = $findMessage->__invoke($id);
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }
}
