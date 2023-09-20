<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title . ' - TUFMF' ?></title>
    <link href="<?= base_url() ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/vendor/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/select2/css/select2.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/jquery-ui/jquery-ui.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/icheck-bootstrap/icheck-bootstrap.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>/css/ribbon.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>/css/error.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>/css/navbar.css"/>
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/css/sidebar.css"/> -->
    <link rel="stylesheet" href="<?= base_url() ?>/css/styles.css"/>
    <!-- <link href="<?php echo base_url() ?>/vendor/jquery-easyui-1.10.9/themes/metro/easyui.css" rel="stylesheet" type="text/css"> -->

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }
        .navbar-header > header {
            padding: 0.9rem 10px !important;
        }
        .panel-header, .navbar-header {
            width: 100% !important;
        }
    </style>
</head>
<body>    
    <main style="min-height: 100vh;">
        <div class="my-container container-active-nav" style="width: 100%; font-size: 12px !important">
            <div class="navbar-header bg-light">
                <header class="d-flex flex-wrap align-items-center">
                    <h3 class="nav col-12 col-md-auto mb-2 justify-content-center mx-auto">
                        <strong>TUF</strong>&nbsp;-&nbsp;Multi Finance
                    </h3>
                </header>
            </div>
            <?php echo view($content) ?>
        </div>
    </main>

    
    <script src="<?= base_url() ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/vendor/DataTables/datatables.min.js"></script>
    <script src="<?= base_url() ?>/vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>/vendor/select2/js/select2.full.min.js"></script>
    <script src="<?= base_url() ?>/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>/vendor/autoNumeric/autoNumeric-1.9.18.js"></script>
    <script src="<?= base_url() ?>/js/pages/login.js"></script>
    <script src="<?= base_url() ?>/js/helper.js"></script>
    <script src="<?= base_url() ?>/vendor/download/download.min.js"></script>
    <script src="<?php echo base_url() ?>/vendor/jquery-easyui-1.10.9/jquery.easyui.min.js"></script>
    <script>
        const BASEURL   = '<?php echo base_url(); ?>';
    </script>
    <script>
        // $(document).ready(function() {
        //     var url = window.location; 
        //     var element = $('ul.sidebar-menu a').filter(function() {
        //         let a = url.href.replace("#", "");
        //         return this.href == url || a.indexOf(this.href) == 0; 
        //     }).addClass('active');
        //     let element2 = element.parent().parent().parent();
        //     // let elementParent = element2.parent().find('a.btn-nav-accordion');
        //     // elementParent.addClass('active');
        //     if (element2.hasClass('collapse')) {
        //         var bsCollapse = new bootstrap.Collapse(element2, {
        //             toggle: true
        //         })
        //     }
        // });
        var clockElement = document.getElementById('clock');

        function clock() {
            var options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric'};
            var today  = new Date();
            clockElement.textContent = today.toLocaleDateString("id-ID", options);
        }
        clock();
        setInterval(clock, 1000);
    </script>
    <?php
        if (isset($js)) {
            foreach ($js as $value) {
                echo '<script defer type="text/javascript" src="' . base_url($value) . '?version=' . VERSION . '"></script>';
                echo "\n";
            }
        }
    ?>
</body>
</html>