<div class="modal fade" id="modal-pesanan" tabindex="-1" role="dialog" aria-labelledby="modal-pesanan">
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
                            <input type="hidden" class="form-control" name="id_pesanan" id="id_pesanan" value="{{ $data->id_pesanan }}">
                        <div class="form-group">
                            <label for="nama_pesanan">Nama Pesanan</label>
                            <input type="text" class="form-control" name="nama_pesanan" id="nama_pesanan" placeholder="Masukkan Nama Pesanan" required>
                        </div>
                        <div class="form-group">
                            <label>Barang</label>
                            <select class="form-control" name="id_barang" id="id_barang">
                                <option>Pilih Barang</option>
                                @foreach ($barang as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="id_bahan" id="bahan">
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" name="harga" id="harga" placeholder="Harga" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Qty</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Masukkan Jumlah" required>
                        </div>
                        <div class="form-group">
                            <label for="subtotal">Subtotal</label>
                            <input type="number" class="form-control" name="subtotal" id="subtotal" placeholder="Subtotal" readonly required>
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