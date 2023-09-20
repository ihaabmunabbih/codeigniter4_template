<?php

namespace App\Modules\Modulmanagement\Controllers;

use App\Modules\Modulmanagement\Models\ModulmanagementModel;

class Modulmanagement extends \App\Controllers\BaseController
{
    public function __construct(){
		parent::__construct();
        $this->modulmanagement   = new ModulmanagementModel();
        $this->session          = \Config\Services::session();
        $this->validation       = \Config\Services::validation();
        $this->module           = '\App\Modules\Modulmanagement';
        $this->url              = 'managementmodul';
        $this->title            = 'Menu Management';
        $this->table            = 'mst_modul';
	}
    
    public function index()
    {
        checkUrlAccess($this->url, 'view');
        if($this->request->isAJAX()){        
            $rows = $this->modulmanagement->get_list_all();
            echo json_encode($rows);
            exit;
        }

        $data['subtitle']   = $this->title;
        $data['title']      = 'Master '. $this->title;
        $data['url_add']    = 'managementmodul/add';
        $data['btn_add']    = generate_button_new($this->url, 'add', $data);
        $data['content']    = $this->module.'\Views\v_index.php';
        $data['js'][]       = base_url('/js/pages/modulmanagement.js');
        return view('main/v_main', $data);

    }

    public function add() {
        $data['title']      = 'Tambah '.$this->title;
        $data['content']    = $this->module.'\Views\v_add.php';
        $data['menu']       = $this->modulmanagement->selectData($this->table, "WHERE id_parent IS NULL ORDER BY order_modul ASC")->getResult();
        $data['user_group'] = $this->modulmanagement->selectData('mst_user_group')->getResult();
        $data['modul_action'] = $this->modulmanagement->selectData('mst_modul_aksi')->getResult();
        $data['js'][]       = base_url('/js/pages/modulmanagement-aksi.js');
        $data['js'][]       = base_url('/js/pages/modulmanagement.js');

        return view('main/v_main', $data);
    }

    public function do_add() {
        if($this->request->isAJAX()) {
            $this->validation->setRules([
                "nama_modul" => array(
                    'label'     => 'Nomor Modul',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "id_parent" => array(
                    'label'     => 'Parent',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "link" => array(
                    'label'     => 'Link',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "urutan" => array(
                    'label'     => 'Urutan',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "aksi" => array(
                    'label'     => 'Aksi',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
            ]);

            if ($this->validation->withRequest($this->request)->run() == FALSE) {
                $this->response->setStatusCode(400);
                $result = array(
                    "code" => 400,
                    "message" => $this->validation->getErrors()
                );
    
                echo json_encode($result);
                return;
            }

            $table  = $this->table;
            $check  = $this->modulmanagement->selectData($table, "WHERE upper(url_modul) = upper('".$this->request->getPost('link')."')");

            if ($this->request->getPost('id_parent') == "999") {
                $check_order = $this->modulmanagement->selectData($table, "WHERE order_modul = '".$this->request->getPost('urutan')."' AND id_parent is null");
            } else {
                $check_order = $this->modulmanagement->selectData($table, "WHERE order_modul = '".$this->request->getPost('urutan')."' AND id_parent = '".$this->request->getPost('id_parent')."'");
            }

            if (count($check->getResult()) > 0 && $this->request->getPost('link') != '#') {
                echo json_api(0, "Link sudah ada.");
            } else if (count($check_order->getResult()) > 0) {
                echo json_api(0, "Order sudah ada.");
            } else {
                                
                if ($this->request->getPost('id_parent') == "999") {
                    $data = [
                        'nama_modul'    => $this->request->getPost('nama_modul'),
                        'url_modul'     => strtolower($this->request->getPost('link')),
                        'order_modul'   => $this->request->getPost('urutan'),
                        'aksi_modul'    => strtolower(implode("|", $this->request->getPost('aksi'))),
                        'created_at'    => date('Y-m-d H:i:s'),
                        'created_by'    => $this->session->username,
                    ];
                } else {
                    $data = [
                        'nama_modul'    => $this->request->getPost('nama_modul'),
                        'id_parent'     => $this->request->getPost('id_parent'),
                        'url_modul'     => strtolower($this->request->getPost('link')),
                        'order_modul'   => $this->request->getPost('urutan'),
                        'aksi_modul'    => strtolower(implode("|", $this->request->getPost('aksi'))),
                        'created_at'    => date('Y-m-d H:i:s'),
                        'created_by'    => $this->session->username,
                    ];
                }
                // print_r($this->request->getPost('aksi'));
                // print_r($data);exit;

                $this->db->transBegin();

                $this->modulmanagement->insertData($table, $data);

                if ($this->db->transStatus() === false) {
                    $this->db->transRollback();
                    echo json_api(0, 'Gagal tambah data');
                } else {
                    $this->db->transCommit();
                    echo json_api(200, 'Berhasil tambah data');
                }
            }

        }
    }

    public function edit() {
        $id = $this->request->getGet('id');

        $check  = $this->modulmanagement->selectData($this->table, "WHERE id = '".$id."'");

        if (count($check->getResult()) < 1 ) {
            echo json_api(0, "ID menu tidak terdaftar.");
        } else {
            $data['title']            = 'Edit ' . $this->title;
            $data['data']             = $check->getResult()[0];
            $data['data']->id_parent  = ($data['data']->id_parent == null) ? "999" : $data['data']->id_parent;
            $data['data']->aksi       = explode("|", $data['data']->aksi_modul);
            $data['menu']             = $this->modulmanagement->selectData($this->table, "WHERE id_parent IS NULL ORDER BY order_modul ASC")->getResult();
            $data['modul_action']     = $this->modulmanagement->selectData('mst_modul_aksi')->getResult();
            $data['content']          = $this->module.'\Views\v_edit.php';
            $data['js'][]             = base_url('/js/pages/modulmanagement-aksi.js');
            $data['js'][]             = base_url('/js/pages/modulmanagement.js');

            return view('main/v_main', $data);   
        }
    }

    public function do_edit() {
        if($this->request->isAJAX()) {
            $this->validation->setRules([
                "nama_modul" => array(
                    'label'     => 'Nomor Modul',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "id_parent" => array(
                    'label'     => 'Parent',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "link" => array(
                    'label'     => 'Link',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "urutan" => array(
                    'label'     => 'Urutan',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "aksi" => array(
                    'label'     => 'Aksi',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
            ]);

            if ($this->validation->withRequest($this->request)->run() == FALSE) {
                $this->response->setStatusCode(400);
                $result = array(
                    "code" => 400,
                    "message" => $this->validation->getErrors()
                );
    
                echo json_encode($result);
                return;
            }

            $id = $this->request->getPost('id');

            $check  = $this->modulmanagement->selectData($this->table, "WHERE upper(url_modul) = upper('".$this->request->getPost('link')."') AND id != '".$id."'");

            if ($this->request->getPost('id_parent') == "999") {
                $check_order = $this->modulmanagement->selectData($this->table, "WHERE order_modul = '".$this->request->getPost('urutan')."'  AND id != '".$this->request->getPost('id')."' AND id_parent is null");
            } else {
                $check_order = $this->modulmanagement->selectData($this->table, "WHERE order_modul = '".$this->request->getPost('urutan')."' AND id_parent = '".$this->request->getPost('id_parent')."' AND id != '".$this->request->getPost('id')."'");
            }

            if (count($check->getResult()) > 0  && $this->request->getPost('link') != '#') {
                echo json_api(0, "Link sudah ada.");
            } else if (count($check_order->getResult()) > 0) {
                echo json_api(0, "Order sudah ada.");
            } else {
                if ($this->request->getPost('id_parent') == "999") {
                    $data = [
                        'nama_modul'    => $this->request->getPost('nama_modul'),
                        'status'        => 'admin',
                        'id_parent'     => NULL,
                        'url_modul'     => strtolower($this->request->getPost('link')),
                        'order_modul'   => $this->request->getPost('urutan'),
                        'aksi_modul'    => strtolower(implode("|", $this->request->getPost('aksi'))),
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'updated_by'    => $this->session->username,
                    ];

                    
                } else {
                    $data = [
                        'nama_modul'    => $this->request->getPost('nama_modul'),
                        'id_parent'     => $this->request->getPost('id_parent'),
                        'url_modul'     => strtolower($this->request->getPost('link')),
                        'order_modul'   => $this->request->getPost('urutan'),
                        'aksi_modul'    => strtolower(implode("|", $this->request->getPost('aksi'))),
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'updated_by'    => $this->session->username,
                    ];

                    $check_child    = $this->modulmanagement->selectData('mst_modul', "WHERE id_parent = '". $id ."'");

                    if (count($check_child->getResult()) > 0) {
                        echo json_api(0, "Gagal, modul ini mempunyai sub modul.");
                        exit;
                    }

                }

                $where = [
                    'id' => $this->request->getPost('id')
                ];                
                
                $this->db->transBegin();
                $this->modulmanagement->updateData($this->table, $data, $where);


                if ($this->db->transStatus() === false) {
                    $this->db->transRollback();
                    echo json_api(0, 'Gagal ubah data');
                } else {
                    $this->db->transCommit();
                    echo json_api(200, 'Berhasil ubah data');
                }
            }

        }
    }

    public function delete() {
        if($this->request->isAJAX()) {
            $id = $this->request->getGet('id');
        
            $table = $this->table;
            $where = "WHERE id = '".$id."'";
            $data  = [
                "id"  => $id
            ];

            $check_child    = $this->modulmanagement->selectData($this->table, "WHERE id_parent = '". $id ."'");

            if (count($check_child->getResult()) > 0) {
                echo json_api(0, "Gagal, modul ini mempunyai sub modul.");
                exit;
            }

            $check  = $this->modulmanagement->selectData($table, $where);

            if (count($check->getResult()) < 1 ) {
                echo json_api(0, "ID menu tidak terdaftar.");
            } else {

                $data   = [
                    'status'        => -5,
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'updated_by'    => $this->session->username,

                ];

                $where  = [
                    'id'            => $id,
                    'status <>'     => -5
                ];

                $this->db->transBegin();

                $this->modulmanagement->updateData($this->table, $data, $where);

                if ($this->db->transStatus() === false) {
                    $this->db->transRollback();
                    echo json_api(0, 'Gagal delete data');
                } else {
                    $this->db->transCommit();
                    echo json_api(200, 'Berhasil delete data');
                }
            }
        }
    }

}

?>