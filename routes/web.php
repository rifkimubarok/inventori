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
    return redirect("/dashboard");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware'=>'auth'],function(){
    Route::get("/dashboard","DashboardController@index")->name("dashboard");
    Route::get("/barang","BarangController@index")->name("barang");
    Route::get("/supplier","SupplierController@index")->name("supplier");
    Route::get("/transaksi/masuk","TransaksiMasukController@index")->name("tr_masuk");
    Route::get("/transaksi/keluar","TransaksiKeluarController@index")->name("tr_keluar");
});