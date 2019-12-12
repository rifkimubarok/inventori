<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Barang_masuk;
use App\Barang_masuk_detail;

class TransaksiMasukController extends Controller
{
    public function index()
    {
        $barang_masuk = Barang_masuk::orderby("tgl_transaksi","desc")->paginate(10);
        return view("dashboard.transaksi.masuk",compact('barang_masuk'));
    }

    public function new_transaksi()
    {
        $user_id = Auth::id();
        $have_transaksi = Barang_masuk::where(array("user_id"=>$user_id,"status_transaksi"=>1));
        $data_transaksi;
        if($have_transaksi->count() > 0){
            $data_transaksi = $have_transaksi->first();
        }else{
            $insert = Barang_masuk::create(array("total_barang"=>0,"total_harga"=>0,"user_id"=>$user_id));
            $data_transaksi = Barang_masuk::where(array("id"=>$insert->id))->first();
        }
        
        return view("dashboard.transaksi.masuk_new",compact("data_transaksi"));
    }

    public function detail_transaksi($transaksi_id)
    {
        $detail_transaksi = DB::table("detail_barang_masuk as a")
                                ->join("barang as b","b.id","=","a.barang_id")
                                ->select("a.*","b.nama_barang")->orderby("created_at","desc")
                                ->where(array("a.transaksi_id"=>$transaksi_id))
                                ->get();
        return view("dashboard.transaksi.masuk_detail",compact("detail_transaksi"));
    }

    public function get_row_transaksi($transaksi_id)
    {
        $barang = Barang_masuk::find($transaksi_id);
        $barang->total_harga = number_format($barang->total_harga,0);
        return json_encode($barang);
    }

    public function new_detail(Request $request)
    {
        $result = Barang_masuk_detail::create($request->all());
        if($result){
            return json_encode([
                "status"=>true,
                "message"=>"Data Berhasil disimpan"
            ]);
        }else{
            return json_encode([
                "status"=>false,
                "message"=>"Unable to save data"
            ]);
        }
    }

    public function save_transaction($transaksi_id)
    {
        $update = Barang_masuk::where("id","=",$transaksi_id)->update(["status_transaksi"=>0]);
        return redirect(route("tr_masuk"));
    }

    public function cancel_transaction($transaksi_id)
    {
        $barang = Barang_masuk::find($transaksi_id);
        $detail = Barang_masuk_detail::where(array("transaksi_id"=>$transaksi_id));
        $detail->delete();
        if($barang->delete()){
            return redirect(route("tr_masuk"));
        }
    }

}
