<?php

use Illuminate\Support\Facades\Route;
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

Auth::routes(['verify' => true, 'register' => false]);

Route::get('/', function () {
    return view('admin::auth.login');
})->middleware('guest');

Route::get('auth/check', 'Auth\CheckController@index')->name('auth.check');

Route::group(['middleware'=>['auth', 'twofactor']], function() {
    Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
    Route::get('verify/cancel', 'Auth\TwoFactorController@cancel')->name('verify.cancel');
    Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);
    Route::view('master', 'master');
    
    Route::view('analyst', 'analyst')->name('analyst'); 
});

Route::get('storage/fully_manual/{filename}', function ($filename)
{
    $path = storage_path('app/fully_manual/photos/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
}, [ 'as' => 'storage.fully_manual']);

Route::get('storage/{filename}/{folder:?}/{subfolder:?}', 'StorageController@displayImage')->name('storage.image');

//Word Meaning
Route::get('words/meaning/{word:?}/{form_search:?}', [ 'as' => 'words.meaning', 'uses' => 'WordController@meaning']);

//RSS FEED
Route::get('/feed', 'RssFeedController@generate_rss_feed')->name('file');
Route::get('/api/completed_reports', 'ApiController@completed_reports');