<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('owner.login');
});

Route::get('/owner/dashboard', function () {
    return view('owner.dashboard');
});
