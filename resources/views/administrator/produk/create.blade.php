<div class="modal fade" id="tambah-produk">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('produk.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" placeholder="Masukkan Nama Produk">
                        </div>
                        <div class="form-group">
                            <label>Jenis Bahan</label>
                            <input type="text" class="form-control" name="jenis_bahan" placeholder="Masukkan Jenis Bahan">
                        </div>
                        <div class="form-group">
                            <label>Jenis Mesin</label>
                            <select class="custom-select" name="jenis_mesin">
                                <option value="">Pilih Jenis Mesin</option>
                                @foreach ($kategori as $item)
                                <option value="{{ $item->id_kategori_mesin }}">{{ $item->jenis_mesin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Satuan</label>
                            <select class="custom-select" name="nama_satuan">
                                <option value="">Pilih Satuan</option>
                                @foreach ($satuan as $item)
                                <option value="{{ $item->id_satuan }}">{{ $item->nama_satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" class="form-control" name="harga" placeholder="Masukkan Harga">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>