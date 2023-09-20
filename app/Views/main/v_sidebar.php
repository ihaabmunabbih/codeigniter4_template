<?php
    $menu = get_menu();
?>
<div class="d-flex flex-column active-nav flex-shrink-0 text-white bg-dark sidebar" id="sidebar" style="width: 200px; padding-top:0 !important; font-size: 12px !important;z-index:1">
    <div class="sidebar-header text-center">
        <a href="<?= base_url() ?>" class="align-items-center mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="<?= base_url() ?>/img/tempo-header.png" alt="tempo-logo" height="65">
        </a>
    </div>
    <div style="padding-top: 10px;height: 100% !important; overflow-y:scroll !important">
        <ul class="nav nav-pills flex-column mb-auto sidebar-menu">
            <li class="nav-item">
                <a href="<?= base_url("home") ?>" class="nav-link text-white" aria-current="page">
                    <i class="far fa-circle"></i>
                    Home
                </a>
            </li>
            <?php
                foreach($menu as $key => $value) {
            ?>
            <?php if (count($value->submenu) > 0) { ?>
                <li class="nav-item">
                    <a href="#" class="nav-link rounded collapsed text-white btn-nav-accordion" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key ?>" aria-expanded="false">
                        <i class="far fa-circle"></i>
                        <?= $value->nama_modul ?>
                        <i class="fas fa-chevron-right float-end" style="line-height: 1.5 !important"></i>
                    </a>
                    <div class="collapse hide" id="collapse<?= $key ?>">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                            <?php foreach($value->submenu as $key => $value) { ?>
                                <li><a href="<?= base_url($value->url_modul) ?>" class="link-dark nav-link rounded text-white"><i class="fas fa-circle"></i><?= ucwords($value->nama_modul) ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a href="<?= $value->url_modul != '#' ? base_url($value->url_modul) : '#' ?>" class="nav-link text-white">
                        <i class="far fa-circle"></i>
                        <?= ucwords($value->nama_modul) ?>
                    </a>
                    <?php } ?>                    
                </li>
            <?php } ?>
        </ul>
    </div>
</div>