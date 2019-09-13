<?php
use \Illuminate\Support\Facades\Route;
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
Route::group(['namespace'=>'Front'], function () {
    Route::get('/', 'MainController@index')->name('home');
    Route::any('/signin', 'SignController@in')->name('signin');
    Route::any('/signup', 'SignController@up')->name('signup');
    Route::any('/signout', 'SignController@out')->name('signout');
    Route::get('/oauth/facebook', 'OAuthController@facebook')->name('oauth_facebook');

    Route::get('/oauth/google', 'OAuthController@google')->name('oauth_google');

    Route::any('/oauth/facebook/redirect', 'OAuthController@facebookRedirect')->name('oauth_facebook_redirect');

    Route::any('/oauth/google/redirect', 'OAuthController@googleRedirect')->name('oauth_google_redirect');
    Route::any('/oauth/bind','OAuthController@bind')->name('oauth_bind');
    Route::any('/oauth/bind/signup','OAuthController@bindSignup')->name('oauth_binding_signup');
    Route::get('/member/{memberById}', function (\App\Models\Member $memberById) {
        var_dump($memberById);
    });
});
