<?php

if (! function_exists('get_menu')) {
    function get_menu() {
        $model      = new \App\Models\BaseModel();
        $session    = \Config\Services::session();

        $getMenu    = $model->getMenu($session->level);

        foreach($getMenu as $key => $value) 
        {
            $value->submenu = $model->getSubMenu($value->id_modul, $session->level);

            if ($value->nama_modul == 'Line Ticket') {
                $value->link = 'kontrak';
            }

            if ($value->nama_modul == 'user') {
                $value->link = 'usermanagement';
            }

            if ($value->nama_modul == 'Slik') {
                $value->link = 'slik';
            }
        }

        return $getMenu;
    }
}

if (! function_exists('generate_button')) {
    function generate_button($slug, $action, $button) {
        $button_new = "";
        if (checkBtnAccess($slug, $action)) {
            $button_new = $button;
        }
        
        return $button_new;
    }
}

if (! function_exists('generate_button_new')) {
    function generate_button_new($slug, $action, $data) {
        $button = "";
        if (strtolower($action) == 'edit') {
            if (checkBtnAccess($slug, $action)) {
                $button     = '<button class="btn btn-dark me-1" type="button" title="edit" style="line-height: 1.7;">
                                        <a href=\''.$data['url_edit'].'\' class="text-decoration-none text-white">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                </button>';
            }
        }

        if (strtolower($action) == 'delete') {
            if (checkBtnAccess($slug, $action)) {
                $button     = '<button class="btn btn-danger me-1" type="button" title="hapus" onclick="confirmationAction( \''.$data['title'].'\', \''.$data['message'].'\', \''.$data['idTable'].'\', \''.$data['url_delete'].'\')" style="line-height: 1.7;">
                                    <i class="fas fa-trash"></i>
                                </button>';
            }
        }

        if (strtolower($action) == 'add') {
            if (checkBtnAccess($slug, $action)) {
                $button     = '<button class="btn btn-dark me-1" type="button" href style="line-height: 1.7;">
                                    <a href=\''.$data['url_add'].'\' class="text-decoration-none text-white">Tambah '.$data['subtitle'].'</a>
                                </button>';
            }
        }

        elseif(strtolower($action) == 'print_pdf') {
            if (checkBtnAccess($slug, $action)) {
                $button = '<button class="btn btn-dark me-1" type="button" href style="line-height: 1.7;" title="'.$data['title'].'">
                                <a target="_blank" href="'.$data['url_download'].'" class="text-decoration-none text-white" title="'.$data['title'].'"> <i class="fas fa-file-pdf"></i></a>
                            </button>';
            }
        }

        return $button;
    }
}

if(!function_exists('checkBtnAccess')) {
    function checkBtnAccess($current_url, $action) {
        $model      = new \App\Models\BaseModel();
        $session    = \Config\Services::session();

        $access = $model->checkAccess($current_url, $action, $session->level);

        if (count($access->getResult()) > 0) {
            return true;
        } else {
            return false;
        }

    }
}

if(!function_exists('checkUrlAccess')) {
    function checkUrlAccess($current_url, $action) {
        $model      = new \App\Models\BaseModel();
        $session    = \Config\Services::session();

        $access = $model->checkAccess($current_url, $action, $session->level);
        
        if (count($access->getResult()) > 0) {
            return true;
        } else {
            // return redirect()->to(base_url());
            header('Location: /');exit();
        }
    }
}

