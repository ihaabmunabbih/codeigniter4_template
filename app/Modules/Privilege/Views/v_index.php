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

    [class*=icheck-]>input:first-child+input[type=hidden]+label::before, [class*=icheck-]>input:first-child+label::before {
        border: 1px solid #000000 !important;
    }

    #privilegeForm > .panel {
        padding-top: 10px !important;
    }
</style>
<div class="panel">
    <div class="panel-header panel-custom d-flex justify-content-between">
        <div class="dropdown">
        </div>
        <div class="title-page my-auto"><span><?= $title ?></span></div>
        <div id="clock" class="my-auto"></div>
    </div>
    <div class="panel-body panel-custom">
        <div class="content py-3">
            <form id="privilegeForm" action="<?php echo base_url('privilege/do_action'); ?>" method="post" style="padding-top: 40px;">
                <div class="input-group form-row mb-1">
                    <div class="mb-2 col-md-5 col-10 mx-auto">
                        <label for="user_group" class="form-label">User Group</label>
                        <select class='form-control' id='user_group' name='user_group' required>
                        </select>
                    </div>
                    <div class="mb-2 col-md-5 col-10 mx-auto">
                    </div>
                </div>
                <table id="privilege" class="table table-striped" style="width:1100px;margin: 0 auto;">
                </table>

                <div class="mb-2 col-12 col-md-3 mx-auto">
                    <button class="w-100 btn btn-lg btn-dark d-none" id="btn-add" type="submit">
                        <span class="spinner-border spinner-border-sm me-1 d-none loading" role="status" aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<link href="<?php echo base_url() ?>/vendor/jquery-easyui-1.10.9/themes/metro/easyui.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
    let user_group = <?= json_encode($user_group) ?>;
</script>