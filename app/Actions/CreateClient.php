<?php

namespace App\Actions;

use App\Jobs\CreateClientJob;
use App\Models\Client;

class CreateClient
{
    public function store($request)
    {
        $consultant = auth()->user();
        $password = uniqid();
        $client = Client::create([
            'consultant_id' => $consultant->id,
            'password' => $password,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'registered_address' => $request->registered_address,
            'is_public_entity' => $request->is_public_entity,
            'nature_of_business' => $request->nature_of_business,
            'doubts' => $request->doubts
        ]);

        if(isset($request->directors)) $this->storeDirector($client, $request);
        if(isset($request->subsidiaries)) $this->storeSubsidiary($client, $request);
        CreateClientJob::dispatch($consultant, $client, $password)->onQueue('task_queue');
        return $client;
    }

    private function storeDirector($client, $request)
    {
        foreach ($request->directors as $director) {
            $client->director()->create([
                'consultant_id' => $client->consultant_id,
                'client_id' => $client->client_id,
                'name' => $director['name'],
                'units_held' => $director['units_held'],
                'designation' => $director['designation']
            ]);
        }
    }

    private function storeSubsidiary($client, $request)
    {
        foreach ($request->subsidiaries as $subsidiary) {
            $client->subsidiary()->create([
                'consultant_id' => $client->consultant_id,
                'client_id' => $client->client_id,
                'name' => $subsidiary['name'],
                'percentage_holding' => $subsidiary['percentage_holding'],
                'nature' => $subsidiary['nature'],
                'nature_of_business' => $subsidiary['nature_of_business']
            ]);
        }
    }
}
