<?php

namespace App\Modules\Home\Controllers;

class Home extends \App\Controllers\BaseController
{
    public function __construct(){
		parent::__construct();
        $this->session = \Config\Services::session();
	}

    public function index()
    {
        $data['title']      = 'Home';
        $data['content']    = '\App\Modules\Home\Views\v_index.php';
        $data['js'][]       = base_url('/js/pages/login.js');

        return view('main/v_main', $data);
    }
}

?>