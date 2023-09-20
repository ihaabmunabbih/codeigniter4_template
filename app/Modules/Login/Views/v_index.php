<style>
    .password span {
        background-color: #fff;
    }

    .password  span:hover {
        cursor: pointer;
    }
</style>
<main class="form-signin">
    <form id="form-login" action="<?php echo base_url('login/do_login'); ?>" method="post">
    <img class="mb-4" src="<?= base_url() ?>/img/logo.png" alt="" width="72">
    <h1 class="h3 mb-3 fw-normal">Template</h1>

    <div class="form-floating">
        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        <label for="floatingInput">Username</label>
    </div>
    <!-- <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        <label for="floatingPassword">Password</label>
    </div> -->
    <div class="input-group mb-3 col-md-12 password" style="height: calc(3.5rem + 2px);">
        <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="password" style="width: 280px;">
            <label for="password">Password</label>
        </div>
        <span class="input-group-text show-password" style="height: calc(3.5rem + 2px);width: 40px;"><i class="far fa-eye"></i><i class="far fa-eye-slash d-none"></i></span>
    </div>
    <button class="w-100 btn btn-lg btn-primary" id="btn-login" type="submit">
        <span class="spinner-border spinner-border-sm me-1 d-none loading" role="status" aria-hidden="true"></span>
        Sign in
    </button>
    </form>
</main>