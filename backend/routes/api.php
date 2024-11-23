<?php

use App\Leads\Http\CreateContact\CreateContactAction;
use App\Leads\Http\ListAction;
use Illuminate\Support\Facades\Route;

Route::get('/leads', ListAction::class);
Route::post('/contact/{leadID}', CreateContactAction::class);

