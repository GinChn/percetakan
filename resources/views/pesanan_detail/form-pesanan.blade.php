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
                    <input type="hidden" class="form-control form-control-sm" id="totalharga_detail" name="totalharga">
                    <input type="hidden" class="form-control form-control-sm" id="satuan_detail" name="satuan">
                    <div class="card-body">
                            <input type="hidden" class="form-control" name="id_pesanan" id="id_pesanan" value="{{ $data->id_pesanan }}">
                        <div class="form-group">
                            <label for="nama_pesanan">Nama Pesanan</label>
                            <input type="text" class="form-control" name="nama_pesanan" id="nama_pesanan" placeholder="Masukkan Nama Pesanan" required>
                        </div>
                        <div class="form-group">
                            <label>Barang</label>
                            <select class="form-control" name="id_barang" id="barang">
                                <option>Pilih Barang</option>
                                @foreach ($barang as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="id_bahan" id="bahan">
                        <div class="form-group" id="detail-ukuran">
                            <label for="ukuran">Ukuran</label>
                            <input type="number" class="form-control" name="panjang" id="panjang_detail" placeholder="panjang" >
                            <input type="number" class="form-control" name="lebar" id="lebar_detail" placeholder="lebar" >
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" name="harga" id="harga_detail" placeholder="Harga" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Qty</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah_detail" placeholder="Masukkan Jumlah" required>
                        </div>
                        <div class="form-group">
                            <label for="subtotal">Subtotal</label>
                            <input type="number" class="form-control" name="subtotal" id="subtotal_detail" placeholder="Subtotal" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="finishing">Finishing</label>
                            <select class="form-control form-control-sm" id="id_finishing" name="id_finishing">
                                @foreach ($finishing as $item)
                                <option value="{{ $item->id_finishing }}">{{ $item->nama_finishing }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_detail">Status</label>
                            <select class="form-control form-control-sm" name="status_detail" id="status_detail">
                                <option value="Belum Ada Desain">Belum Ada Desain</option>
                                <option value="Sudah Ada Desain">Sudah Ada Desain</option>
                                <option value="Dikerjakan">Dikerjakan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
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