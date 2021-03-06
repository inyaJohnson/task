<?php

namespace App\Http\Controllers;

use App\Actions\CreateClient;
use App\Actions\FindClient;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct()
    // {
    //     $this->middleware('consultant')->only('store');
    // }

    public function index()
    {
        $clients = Client::where('consultant_id', auth()->user()->id)->get();
        return response()->success(Response::HTTP_OK, 'Request successful', ['clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request, CreateClient $createClient)
    {
        $consultant = auth()->user();
        if($consultant->userType->name == 'company' && $consultant->clients->count() > 0){
            $response = response()->error(Response::HTTP_NOT_ACCEPTABLE, 'Company is not allow to have clients');
        }else{
            $client = $createClient->store($request, $consultant);
            $response = response()->success(Response::HTTP_CREATED, 'Client created successfully', ['client' => $client]);
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($clientId, FindClient $findClient)
    {
        $client = $findClient($clientId);
        return response()->success(Response::HTTP_OK, 'Request successfully', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $clientId, FindClient $findClient)
    {
        $client = $findClient($clientId);
        $client->update($request->all());
        return response()->success(Response::HTTP_OK, 'Request successfully', ['client' => $client]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
