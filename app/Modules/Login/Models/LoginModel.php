<?php
namespace App\Modules\Login\Models;

class LoginModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	public function checkUser($username) {
		$query   = $this->db->query('SELECT * FROM mst_user WHERE upper(username)= upper("'.$username.'") ');
		$results = $query->getResult();

		return $results;
	}
	
	public function checkPassword($passwordDB, $passwordFE) 
	{
		return $passwordDB === $passwordFE;
	}

	public function getMenu($level) {
		$query 		= $this->db->query('SELECT * FROM modul WHERE status = "'. $level .'" ORDER BY urutan');
		$results	= $query->getResult();

		return $results;
	}
}

?>