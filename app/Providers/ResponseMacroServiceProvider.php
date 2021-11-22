<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function($status, $message,  $data = null){
            $result = ['success' => true, 'message' => $message];
            if($data !== null) $result['data'] = $data;
            return \response()->json($result, $status);
        });

        Response::macro('error', function($status, $message, $errors = null){
            $result = ['success' => false, 'message' => $message];
            if($errors !== null) $result['errors'] = $errors;
            return \response()->json($result, $status);
        });
    }
}
