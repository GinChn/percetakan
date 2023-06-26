<div class="modal fade" id="modal-barang" tabindex="-1" role="dialog" aria-labelledby="modal-barang">
    <div class="modal-dialog" role="document">
        <form method="POST" action="">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Masukkan Nama Barang" required>
                        </div>
                        <div class="form-group">
                            <label for="id_bahan">Jenis Bahan</label>
                            <select class="form-control" name="id_bahan" id="id_bahan">
                                <option value="">Pilih Jenis Bahan</option>
                                @foreach ($bahan as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_mesin">Jenis Mesin</label>
                            <select class="form-control" name="id_mesin" id="id_mesin">
                                <option value="">Pilih Jenis Mesin</option>
                                @foreach ($mesin as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select class="form-control" name="satuan" id="satuan">
                                <option value="">Pilih Satuan</option>
                                <option value="Meter">Meter</option>
                                <option value="Lembar">Lembar</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Box">Box</option>
                                {{-- @foreach ($satuan as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" name="harga" id="harga" placeholder="Masukkan Harga" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>