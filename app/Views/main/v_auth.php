<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title . ' - TUFMF' ?></title>
    <link href="<?= base_url() ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/css/ribbon.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>/css/signin.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>/css/error.css"/>
    <link rel="icon" href="<?= base_url()?>/favicon.ico" type="image/ico">

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
    </style>
</head>
<body class="text-center">
    <?php if (ENVIRONMENT != "production") { ?>
		<div class="corner-ribbon top-right sticky <?php echo (ENVIRONMENT === "development") ? "red" : "blue"; ?> shadow text-center"><i class="fas fa-bug"></i> <span class="hidden-xs"><?php echo ENVIRONMENT ?></span></div>
	<?php } ?>
	<?php echo view($content) ?>
    
    <script src="<?= base_url() ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>/vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>/js/helper.js"></script>
    <script>
        const BASEURL = '<?php echo base_url(); ?>';
    </script>
    <?php
        if (isset($js)) {
            foreach ($js as $value) {
                echo '<script defer type="text/javascript" src="' . ($value) . '?version=' . VERSION . '"></script>';
                echo "\n";
            }
        }
    ?>
</body>
</html>