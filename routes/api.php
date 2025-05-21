<?php

use App\Http\Controllers\WhoisController;
use Illuminate\Support\Facades\Route;

Route::get('/whois', [WhoisController::class, 'getWhoisInfo']);
