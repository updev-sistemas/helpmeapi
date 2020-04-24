<?php

use Illuminate\Support\Facades\Route;

Route::any("/", function(){
    return response()->json([
        'message'=>"Plataforma Versão " . env('APP_VERSION'),
        'app'=>'Help me',
        'description'=>'Software Helpdesk'
    ]);
});

