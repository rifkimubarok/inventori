<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang_masuk extends Model
{
    protected $table = "transaksi_barang_masuk";
    protected $fillable = ["total_barang","total_harga","user_id"];

}
