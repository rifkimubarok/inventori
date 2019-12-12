<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang_keluar extends Model
{
    protected $table = "transaksi_barang_keluar";
    protected $fillable = ["total_barang","total_harga","user_id"];
}
