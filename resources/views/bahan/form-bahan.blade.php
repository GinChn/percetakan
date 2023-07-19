<div class="modal fade" id="modal-bahan" tabindex="-1" role="dialog" aria-labelledby="modal-bahan">
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
                            <label for="nama_bahan">Nama Bahan</label>
                            <input type="text" class="form-control" name="nama_bahan" id="nama_bahan" placeholder="Masukkan Nama Bahan" required>
                            <span class="help-block with-errors"></span>
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