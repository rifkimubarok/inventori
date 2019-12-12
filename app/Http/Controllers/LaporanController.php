<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang_keluar;
use App\Barang_keluar_detail;
use App\Barang_masuk;
use App\Barang_masuk_detail;
use DB;

class LaporanController extends Controller
{
    public function keluar()
    {
        return view("dashboard.laporan.keluar");
    }

    public function keluar_report(Request $request)
    {
        $param = $request->all();
        $transaksi_keluar = Barang_keluar::whereBetween("tgl_transaksi",array($param['dari_tgl'],$param['sampai_tgl']))->get();
        $data_transaksi = array();
        foreach($transaksi_keluar as $item){
            $transaksi = new \stdClass;
            $transaksi = $item;
            $transaksi->detail = DB::table("detail_barang_keluar as a")
                                ->join("barang as b","b.id","=","a.barang_id")
                                ->select("a.*","b.nama_barang")->orderby("created_at","desc")
                                ->where(array("a.transaksi_id"=>$item->id))
                                ->get();
            array_push($data_transaksi,$transaksi);
        }
        return view("dashboard.laporan.table_keluar",compact("data_transaksi"));
    }
}
