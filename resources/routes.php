<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return ['laravel'];
});

Artisan::command('inspire', function () {

    $this->comment('pest');
});
