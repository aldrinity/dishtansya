<?php
use Illuminate\Http\{JsonResponse};

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

Route::get('/', function (): JsonResponse {
    abort(401, 'Login Required');
})->name('home');

Route::get('/ping', function () :JsonResponse{
    return response()->json([
        'details' => 'pong'
    ]);
});

Route::namespace('Auth')->group(function(){
    Route::post('/register',['as'=> 'register', 'uses'=>'RegisterController@create']);
    Route::post('/login',['as'=>'login', 'uses'=>'AuthController@login']);
    Route::post('/logout',['as'=>'logout', 'uses'=>'AuthController@logout'])->middleware('auth');
});
