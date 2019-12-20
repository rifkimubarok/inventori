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
        $barang = Barang::all();
        $output = new \stdClass;
        $output->data_transaksi = $data_transaksi;
        $output->barang = $barang;
        return view("dashboard.transaksi.keluar_new",compact("output"));
    }

    public function detail_transaksi($transaksi_id,Request $request)
    {
        $param = $request->all();
        // $detail_transaksi = DB::table("detail_barang_keluar as a")
        //                         ->join("barang as b","b.id","=","a.barang_id")
        //                         ->select("a.*","b.nama_barang")->orderby("created_at","desc")
        //                         ->where(array("a.transaksi_id"=>$transaksi_id))
        //                         ->get();
        $output = new \stdClass;
        $output->detail_transaksi = Barang_keluar_detail::where(array("transaksi_id"=>$transaksi_id))->get();
        $output->param = $param;
        return view("dashboard.transaksi.keluar_detail",compact("output"));
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
        if(is_null($param['barang_id'])){
            return json_encode([
                "status"=>false,
                "message"=>"Silahkan Pilih Barang"
            ]);
        }
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
        $update = Barang_keluar::where("id","=",$transaksi_id)->update(["status_transaksi"=>2]);
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

    public function delete_item($transaksi_id,Request $request)
    {
        $param = $request->all();
        $barang_detail = Barang_keluar_detail::where(array("transaksi_id"=>$transaksi_id,"id"=>$param['id']));

        if($barang_detail->delete()){
            return json_encode(["status"=>true]);
        }
    }

    public function return_item(Request $request)
    {
        $param = $request->all();
        $transaksi_id = $param['transaksi_id'];
        $id = $param['id'];
        $hasil = Barang_keluar_detail::where(array("transaksi_id"=>$transaksi_id,"id"=>$id))->update(array("isReturn"=>1));
        if($hasil){
            return json_encode([
                "status"=>true,
                "message"=>"berhasil dikembalikan"
            ]);
        }else{
            return json_encode([
                "status"=>false,
                "message"=>"gagal dikembalikan"
            ]); 
        }
    }
}
