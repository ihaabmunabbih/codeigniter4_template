<?php
namespace App\Modules\Modulmanagement\Models;

class ModulmanagementModel extends \App\Models\BaseModel
{
	protected $table   = 'modul';
	public function __construct() {
		parent::__construct();

		$this->url = 'managementmodul';
	}
	
	public function get_list_all()
	{
		$sql = "SELECT *
				FROM mst_modul
				WHERE id_parent is null AND status <> -5
				ORDER BY order_modul asc";
				
		$query         = $this->db->query($sql)->getResult();

		$rows = array();
		foreach ($query as $key) {
			$data_child = $this->get_list_children($key->id);
			if (count($data_child) > 0) {
				$key->children = $data_child;
			}

			$data_delete 	= [
				"title"			=> "Hapus",
				"message"		=> "Anda yakin menghapus data ini?",
				"idTable"		=> "menumanagement",
				"url_delete"	=> base_url("managementmodul/delete?id=".$key->id),
			];

			$data_edit 		= [
				"url_edit"		=> base_url("managementmodul/edit?id=".$key->id),
			];

			$key->iconCls 	= 'fa fa-folder-open';
			$key->id_grid	= $key->id;
			$key->Action	= generate_button_new($this->url, "edit", $data_edit);
			$key->Action	.= generate_button_new($this->url, "delete", $data_delete);

			$rows[] = $key;
		}

		return $rows;
	}

	public function get_list_children($id_parent)
	{
		$sql = "SELECT *
				FROM mst_modul
				WHERE id_parent = '$id_parent' AND status <> -5
				ORDER BY order_modul asc";
				
		$query         = $this->db->query($sql)->getResult();

		$rows 	= array();
		foreach ($query as $key) {
			$data_delete 	= [
				"title"			=> "Hapus",
				"message"		=> "Anda yakin menghapus data ini?",
				"idTable"		=> "menumanagement",
				"url_delete"	=> base_url("managementmodul/delete?id=".$key->id),
			];

			$data_edit 		= [
				"url_edit"		=> base_url("managementmodul/edit?id=".$key->id),
			];

			$key->id_grid	= 'sub-'.$key->id;
			$key->iconCls 	= 'fa fa-angle-double-right';
			$key->Action	= generate_button_new($this->url, "edit", $data_edit);
			$key->Action	.= generate_button_new($this->url, "delete", $data_delete);

			$rows[] = $key;
		}

		return $rows;
	}
}

?>