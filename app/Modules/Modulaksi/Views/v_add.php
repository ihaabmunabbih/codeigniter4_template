<div class="panel">
    <div class="panel-header d-flex justify-content-between">
        <div class="dropdown">
            <button class="btn btn-dark" type="button" onclick="history.back()" title="back" style="line-height: 1.7;">
                <i class="fas fa-arrow-left"> &nbsp; Back</i>
            </button>
        </div>
        <div class="title-page my-auto"><span><?= $title ?></span></div>
        <div id="clock" class="my-auto"></div>
    </div>
    <div class="panel-body">
        <div class="content py-3" style="font-size: 0.8rem !important; font-weight: 600">
            <form id="addGroup" action="<?php echo base_url('aksimodul/do_add'); ?>" method="post">
                <div class="mb-2 col-12 col-md-6 mx-auto">
                    <label for="nama_aksi" class="form-label">Nama Aksi</label>
                    <input type="text" class="form-control" name="nama_aksi" id="nama_aksi" placeholder="Nama Aksi" required>
                </div>
                <div class="mb-2 col-12 col-md-6 mx-auto">
                    <label for="description" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" name="description" id="description" placeholder="Deskripsi">
                </div>
                <div class="mb-2 col-12 col-md-3 mx-auto">
                    <button class="w-100 btn btn-lg btn-dark" id="btn-add" type="submit">
                        <span class="spinner-border spinner-border-sm me-1 d-none loading" role="status" aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">   

</script>