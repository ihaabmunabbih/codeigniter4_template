<?php

namespace App\Modules\Login\Controllers;

use App\Modules\Login\Models\LoginModel;
use stdClass;

class Login extends \App\Controllers\BaseController
{
    public function __construct(){
		parent::__construct();
        $this->login    = new LoginModel();

        $config         = new \Config\Encryption();
        $config->key    = '123456789012345';
        $config->driver = 'OpenSSL';
        $this->session  = \Config\Services::session();
        $this->enc      = \Config\Services::encrypter($config);
	}

    public function index()
    {
        $data['title']      = 'Login';
        $data['content']    = '\App\Modules\Login\Views\v_index.php';
        $data['js'][]       = base_url('/js/pages/login.js');
        return view('main/v_auth', $data);


    }

    public function do_login() {
        if($this->request->isAJAX()){
            $username = trim($this->request->getPost('username'));
            $password = trim($this->request->getPost('password'));

            $getUser = $this->login->checkUser($username);

            $encrypt_pass = $this->enc->encrypt($password);

            // echo $encrypt_pass;exit;

            $checkPasswordUser[]=0;
            if (count($getUser) >= 1) {
                $checkPassword  = $this->login->checkPassword($getUser[0]->password, $password);

                
                if (!$checkPassword) {
                    $checkPasswordUser[]=1;
                }
            }

            if (count($getUser) < 1) {
                $message['error'] = 'Username Tidak ditemukan. ';
                $res = array("code" => "0", "message" => $message['error']);
            } else if(array_sum($checkPasswordUser) > 0) {
                $message['error'] = 'Username Atau Password Tidak Cocok. ';
                $res = array("code" => "0", "message" => $message['error']);
            } else {
                $this->session->start();
                $data = array(
                    "id"            => $getUser[0]->id,
                    "username"      => $getUser[0]->username,
                    "password"      => $getUser[0]->password,
                    "nama_lengkap"  => $getUser[0]->nama,
                    "email"         => $getUser[0]->email,
                    "no_telp"       => $getUser[0]->nomor_telepon,
                    "level"         => $getUser[0]->user_group,
                    "logged_in"     => true
                );

                $this->session->set($data);
                $message['success'] = 'Login Sukses';
                $res = array("code" => "200", "message" => $message['success']); 
            }

            echo json_encode($res);
        }
    }

    public function do_logout() {
        if($this->request->isAJAX()) {
            $this->session->destroy();
            $message['success'] = 'Logout Sukses';
            $res = array("code" => "200", "message" => $message['success']);
            echo json_encode($res);
        }
    }
}

?>