<?php

namespace App\Actions;

use App\Models\Message;

class CreateMessage{
    public function __invoke($data, $clientId)
    {
        $message = Message::create([
            'consultant_id' => $data['consultant_id'],
            'client_id' => $clientId,
            'title' => $data['title'],
            'message' => $data['message'],
            'sender' => 'company'
        ]);

        if($data['documents'] !== null){
            foreach($data['documents'] as $document){
                $message->documents()->create([
                    'consultant_id' => $data['consultant_id'],
                    'client_id' => $clientId,
                    'url' => $document
                ]);
            }
        }

        return $message;
    }
}
