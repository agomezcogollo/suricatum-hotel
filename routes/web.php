<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TravelController;
use App\Http\Controllers\Api\V1\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [ClientController::class, 'viewfrontClients'])->name('clients');
Route::get('/travels', [TravelController::class, 'viewfrontTravels'])->name('travels');
Route::post('/deleteClients', [ClientController::class, 'destroyform'])->name('deleteClients');
