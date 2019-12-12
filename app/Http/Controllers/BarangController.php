<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::orderby("jumlah","asc")->get();
        return view("dashboard.barang.index",compact('barang'));
    }

    public function list_barang()
    {
        return json_encode(Barang::select("id","nama_barang")->get());
    }

    public function new_barang(Request $request)
    {
        $result = Barang::create($request->all());
        if($result){
            return redirect(route('barang'));
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
        return redirect(route('barang'));
    }
}
