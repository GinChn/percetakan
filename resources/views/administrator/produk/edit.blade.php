@extends('administrator.layout')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Produk</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" mt-5>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger">
                <form method="POST" action="/produk/{{ $produk->id_produk }}">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" value="{{ $produk->nama_produk }}" placeholder="Masukkan Nama Produk">
                        </div>
                        <div class="form-group">
                            <label>Jenis Bahan</label>
                            <input type="text" class="form-control" name="jenis_bahan" value="{{ $produk->jenis_bahan }}" placeholder="Masukkan Jenis Bahan">
                        </div>
                        <div class="form-group">
                            <label>Jenis Mesin</label>
                            <select class="custom-select" name="jenis_mesin">
                                @foreach ($kategori as $item)
                                @if ($produk->id_kategori_mesin == $item->id_kategori_mesin)
                                    <option value="{{ $item->id_kategori_mesin }}">{{ $item->jenis_mesin }}</option>
                                @else
                                    <option value="{{ $item->id_kategori_mesin }}">{{ $item->jenis_mesin }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div><div class="form-group">
                            <label>Satuan</label>
                            <select class="custom-select" name="nama_satuan">
                                @foreach ($satuan as $item)
                                @if ($produk->id_satuan == $item->id_satuan)
                                    <option value="{{ $item->id_satuan }}">{{ $item->nama_satuan }}</option>
                                @else
                                    <option value="{{ $item->id_satuan }}">{{ $item->nama_satuan }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" class="form-control" name="harga" value="{{ $produk->harga }}" placeholder="Masukkan Harga">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="/produk" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection