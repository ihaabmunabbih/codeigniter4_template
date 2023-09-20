<?php

namespace App\Modules\Usermanagement\Controllers;

use App\Modules\Usermanagement\Models\UsermanagementModel;

class Usermanagement extends \App\Controllers\BaseController
{
    public function __construct(){
		parent::__construct();
        $this->usermanagement   = new UsermanagementModel();
        $this->session          = \Config\Services::session();
        $this->module           = '\App\Modules\Usermanagement';
        $this->validation       = \Config\Services::validation();
        $this->table            = 'mst_user';
        $this->url              = 'usermanagement';
        $this->title            = 'User Management';
	}
    
    public function index()
    {

        checkUrlAccess($this->url, 'view');
        if($this->request->isAJAX()){        
            $rows = $this->usermanagement->dataTable($this->request->getPost());
            echo json_encode($rows);
            exit;
        }

        
        $data['subtitle']   = 'User';
        $data['title']      = 'Master '. $this->title;
        $data['url_add']    = 'usermanagement/add';
        $data['btn_add']    = generate_button_new($this->url, 'add', $data);
        $data['content']    = $this->module.'\Views\v_index.php';
        $data['js'][]       = base_url('/js/pages/usermanagement.js');

        return view('main/v_main', $data);
    }

    public function add() {
        $data['title']      = 'Tambah '. $this->title;
        $data['content']    = $this->module.'\Views\v_add.php';
        $data['user_group'] = $this->usermanagement->selectData('mst_user_group', 'WHERE status <> -5')->getResult();
        $data['js'][]       = base_url('/js/pages/usermanagement.js');

        return view('main/v_main', $data);
    }

    public function do_add() {
        if($this->request->isAJAX()) {
            $this->validation->setRules([
                "username" => array(
                    'label'     => 'username',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "nama_lengkap" => array(
                    'label'     => 'Nama Lengkap',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "password" => array(
                    'label'     => 'password',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "level" => array(
                    'label'     => 'Group',
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

            $check  = $this->usermanagement->selectData($this->table, "WHERE status <> -5 AND upper(username) = upper('".$this->request->getPost('username')."')");

            if (count($check->getResult()) > 0 ) {
                echo json_api(0, "username sudah ada.");
            } else {
                $data = [
                    'username'      => $this->request->getPost('username'),
                    'nama'          => $this->request->getPost('nama_lengkap'),
                    'password'      => $this->request->getPost('password'),
                    'user_group'    => $this->request->getPost('level'),
                    'nomor_telepon' => $this->request->getPost('no_telp'),
                    'email'         => $this->request->getPost('email'),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'created_by'    => $this->session->username,
                ];

                $this->db->transBegin();

                $this->usermanagement->insertData($this->table, $data);

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
        $check  = $this->usermanagement->selectData($this->table, "WHERE status <> -5 AND id = '".$id."'");

        if (count($check->getResult()) < 1 ) {
            echo json_api(0, "User tidak terdaftar.");
        } else {
            $data['title']      = 'Edit '. $this->title;
            $data['data']       = $check->getResult()[0];
            $data['user_group'] = $this->usermanagement->selectData('mst_user_group', 'WHERE status <> -5')->getResult();
            $data['content']    = $this->module.'\Views\v_edit.php';
            $data['js'][]       = base_url('/js/pages/usermanagement.js');

            return view('main/v_main', $data);   

        }
    }

    public function do_edit() {
        if($this->request->isAJAX()) {
            $this->validation->setRules([
                "username" => array(
                    'label'     => 'username',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "nama_lengkap" => array(
                    'label'     => 'Nama Lengkap',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "password" => array(
                    'label'     => 'password',
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ),
                "level" => array(
                    'label'     => 'Group',
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

            $check  = $this->usermanagement->selectData($this->table, "WHERE status <> -5 AND upper(username) = upper('".$this->request->getPost('username')."') AND id != '".$this->request->getPost('id')."'");

            if (count($check->getResult()) > 0 ) {
                echo json_api(0, "username sudah ada.");
            } else {
                $data = [
                    'username'      => $this->request->getPost('username'),
                    'nama'          => $this->request->getPost('nama_lengkap'),
                    'password'      => $this->request->getPost('password'),
                    'user_group'    => $this->request->getPost('level'),
                    'nomor_telepon' => $this->request->getPost('no_telp'),
                    'email'         => $this->request->getPost('email'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'updated_by'    => $this->session->username,
                ];
                $where = ["id" => $this->request->getPost('id')];

                $this->db->transBegin();

                $this->usermanagement->updateData($this->table, $data, $where);

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
            $check  = $this->usermanagement->selectData($this->table, "WHERE id = '".$id."'");

            if (count($check->getResult()) < 1 ) {
                echo json_api(0, "User tidak terdaftar.");
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

                $this->usermanagement->updateData($this->table, $data, $where);

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

    public function profile($id) {
        $check  = $this->usermanagement->selectData($this->table, "WHERE status <> -5 AND id = '".$id."'");

        if (count($check->getResult()) < 1 ) {
            echo json_api(0, "User tidak terdaftar.");
        } else {
            $data['title']      = 'Profile User';
            $data['data']       = $check->getResult()[0];
            $data['user_group'] = $this->usermanagement->selectData('mst_user_group')->getResult();
            $data['content']    = $this->module.'\Views\v_profile.php';
            $data['js'][]       = base_url('/js/pages/usermanagement.js');

            return view('main/v_main', $data);   

        }
    }

}

?>