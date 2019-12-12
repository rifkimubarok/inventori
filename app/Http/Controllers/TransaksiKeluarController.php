<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Barang;
use App\Barang_keluar;
use App\Barang_keluar_detail;

class TransaksiKeluarController extends Controller
{

    public function index()
    {
        $barang_keluar = Barang_keluar::orderby("tgl_transaksi","desc")->paginate(10);
        return view("dashboard.transaksi.keluar",compact('barang_keluar'));
    } 

    public function new_transaksi()
    {
        $user_id = Auth::id();
        $have_transaksi = Barang_keluar::where(array("user_id"=>$user_id,"status_transaksi"=>1));
        $data_transaksi;
        if($have_transaksi->count() > 0){
            $data_transaksi = $have_transaksi->first();
        }else{
            $insert = Barang_keluar::create(array("total_barang"=>0,"total_harga"=>0,"user_id"=>$user_id));
            $data_transaksi = Barang_keluar::where(array("id"=>$insert->id))->first();
        }
        
        return view("dashboard.transaksi.keluar_new",compact("data_transaksi"));
    }

    public function detail_transaksi($transaksi_id)
    {
        $detail_transaksi = DB::table("detail_barang_keluar as a")
                                ->join("barang as b","b.id","=","a.barang_id")
                                ->select("a.*","b.nama_barang")->orderby("created_at","desc")
                                ->where(array("a.transaksi_id"=>$transaksi_id))
                                ->get();
        return view("dashboard.transaksi.keluar_detail",compact("detail_transaksi"));
    }

    public function get_row_transaksi($transaksi_id)
    {
        $barang = Barang_keluar::find($transaksi_id);
        $barang->total_harga = number_format($barang->total_harga,0);
        return json_encode($barang);
    }

    public function new_detail(Request $request)
    {
        $param = $request->all();
        $stock = Barang::find($param['barang_id']);
        if($stock->jumlah < $param['jml']){
            return json_encode([
                "status"=>false,
                "message"=>"Stok Tidak Mencukupi"
            ]);
        }else{
            $result = Barang_keluar_detail::create($param);
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
                
    }

    public function save_transaction($transaksi_id)
    {
        $update = Barang_keluar::where("id","=",$transaksi_id)->update(["status_transaksi"=>0]);
        return redirect(route("tr_keluar"));
    }

    public function cancel_transaction($transaksi_id)
    {
        $barang = Barang_keluar::find($transaksi_id);
        $detail = Barang_keluar_detail::where(array("transaksi_id"=>$transaksi_id));
        $detail->delete();
        if($barang->delete()){
            return redirect(route("tr_keluar"));
        }
    }
}
