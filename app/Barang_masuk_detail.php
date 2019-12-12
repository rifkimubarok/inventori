<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang_masuk_detail extends Model
{
    protected $table = "detail_barang_masuk";
    protected $fillable = ["transaksi_id","barang_id","jml","harga_beli"];
}
