<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', 'PGPController@index')
    ->name('home');


Route::post('provisional-auth', 'PGPController@provisionalAuth')
    ->name('provisional.auth');


Route::get('/verifyemail/{token}','PGPController@verify')
    ->name('verify.email');



// debug
if (config('app.env', false)) {

    // 送信メール本文のプレビュー
    Route::get('preview-mail', function () {
        return new App\Mail\ProvisionalAuthNotification('dummy_token_juhgyfttgyhujijihugyftdr');
    });

}