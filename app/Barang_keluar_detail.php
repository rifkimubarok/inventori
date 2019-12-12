<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang_keluar_detail extends Model
{
    protected $table = "detail_barang_keluar";
    protected $fillable = ["transaksi_id","barang_id","jml"];
}
