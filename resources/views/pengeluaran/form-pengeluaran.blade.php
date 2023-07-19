<div class="modal fade" id="modal-pengeluaran" tabindex="-1" role="dialog" aria-labelledby="modal-pengeluaran">
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
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan" required>
                        </div>
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" class="form-control" name="nominal" id="nominal" placeholder="Masukkan Nominal" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Masukkan Jumlah" required>
                        </div>
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="number" class="form-control" name="total" id="total" placeholder="Total" required readonly>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
