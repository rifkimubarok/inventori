<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = "barang";
    protected $fillable = ["nama_barang","jumlah","satuan","harga_beli","harga_jual"];
}
