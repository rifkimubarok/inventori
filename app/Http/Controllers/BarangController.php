<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::orderby("nama_barang","asc")->get();
        return view("dashboard.barang.index",compact('barang'));
    }

    public function list_barang()
    {
        return json_encode(Barang::select("id","nama_barang")->get());
    }

    public function new_barang(Request $request)
    {
        $this->validate($request,[
            'nama_barang'=>"required|min:3",
            'jumlah'=> "required|numeric|min:1",
            'satuan' => "required|min:1"
        ]); 
        $result = Barang::create($request->all());
        if($result){
            return redirect(route('barang'))->with("success","Data barang berhasil ditambahkan.");
        }
    }

    public function update($barang_id)
    {
        $barang = Barang::find($barang_id);
        return view("dashboard.barang.update",compact("barang"));
    }

    public function updating(Request $request,$id)
    {
        $barang = Barang::find($id);
        $barang->update($request->all());
        return redirect(route('barang'))->with("success","Data barang berhasil diupdate.");
    }

    
    public function deleting($id)
    {
        $barang = Barang::find($id);
        $barang->delete();
        return redirect(route('barang'))->with("success","Data barang berhasil dihapus.");
    }
}
