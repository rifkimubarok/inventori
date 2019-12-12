@extends('layouts/master')

@section('title')
    Master Barang
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Data Barang</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-lg-12">
            <div class="card">
            <div class="card-header">
                <h5 class="m-0">Data Barang</h5>
            </div>
            <div class="card-body">              
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <a href="/barang/insert"><button class="btn btn-primary float-right"> <i class="fas fa-plus"></i> Tambah Barang</button></a>
                    </div>
                    <div class="col-md-12 table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomor = 0;
                                @endphp
                                @foreach ($barang as $item)
                                    <tr>
                                        <td>{{$nomor +=1}}</td>
                                        <td>{{$item->nama_barang}}</td>
                                        <td>{{$item->jumlah}}</td>
                                        <td>{{$item->harga_jual}}</td>
                                        <td><a href="{{route('barang_update',$item->id)}}"><button class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></button></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>#</th>
                                </tr>
                            </tfoot>
                            </table>
                            <div>
                                {{-- {{$barang->links()}} --}}
                            </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('javascript')
<script src="{{asset('admin/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
$('table').DataTable();
</script>
@endsection