@extends('layouts/master')

@section('title')
    Transaksi Peminjaman
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Transaksi Peminjaman</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Daftar Transaksi</li>
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
                <h5 class="m-0">Daftar Peminjaman</h5>
            </div>
            <div class="card-body">              
                <div class="row">
                    <div class="col-md-12 mb-3">
                    <a href="{{route('tr_keluar_new')}}"><button class="btn btn-primary float-right"><i class="fas fa-plus"></i> Transaksi Baru</button></a>
                    </div>
                    <div class="col-md-12">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Jumlah Barang</th>
                                    <th>Status</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomor = 0;
                                @endphp
                                @foreach ($barang_keluar as $item)
                                    <tr>
                                    <td>{{$nomor+=1}}</td>
                                    <td>{{$item->tgl_transaksi}}</td>
                                    <td>{{$item->total_barang}}</td>
                                    <td></td>
                                    <td><a href="/transaksi/keluar/detail/{{$item->id}}" data-value="{{$item->id}}" class="btn-detail"><button class="btn btn-primary btn-xs" title="Detail Transaksi"><i class="fas fa-list"></i></button></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                            <div>
                                {{$barang_keluar->links()}}
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


<div class="modal fade" id="detail_transaksi">
        <div class="modal-dialog">
            <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Detail Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body table-responsive">
                
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script src="{{asset('admin/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
$(document).ready(function(){
    $(document).on("click",".btn-return-detail",function(){
        return_detail_barang($(this).attr("data-value"),$(this));
    })
})
$('table').DataTable({
    "columnDefs": [
        { "orderable": false, "targets": [0,3] },
        { "searchable": false, "targets" : [0,3]}
    ]
});
var transaksi_id = 0;
$('table').on("click",".btn-detail",function(e) {
    var url = $(this).attr("href");
    transaksi_id = $(this).attr("data-value");
    $.ajax({
        url:url,
        dataType:"html",
        type:"get",
        data:{
            mode:"preview"
        },
        success:function(result){
            $('.modal-body').html(result);
            $('#detail_transaksi').modal("show");
        }
    })
    return false;
})
function return_detail_barang(id,elmt){
    $.ajax({
        url:"/transaksi/keluar/return/",
        type:"post",
        dataType:"json",
        data:{
            "_token": "{{ csrf_token() }}",
            "transaksi_id":transaksi_id,
            id:id
        },
        success:function(result){
            alert(result.message);
            elmt.attr("disabled",true);
            elmt.text("dikembalikan");
        }
    })
}
</script>
@endsection