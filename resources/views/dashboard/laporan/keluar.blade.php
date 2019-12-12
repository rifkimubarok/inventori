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
            <h1 class="m-0 text-dark">Laporan Barang Keluar</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Laporan Barang Barang</li>
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
                    <div class="col-md-4 mb-2">
                        <label for="">Dari Tanggal</label>
                        <input class="form-control" type="date" name="dari_tgl" id="dari_tgl">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="">Sampai Tanggal</label>
                        <input class="form-control" type="date" name="sampai_tgl" id="sampai_tgl">
                    </div>
                    <div class="col-md-4 mb-2 d-flex flex-column">
                        <button class="btn btn-success mt-auto col-md-5" id="btn_print"><i class="fas fa-print"></i> Tampilkan</button>
                    </div>
                    <div class="col-md-12 table-responsive" id="laporan_content">
                        
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
    $('#btn_print').click(function(){
        $.ajax({
            url : "{{route('laporan_keluar_show')}}",
            dataType:"html",
            type:"post",
            data:{
                "_token": "{{ csrf_token() }}",
                dari_tgl : $('#dari_tgl').val(),
                sampai_tgl : $('#sampai_tgl').val()
            },
            success:function(result){
                $('#laporan_content').html(result);
            }
        })
    })
</script>
@endsection