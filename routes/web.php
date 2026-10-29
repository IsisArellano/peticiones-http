<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/productos');

Route::resource('productos', \App\Http\Controllers\ProductoController::class)
    ->except(['show'])
    ->parameters(['productos' => 'id']);
