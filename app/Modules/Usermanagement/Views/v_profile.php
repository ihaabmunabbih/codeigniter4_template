<style>
    .password > input, .password > span {
        border: unset;
        background-color: #ffffff;
    }

    .password {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .password > span:hover {
        cursor: pointer;
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
        <div class="content py-3" style="font-size: 0.8rem !important; font-weight: 600;width:60%; margin: 0 auto;background-color: #eeeeee;">
            <form id="editUser" action="<?php echo base_url('usermanagement/do_edit'); ?>" method="post" autocomplete="off">
                <div class="mb-2 col-12 mx-auto d-flex px-2">
                    <div style="flex-basis:100%">&nbsp;</div>
                    <button class="w-100 btn btn-lg btn-dark" id="edit-profil" type="button" style="flex-basis:50%">
                        <span class="spinner-border spinner-border-sm me-1 d-none loading" role="status" aria-hidden="true"></span>
                        Ubah Profil
                    </button>
                </div>
                <div class="mb-2 col-12 col-md-8 mx-auto">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required value="<?= $data->username ?>" readonly>
                    <input type="hidden" name="id" id="id" value="<?= $data->id ?>">
                </div>
                <div class="mb-2 col-12 col-md-8 mx-auto">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group password">
                        <input type="password" class="form-control" name="password" id="password" placeholder="password" required value="<?= $data->password ?>" readonly>
                        <span class="input-group-text show-password"><i class="far fa-eye"></i><i class="far fa-eye-slash d-none"></i></span>
                    </div>
                </div>
                <div class="mb-2 col-12 col-md-8 mx-auto">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" required value="<?= $data->nama ?>" readonly>
                </div>
                <div class="mb-2 col-12 col-md-8 mx-auto">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="E-mail" value="<?= $data->email ?>" readonly>
                </div>
                <div class="mb-2 col-12 col-md-8 mx-auto">
                    <label for="no_telp" class="form-label">No Telepon</label>
                    <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No Telepon" value="<?= $data->nomor_telepon ?>" readonly>
                </div>
                <div class="mb-2 col-12 col-md-8 mx-auto">
                    <label for="level" class="form-label">Group</label>
                    <select type="text" class="form-control" name="level" id="level" disabled></select>
                </div>
                <div class="mb-2 col-12 mx-auto d-flex px-2 btn-submit d-none">
                    <button class="btn btn-lg btn-danger mx-3" id="btn-cancel" type="button" style="flex-basis:80%;">
                        Batal
                    </button>
                    <button class="btn btn-lg btn-dark mx-3" id="btn-edit" type="submit" style="flex-basis:80%">
                        <span class="spinner-border spinner-border-sm me-1 d-none loading" role="status" aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">   
    let user_group = <?= json_encode($user_group) ?>;
    let dataUser = <?= json_encode($data) ?>;
</script>