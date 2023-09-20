<style>
    .panel-custom {
        border: none !important;
    }
    .datagrid-header-row {
      height: 35px;
      color: #fff;
    }

    .datagrid-row {
      height: 30px;
    }

    .datagrid-toolbar {
        background: #fff;
        padding-right: 5px !important;
    }

    .datagrid-header-inner {
        float: left;
        width: 100%;
        /* background-color: #3c8dbc;#212529 */
        background-color: #212529;
    }

    .datagrid-header td.datagrid-header-over {
        background: #204d74;
        color: #fff;
        cursor: default;
    }

    .tree-title {
        font-size: 14px;
        display: inline-block;
        text-decoration: none;
        vertical-align: top;
        white-space: nowrap;
        padding: 0 2px;
        height: 18px;
        line-height: 18px;
    }
</style>
<div class="panel">
    <div class="panel-header panel-custom d-flex justify-content-between">
        <div class="dropdown">
            <?= $btn_add ?>
        </div>
        <div class="title-page my-auto"><span><?= $title ?></span></div>
        <div id="clock" class="my-auto"></div>
    </div>
    <div class="panel-body panel-custom">
        <div class="content py-3">
            <table id="menumanagement" class="table table-striped" style="width:1000px;margin: 0 auto;">
            </table>
        </div>
    </div>
</div>
<link href="<?php echo base_url() ?>/vendor/jquery-easyui-1.10.9/themes/metro/easyui.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

</script>