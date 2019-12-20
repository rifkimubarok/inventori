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
    
    Route::get("/logout","LoginController@logout")->name("logout");

    // CRUD Barang
    Route::get("/barang","BarangController@index")->name("barang");
    Route::get("/barang/api","BarangController@list_barang")->name("barang_api");
    Route::get("/barang/insert",function()
    {
        return view("dashboard.barang.insert");
    })->name("barang_insert");
    Route::post("/barang/inserting","BarangController@new_barang")->name("barang_new");
    Route::get("/barang/update/{barang_id}","BarangController@update")->name("barang_update");
    Route::post("/barang/{id}/updating","BarangController@updating")->name("barang_updated");
    Route::post("/barang/{id}/delete","BarangController@deleting")->name("barang_delete");

    // Transaksi Masuk
    Route::get("/transaksi/masuk","TransaksiMasukController@index")->name("tr_masuk");
    Route::get("transaksi/masuk/new","TransaksiMasukController@new_transaksi")->name("tr_masuk_new");
    Route::get("transaksi/masuk/detail/{transaksi_id}","TransaksiMasukController@detail_transaksi")->name("tr_masuk_det");
    Route::post("transaksi/masuk/new_detail","TransaksiMasukController@new_detail")->name("tr_new_detail");
    Route::get("transaksi/masuk/save_tr/{transaksi_id}","TransaksiMasukController@save_transaction")->name("tr_masuk_save");
    Route::get("transaksi/masuk/show/{transaksi_id}","TransaksiMasukController@get_row_transaksi")->name("show_tr_masuk");
    Route::get("transaksi/masuk/cancel/{transaksi_id}","TransaksiMasukController@cancel_transaction")->name("cancel_tr_masuk");
    Route::post("transaksi/masuk/delete/{transaksi_id}","TransaksiMasukController@delete_item")->name("delete_tr_masuk");

    // Transaksi Keluar
    Route::get("/transaksi/keluar","TransaksiKeluarController@index")->name("tr_keluar");
    Route::get("transaksi/keluar/new","TransaksiKeluarController@new_transaksi")->name("tr_keluar_new");
    Route::get("transaksi/keluar/detail/{transaksi_id}","TransaksiKeluarController@detail_transaksi")->name("tr_keluar_det");
    Route::post("transaksi/keluar/new_detail","TransaksiKeluarController@new_detail")->name("tr_keluar_detail");
    Route::get("transaksi/keluar/save_tr/{transaksi_id}","TransaksiKeluarController@save_transaction")->name("tr_keluar_save");
    Route::get("transaksi/keluar/show/{transaksi_id}","TransaksiKeluarController@get_row_transaksi")->name("show_tr_keluar");
    Route::get("transaksi/keluar/cancel/{transaksi_id}","TransaksiKeluarController@cancel_transaction")->name("cancel_tr_keluar");
    Route::get("transaksi/keluar/cancel/{transaksi_id}","TransaksiKeluarController@cancel_transaction")->name("cancel_tr_keluar");
    Route::post("transaksi/keluar/delete/{transaksi_id}","TransaksiKeluarController@delete_item")->name("delete_tr_keluar");
    Route::post("transaksi/keluar/return/","TransaksiKeluarController@return_item")->name("return_tr_keluar");

    // Laporan
    Route::get("/Laporan/masuk","LaporanController@masuk")->name("laporan_masuk");
    Route::get("/Laporan/keluar","LaporanController@keluar")->name("laporan_keluar");
    Route::post("/Laporan/keluar/show","LaporanController@keluar_report")->name("laporan_keluar_show");
});