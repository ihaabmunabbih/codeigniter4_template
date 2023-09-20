<style>
    [class*=icheck-]>input:first-child+input[type=hidden]+label::before, [class*=icheck-]>input:first-child+label::before {
        border: 1px solid #000000 !important;
    }
</style>
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
        <div class="content py-3" style="font-size: 0.8rem !important; font-weight: 600;">
            <form id="addMenu" action="<?php echo base_url('managementmodul/do_add'); ?>" method="post">

                <div class="input-group form-row mb-1">
                    <div class="mb-2 col-md-5 col-10 mx-auto">
                        <label for="nama_modul" class="form-label">Nama Modul</label>
                        <input type="text" class="form-control tanggal" name="nama_modul" id="nama_modul" placeholder="Nama Modul" required>
                    </div>
                    <div class="mb-2 col-md-5 col-10 mx-auto">
                        <label for="id_parent" class="form-label">Modul Parent</label>
                        <select class='form-control' id='id_parent' name='id_parent' required>
                        </select>
                        <input type="hidden" name="nama_parent" id="nama_parent">
                    </div>
                </div>
                <div class="input-group form-row mb-1">
                    <div class="mb-2 col-md-5 col-10 mx-auto">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" class="form-control" name="link" id="link" placeholder="link" required>
                    </div>
                    <div class="mb-2 col-md-5 col-10 mx-auto">
                        <label for="urutan" class="form-label">Order</label>
                        <input type="number" class="form-control" name="urutan" id="urutan" placeholder="order" required>
                    </div>
                </div>
                <div class="mb-2 col-md-11 col-10 mx-auto">
                    <label for="aksi" class="form-label">Aksi</label>
                    <select class='form-control' id='aksi' name='aksi[]' multiple="multiple" required>
                    </select>
                </div>
                <hr>

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
    let dataMenu = <?= json_encode($menu) ?>;
    let user_group = <?= json_encode($user_group) ?>;
    let modul_action = <?= json_encode($modul_action) ?>;
</script>