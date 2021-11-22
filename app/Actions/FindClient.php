<?php

namespace App\Actions;

use App\Models\Client;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FindClient{
    public function __invoke($clientId){
        $client = Client::with('consultant','directors','subsidiaries')->where('id', $clientId)->when(auth()->check(), function($query){
            return $query->where('consultant_id', auth()->user()->id);
        })->select('id', 'is_verified', 'consultant_id', 'name', 'email', 'phone', 'address', 'registered_address', 'is_public_entity', 'nature_of_business', 'doubts')->first();
        if($client == null){
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Client does not exist'));
        }else{
            return $client;
        }
    }
}
