@extends('layouts/master')

@section('title')
    Tambah Data Barang
@endsection

@section('css')
@endsection

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tambah Data Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tambah Data Barang</li>
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
                <h5 class="m-0">Form Data Barang</h5>
            </div>
            <div class="card-body">              
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('barang_new')}}" method="post">
                            <div class="row">
                                    {{csrf_field()}}
                                <div class="form-group col-md-6">
                                    <label for="">Nama Barang</label>
                                    <input class="form-control @error('nama_barang') is-invalid @enderror" type="text" value="{{ old('nama_barang') }}" name="nama_barang" id="nama_barang">
                                    @error('nama_barang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label for="">Jumlah</label>
                                    <input class="form-control @error('jumlah') is-invalid @enderror" type="number" value="{{ old('jumlah') }}" name="jumlah" id="jumlah">
                                    @error('jumlah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label for="">Satuan</label>
                                    <input class="form-control @error('satuan') is-invalid @enderror" type="text" name="satuan" id="satuan" value="{{ old('satuan') }}">
                                    @error('satuan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
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
@endsection