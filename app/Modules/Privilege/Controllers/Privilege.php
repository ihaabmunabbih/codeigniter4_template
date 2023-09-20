<?php

namespace App\Modules\Privilege\Controllers;

use App\Modules\Privilege\Models\PrivilegeModel;

class Privilege extends \App\Controllers\BaseController
{
    public function __construct(){
		parent::__construct();
        $this->privilege        = new PrivilegeModel();
        $this->session          = \Config\Services::session();
        $this->validation       = \Config\Services::validation();
        $this->module           = '\App\Modules\Privilege';
        $this->title            = 'Privilege Management';
        $this->table            = 'mst_modul';
        $this->url              = 'privilege';
	}
    
    public function index()
    {

        checkUrlAccess($this->url, 'view');
        if($this->request->isAJAX()){        
            $rows = $this->privilege->get_list_all($this->request->getPost());
            echo json_encode($rows);
            exit;
        }

        $data['subtitle']   = $this->title;
        $data['title']      = 'Master '. $this->title;
        $data['user_group'] = $this->privilege->selectData('mst_user_group')->getResult();
        $data['content']    = $this->module.'\Views\v_index.php';
        $data['js'][]       = base_url('/js/pages/privilege.js');
        return view('main/v_main', $data);

    }

    public function do_action()
    {
        $post = $this->request->getPost();

        $check = $this->privilege->selectData('mst_modul_privileges', "WHERE id_group = '". $post['group_id']."'")->getResult();

    	$insert 	  = array();
    	$update 	  = array();
        $privileges   = array();
        $arr 		  = array();
        if(empty($post['data'])){
    		if(count($check) > 0){
				$data = array(
		    		'status' => 0,
			    	'status_aksi' => $post['group_id']
			    );

			    $this->privilege->updateData('mst_modul_privileges', $data, 'WHERE id_group = "'.$post['group_id'].'"');
				echo json_api(1,'Set Privilege Berhasil');
				
				// set ulang session menunya
				// $this->session->set_userdata(array('listMenu'=>listMenu()));
    		} else {
				echo json_api(0,'Silahkan pilih salah satu action');
    		}

    	} else {
            foreach ($post['data'] as $key => $value) {
                $privileges[] = $value['id_privileges'];
                if($value['id_privileges'] == 0){
                    $insert[] = array(
                        'id_modul'      => $value['id_modul'],
                        'id_group'      => $post['group_id'],
                        'nama_aksi'     => $value['name'],
                        'status_aksi'   => 1
                    );

                } else {
                    if($value['status'] == 0) {
                        $update[] = array(
                            'status_aksi' => 1,
                            'id' => $value['id_privileges']
                        );
                    }
                }
            }

            $this->db->transBegin();

            foreach ($check as $key => $value) {
                $arr[] = $value->id;
            }

            $diff = array_diff($arr, $privileges);
            // print_r($diff);exit;

            if($diff){
                foreach ($diff as $val) {
                    $data = array(
                        'status_aksi' => 0,
                        'id' => (int)$val
                    );
                    $this->privilege->updateData('mst_modul_privileges', $data, "id = $val");
                }
            }

            if($insert){
                $this->db->table('mst_modul_privileges')->insertBatch($insert);
            }

            if($update){
                $this->db->table('mst_modul_privileges')->updateBatch($update, 'id');
            }


            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                echo json_api(0, 'Gagal ubah data');
            } else {
                $this->db->transCommit();
                echo json_api(200, 'Berhasil ubah data');
            }
        }
    }


    public function add() {
        $data['title']      = 'Tambah '.$this->title;
        $data['content']    = $this->module.'\Views\v_add.php';
        $data['menu']       = $this->privilege->selectData($this->table, "WHERE id_parent IS NULL ORDER BY urutan ASC")->getResult();
        $data['user_group'] = $this->privilege->selectData('user_group')->getResult();
        $data['js'][]       = base_url('/js/pages/privilege-aksi.js');
        $data['js'][]       = base_url('/js/pages/privilege.js');

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
                "user_group" => array(
                    'label'     => 'User Group',
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
            $check  = $this->privilege->selectData($table, "WHERE upper(link) = upper('".$this->request->getPost('link')."')");

            if ($this->request->getPost('id_parent') == "999") {
                $check_order = $this->privilege->selectData($table, "WHERE urutan = '".$this->request->getPost('urutan')."'");
            } else {
                $check_order = $this->privilege->selectData($table, "WHERE urutan = '".$this->request->getPost('urutan')."' AND id_parent = '".$this->request->getPost('id_parent')."'");
            }

            if (count($check->getResult()) > 0 ) {
                echo json_api(0, "Link sudah ada.");
            } else if (count($check_order->getResult()) > 0) {
                echo json_api(0, "Order sudah ada.");
            } else {
                                
                if ($this->request->getPost('id_parent') == "999") {
                    $data = [
                        'nama_modul'    => $this->request->getPost('nama_modul'),
                        'status'        => 'admin',
                        'link'          => strtolower($this->request->getPost('link')),
                        'url_module'    => strtolower($this->request->getPost('link')),
                        'urutan'        => $this->request->getPost('urutan'),
                        'aksi'          => strtolower(implode("|", $this->request->getPost('aksi'))),
                        'user_group'    => strtolower(implode("|", $this->request->getPost('user_group'))),
                    ];
                } else {
                    $data = [
                        'nama_modul'    => $this->request->getPost('nama_modul'),
                        'status'        => 'admin',
                        'link'          => strtolower($this->request->getPost('link')),
                        'id_parent'     => $this->request->getPost('id_parent'),
                        'nama_parent'   => $this->request->getPost('nama_parent'),
                        'url_module'    => strtolower($this->request->getPost('link')),
                        'urutan'        => $this->request->getPost('urutan'),
                        'aksi'          => strtolower(implode("|", $this->request->getPost('aksi'))),
                        'user_group'    => strtolower(implode("|", $this->request->getPost('user_group'))),
                    ];
                }
                // print_r($this->request->getPost('aksi'));
                // print_r($data);exit;

                $this->db->transBegin();

                $this->privilege->insertData($table, $data);

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

        $check  = $this->privilege->selectData($this->table, "WHERE id_modul = '".$id."'");

        if (count($check->getResult()) < 1 ) {
            echo json_api(0, "ID menu tidak terdaftar.");
        } else {
            $data['title']            = 'Edit ' . $this->title;
            $data['data']             = $check->getResult()[0];
            $data['data']->id_parent  = ($data['data']->id_parent == null) ? "999" : $data['data']->id_parent;
            $data['data']->aksi       = explode("|", $data['data']->aksi);
            $data['data']->user_group = explode("|", $data['data']->user_group);
            $data['user_group']       = $this->privilege->selectData('user_group')->getResult();
            $data['menu']             = $this->privilege->selectData($this->table, "WHERE id_parent IS NULL ORDER BY urutan ASC")->getResult();
            $data['content']          = $this->module.'\Views\v_edit.php';
            $data['js'][]             = base_url('/js/pages/privilege-aksi.js');
            $data['js'][]             = base_url('/js/pages/privilege.js');

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
                "user_group" => array(
                    'label'     => 'User Group',
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

            $check  = $this->privilege->selectData($this->table, "WHERE upper(link) = upper('".$this->request->getPost('link')."') AND id_modul != '".$id."'");

            if ($this->request->getPost('id_parent') == "999") {
                $check_order = $this->privilege->selectData($this->table, "WHERE urutan = '".$this->request->getPost('urutan')."'  AND id_modul != '".$this->request->getPost('id')."'");
            } else {
                $check_order = $this->privilege->selectData($this->table, "WHERE urutan = '".$this->request->getPost('urutan')."' AND id_parent = '".$this->request->getPost('id_parent')."' AND id_modul != '".$this->request->getPost('id')."'");
            }

            if (count($check->getResult()) > 0 ) {
                echo json_api(0, "Link sudah ada.");
            } else if (count($check_order->getResult()) > 0) {
                echo json_api(0, "Order sudah ada.");
            } else {
                if ($this->request->getPost('id_parent') == "999") {
                    $data = [
                        'nama_modul'    => $this->request->getPost('nama_modul'),
                        'status'        => 'admin',
                        'id_parent'     => NULL,
                        'nama_parent'   => NULL,
                        'url_module'    => strtolower($this->request->getPost('link')),
                        'urutan'        => $this->request->getPost('urutan'),
                        'aksi'          => strtolower(implode("|", $this->request->getPost('aksi'))),
                        'user_group'    => strtolower(implode("|", $this->request->getPost('user_group'))),
                    ];

                    
                } else {
                    $data = [
                        'nama_modul'    => $this->request->getPost('nama_modul'),
                        'id_parent'     => $this->request->getPost('id_parent'),
                        'nama_parent'   => $this->request->getPost('nama_parent'),
                        'url_module'    => strtolower($this->request->getPost('link')),
                        'urutan'        => $this->request->getPost('urutan'),
                        'aksi'          => strtolower(implode("|", $this->request->getPost('aksi'))),
                        'user_group'    => strtolower(implode("|", $this->request->getPost('user_group'))),
                    ];

                    $check_child    = $this->privilege->selectData('modul', "WHERE id_parent = '". $id ."'");

                    if (count($check_child->getResult()) > 0) {
                        echo json_api(0, "Gagal, modul ini mempunyai sub modul.");
                        exit;
                    }

                }

                $where = [
                    'id_modul' => $this->request->getPost('id')
                ];                
                
                $this->db->transBegin();
                $this->privilege->updateData($this->table, $data, $where);


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
            $where = "WHERE id_modul = '".$id."'";
            $data  = [
                "id_modul"  => $id
            ];

            $check_child    = $this->privilege->selectData('modul', "WHERE id_parent = '". $id ."'");

            if (count($check_child->getResult()) > 0) {
                echo json_api(0, "Gagal, modul ini mempunyai sub modul.");
                exit;
                }

            $check  = $this->privilege->selectData($table, $where);

            if (count($check->getResult()) < 1 ) {
                echo json_api(0, "ID menu tidak terdaftar.");
            } else {

                $this->db->transBegin();

                $this->privilege->deleteData($table, $data);

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