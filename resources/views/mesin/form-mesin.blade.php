<div class="modal fade" id="modal-mesin" tabindex="-1" role="dialog" aria-labelledby="modal-mesin">
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
                            <label for="jenis_mesin">Jenis Mesin</label>
                            <input type="text" class="form-control" name="jenis_mesin" id="jenis_mesin" placeholder="Masukkan Jenis Mesin" required>
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