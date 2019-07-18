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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Below is the index page for Animals
Route::resource('animals','AnimalController');


//Below is the submit button for Adoption Requests
Route::get('/submitRequest/{animalID}','AdoptRequestController@submitRequest')->name('request');
//Below is the index page for Adoption Requests
Route::get('adoptionRequests','AdoptRequestController@index');
//Below is the deny button for Adoption Requests
Route::get('/denyRequest/{AdoptionID}','AdoptRequestController@denyRequest');
//Below is the approve button for Adoption Requests
Route::get('/approveRequest/{AdoptionID}','AdoptRequestController@approveRequest');
//Below is the new delete button for Adoption Requests
Route::delete('/deleteRequest/{AdoptionID}', 'AdoptRequestController@destroy');
