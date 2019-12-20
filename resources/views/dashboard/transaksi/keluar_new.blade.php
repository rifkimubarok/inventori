@extends('layouts/master')

@section('title')
    Transaksi Barang Keluar
@endsection
@php
    $data_transaksi;
    if(isset($output)){
        $data_transaksi = $output->data_transaksi;
    }
@endphp
@section('css')
<link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">Transaksi Barang Keluar</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Transaksi Barang Keluar</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<input type="hidden" name="id_transaksi" id="id_transaksi" value="{{$data_transaksi->id}}">
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                <h5 class="m-0">Transaksi</h5>
            </div>
            <div class="card-body">              
                <div class="row mb-20">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td width="150px">Tanggal Transaksi</td>
                                <td width="20px">:</td>
                                <td>{{$data_transaksi->tgl_transaksi}}</td>
                            </tr>
                            <tr>
                                <td>Total Barang</td>
                                <td>:</td>
                                <td id="total_barang">{{$data_transaksi->total_barang}}</td>
                            </tr>
                        </table>
                    </div>                    
                    <div class="col-md-12">
                        {{-- <button class="btn btn-primary" id="btn_add"><i class="fas fa-plus"></i> Tambah Barang</button> --}}
                        <button class="btn btn-primary btn-save"><i class="fas fa-save"></i> Simpan Transaksi</button>
                        <button class="btn btn-danger btn-cancel"><i class="fas fa-times"></i> Batal Transaksi</button>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="row">
                            <!-- /.col-md-6 -->
                            <div class="col-md-12">
                                <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Detail Transaksi</h5>
                                </div>
                                <div class="card-body">
                                    <form action="#" method="get" id="frm_add">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="">Barang</label>
                                                <select name="barang" id="barang" class="form-control select2">
                                                        <option value="">Pilih Barang</option>
                                                    @foreach ($output->barang as $item)
                                                        <option value="{{$item->id}}">{{$item->nama_barang}}</option>
                                                    @endforeach
                                                </select>
                                                {{csrf_field()}}
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Jumlah</label>
                                                <input type="number" name="jml" id="jml" class="form-control" min="1" required>
                                            </div>
                                            <div class="col-md-3 d-flex flex-column">
                                                <button type="submit" class="btn btn-primary col-md-6 mt-auto" id="add_new_data"> <i class="fas fa-plus"></i> Tambah</button>
                                            </div>
                                        </div>   
                                    </form>           
                                    <div class="row mb-20">
                                        <div class="col-md-12 table-responsive" id="tbl_detail">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script src="{{asset('admin/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
// $('table').DataTable();
$(document).ready(function(){
    load_data();
    // load_barang();
    $('#barang').select2({
        theme:"bootstrap4"
    });
    $('#btn_add').click(function(e){
        e.preventDefault();
        $('#add_new_barang').modal("show");
    })

    $('#frm_add').submit(function(){
        self.add_new_detail();
        return false;
    })

    $('.btn-save').click(function(){
        save_transaction()
    })
    $('.btn-cancel').click(function(){
        window.location.href = "{{route('cancel_tr_keluar',$data_transaksi->id)}}";
    })

    $(document).on("click",".btn-delete-detail",function(e){
        e.preventDefault();
        delete_detail_barang($(this).attr("data-value"));
        return false;
    })
})

function load_data(){
    $.ajax({
        url:"{{route('tr_keluar_det',$data_transaksi->id)}}",
        method:"get",
        dataType:"html",
        success:function(result){
            $('#tbl_detail').html(result);
        }
    })
}

function load_transaksi(){
    $.ajax({
        url:"{{route('show_tr_keluar',$data_transaksi->id)}}",
        type:"get",
        dataType:"json",
        success:function(result){
            $('#total_barang').text(result.total_barang);
        }
    })
}

function load_barang(){
    $.ajax({
        url:"{{route('barang_api')}}",
        type:"GET",
        dataType:"json",
        success:function(result){
            var option = "<option val=''>Pilih Barang</option>";
            result.forEach(item => {
                let id = item.id;
                let nama = item.nama_barang;
                option += "<option value='"+id+"'>"+nama+"</option>";
            });
            $('#barang').html(option);
        }
    })
}

function add_new_detail(){
    var id_transaksi = $('#id_transaksi').val();
    var id_barang = $('#barang').val();
    var jml = $('#jml').val();
    var harga_beli = $('#harga_beli').val();

    var data = {
        "_token": "{{ csrf_token() }}",
        transaksi_id : id_transaksi,
        barang_id : id_barang,
        jml : jml
    }
    var default_btn = $('#add_new_data').html();
    $.ajax({
        url:"{{route('tr_keluar_detail')}}",
        dataType:"json",
        data:data,
        method:"POST",
        beforeSend:function(){
            document.body.style.cursor='wait';
            $('#add_new_data').html("<i class='fas fa-spinner fa-spin'></i> Menyimpan").attr("disabled",true);
        },
        success:function(result){
            if(result.status == true){
                load_data();
                load_transaksi();
            }else{
                alert(result.message);
            }
            document.body.style.cursor='default';
            $('#add_new_data').html(default_btn).attr("disabled",false);
        },
        error:function(x,y,z){
            document.body.style.cursor='default';
            $('#add_new_data').html(default_btn).attr("disabled",false);
        }
    })
}

function save_transaction(){
    document.location.href = "{{route('tr_keluar_save',$data_transaksi->id)}}";
}

function delete_detail_barang(id){
    $.ajax({
        url:"{{route('delete_tr_keluar',$data_transaksi->id)}}",
        type:"post",
        dataType:"json",
        data:{
            "_token": "{{ csrf_token() }}",
            "id":id
        },
        success:function(result){
            if(result.status == true){
                load_data()
                load_transaksi()
            }
        }
    })
}
</script>
@endsection