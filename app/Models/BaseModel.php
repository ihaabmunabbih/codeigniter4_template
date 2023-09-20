<?php
namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
	public function __construct() {
		$this->db = \Config\Database::connect();
	}

	public function selectData($table, $where = "")
	{
		return $this->db->query("select * from $table $where");
	}

	public function insertData($table, $data)
	{
		$this->db->table($table)->insert($data);
	}

	public function insertDataBatch($table, $data)
	{
		$this->db->table($table)->insertBatch($data);
	}

	public function deleteData($table, $data)
	{
		$this->db->table($table)->delete($data);
	}

	public function updateData($table, $data, $where)
	{
		$this->db->table($table)->update($data, $where);
	}
	
	public function updateDataBatch($table, $data, $where1, $where2)
	{
		$builder = $this->db->table($table);
		$builder->where($where1['key'], $where1['value']);
		$builder->updateBatch($data, $where2);
	}

	public function getMenu($level) {
		$sql		= "SELECT * 
							FROM mst_modul a
							LEFT JOIN mst_modul_privileges b on b.id_modul = a.id
							LEFT JOIN mst_user_group c on c.id = b.id_group
						WHERE b.nama_aksi = 'view'
							AND b.status_aksi = 1
							AND c.user_group = '".strtolower($level)."'
							AND a.id_parent IS NULL ORDER BY order_modul";

		$query 		= $this->db->query($sql);
		$results	= $query->getResult();

		return $results;
	}

	public function getSubMenu($id_parent, $level) {
		$sql		= "SELECT * 
							FROM mst_modul a
							LEFT JOIN mst_modul_privileges b on b.id_modul = a.id
							LEFT JOIN mst_user_group c on c.id = b.id_group
						WHERE b.nama_aksi = 'view'
							AND b.status_aksi = 1
							AND c.user_group = '".strtolower($level)."'
							AND a.id_parent = $id_parent ORDER BY order_modul";

		$query 		= $this->db->query($sql);
		$results	= $query->getResult();

		return $results;
	}

	public function checkAccess($url, $actions, $id_group)
	{
		$sql	= "SELECT a.id_modul, b.url_modul, a.nama_aksi, a.status_aksi, c.user_group
					FROM mst_modul_privileges a
						LEFT JOIN mst_modul b on a.id_modul = b.id
						LEFT JOIN mst_user_group c on c.id = a.id_group
					WHERE b.url_modul = '$url' AND c.user_group = '$id_group' AND a.nama_aksi = '$actions' AND a.status_aksi = '1'";

		return $this->db->query($sql);
	}
}