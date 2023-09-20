<?php

namespace App\Modules\Groupmanagement\Controllers;

use App\Modules\Groupmanagement\Models\GroupmanagementModel;

class Groupmanagement extends \App\Controllers\BaseController
{
    public function __construct(){
		parent::__construct();
        $this->groupmanagement   = new GroupmanagementModel();
        $this->session      = \Config\Services::session();
        $this->module       = '\App\Modules\Groupmanagement';
        $this->validation   = \Config\Services::validation();
        $this->table        = 'mst_user_group';
        $this->title        = 'Group Management';
        $this->url          = 'groupmanagement';
	}
    
    public function index()
    {

        checkUrlAccess($this->url, 'view');
        if($this->request->isAJAX()){        
            $rows = $this->groupmanagement->dataTable($this->request->getPost());
            echo json_encode($rows);
            exit;
        }

        
        $data['subtitle']   = 'User Group';
        $data['title']      = 'Master '. $this->title;
        $data['url_add']    = 'groupmanagement/add';
        $data['btn_add']    = generate_button_new($this->url, 'add', $data);
        $data['content']    = $this->module.'\Views\v_index.php';
        $data['js'][]       = base_url('/js/pages/groupmanagement.js');

        return view('main/v_main', $data);
    }

    public function add() {
        $data['title']      = 'Tambah '. $this->title;
        $data['content']    = $this->module.'\Views\v_add.php';
        $data['js'][]       = base_url('/js/pages/groupmanagement.js');

        return view('main/v_main', $data);
    }

    public function do_add() {
        if($this->request->isAJAX()) {
            $this->validation->setRules([
                "group_id" => array(
                    'label'     => 'ID Group',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "name" => array(
                    'label'     => 'Nama Group',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                )
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

            $check  = $this->groupmanagement->selectData($this->table, "WHERE status <> -5 AND upper(user_group) = upper('".$this->request->getPost('group_id')."')");

            if (count($check->getResult()) > 0 ) {
                echo json_api(0, "ID Group sudah ada.");
            } else {
                $data = [
                    'group_name'    => $this->request->getPost('name'),
                    'user_group'    => strtolower($this->request->getPost('group_id')),
                    'deskripsi'     => $this->request->getPost('description'),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'created_by'    => $this->session->username,
                ];

                $this->db->transBegin();

                $this->groupmanagement->insertData($this->table, $data);

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

    public function edit($id) {
        $check  = $this->groupmanagement->selectData($this->table, "WHERE status <> -5 AND id = '".$id."'");

        if (count($check->getResult()) < 1 ) {
            echo json_api(0, "Group tidak terdaftar.");
        } else {
            $data['title']      = 'Edit '. $this->title;
            $data['data']       = $check->getResult()[0];
            $data['content']    = $this->module.'\Views\v_edit.php';
            $data['js'][]       = base_url('/js/pages/groupmanagement.js');

            return view('main/v_main', $data);   

        }
    }

    public function do_edit() {
        if($this->request->isAJAX()) {
            $this->validation->setRules([
                "group_id" => array(
                    'label'     => 'ID Group',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "name" => array(
                    'label'     => 'Nama Group',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                )
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

            $check  = $this->groupmanagement->selectData($this->table, "WHERE status <> -5 AND upper(user_group) = upper('".$this->request->getPost('group_id')."') AND id != '".$this->request->getPost('id')."'");

            if (count($check->getResult()) > 0 ) {
                echo json_api(0, "ID Group sudah ada.");
            } else {
                $data = [
                    'group_name'    => $this->request->getPost('name'),
                    'user_group'    => strtolower($this->request->getPost('group_id')),
                    'deskripsi'     => $this->request->getPost('description'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'updated_by'    => $this->session->username,
                ];
                
                $where = ["id" => $this->request->getPost('id')];

                $this->db->transBegin();

                $this->groupmanagement->updateData($this->table, $data, $where);

                if ($this->db->transStatus() === false) {
                    $this->db->transRollback();
                    echo json_api(0, 'Gagal edit data');
                } else {
                    $this->db->transCommit();
                    echo json_api(200, 'Berhasil edit data');
                }
            }

        }
    }
    
    public function delete($id) {
        if($this->request->isAJAX()) {
            $check  = $this->groupmanagement->selectData($this->table, "WHERE id = '".$id."'");

            if (count($check->getResult()) < 1 ) {
                echo json_api(0, "Group tidak terdaftar.");
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

                $this->groupmanagement->updateData($this->table, $data, $where);

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