<?php
namespace App\Modules\Privilege\Models;

class PrivilegeModel extends \App\Models\BaseModel
{
	protected $table   = 'mst_modul';
	public function __construct() {
		parent::__construct();

		$this->url = 'privilege';
	}
	
	public function get_list_all($post)
	{
		$group_id = $post['group_id'];
		$sql = "SELECT *
				FROM mst_modul
				WHERE id_parent is null
				ORDER BY order_modul asc";
				
		$query         = $this->db->query($sql)->getResult();

		$sql_privileges = "SELECT a.id as id_modul, aksi_modul, b.id AS privileges_id, b.nama_aksi, b.status_aksi
							FROM
								mst_modul a
								LEFT JOIN mst_modul_privileges b on a.id = b.id_modul
							WHERE b.id_group = '$group_id'";
		
		$dataPrivilegesAll = $this->db->query($sql_privileges)->getResult();
	
		$rows = array();
		foreach ($query as $key) {
			$data_child = $this->get_list_children($key->id, $dataPrivilegesAll);
			if (count($data_child) > 0) {
				$key->children = $data_child;
			}

			$action_array = explode("|", $key->aksi_modul);
			$html = "<div class='d-flex'>";

			$id_modul = $key->id;
			$dataPrivileges = array_filter($dataPrivilegesAll, function($obj) use ($id_modul) {
				if (isset($obj->id_modul) && $obj->id_modul == $id_modul) {
					return true;
				}
			});

			foreach ($action_array as $row) {
				$privileges = array_values(array_filter($dataPrivileges, function($obj) use ($row) {
					if (isset($obj->nama_aksi) && strtolower($obj->nama_aksi) == strtolower($row)) {
						return true;
					}
				}));

				$html .= $this->getCheckbox($key, $privileges, $row);
			}
			$html .= '</div>';

			$data_delete 	= [
				"title"			=> "Hapus",
				"message"		=> "Anda yakin menghapus data ini?",
				"idTable"		=> "privilege",
				"url_delete"	=> base_url("privilege/delete?id=".$key->id),
			];

			$data_edit 		= [
				"url_edit"		=> base_url("privilege/edit?id=".$key->id),
			];
			$key->menu_id	= '<div class="icheck-primary ms-2">
									<input type="checkbox" class="act menu" id="'.$key->id.'" />
									<label for="'.$key->id.'"></label>
								</div>';
			$key->iconCls 	= 'fa fa-folder-open';
			$key->id_grid	= $key->id;
			$key->actions 	= $html;
			$key->Action	= generate_button_new($this->url, "edit", $data_edit);
			$key->Action	.= generate_button_new($this->url, "delete", $data_delete);

			$rows[] = $key;
		}

		return $rows;
	}

	public function get_list_children($id_parent, $dataPrivilegesAll)
	{
		$sql = "SELECT *
				FROM mst_modul
				WHERE id_parent = '$id_parent'
				ORDER BY order_modul asc";
				
		$query         = $this->db->query($sql)->getResult();

		$rows 	= array();
		foreach ($query as $key) {
			$data_delete 	= [
				"title"			=> "Hapus",
				"message"		=> "Anda yakin menghapus data ini?",
				"idTable"		=> "privilege",
				"url_delete"	=> base_url("privilege/delete?id=".$key->id),
			];

			$data_edit 		= [
				"url_edit"		=> base_url("privilege/edit?id=".$key->id),
			];

			$id_modul = $key->id;
			$dataPrivileges = array_filter($dataPrivilegesAll, function($obj) use ($id_modul) {
				if (isset($obj->id_modul) && $obj->id_modul == $id_modul) {
					return true;
				}
			});

			$action_array = explode("|", $key->aksi_modul);
			$html = "<div class='d-flex'>";

			foreach ($action_array as $row) {
				$privileges = array_values(array_filter($dataPrivileges, function($obj) use ($row) {
					if (isset($obj->nama_aksi) && strtolower($obj->nama_aksi) == strtolower($row)) {
						return true;
					}
				}));

				$html .= $this->getCheckbox($key, $privileges, $row);
			}
			$html .= '</div>';
			$key->actions = $html;
			$key->menu_id	= '<div class="icheck-primary ms-2">
									<input type="checkbox" class="act menu" id="'.$key->id.'" />
									<label for="'.$key->id.'"></label>
								</div>';
			$key->id_grid	= 'sub-'.$key->id;
			$key->iconCls 	= 'fa fa-angle-double-right';
			$key->Action	= generate_button_new($this->url, "edit", $data_edit);
			$key->Action	.= generate_button_new($this->url, "delete", $data_delete);

			$rows[] = $key;
		}

		return $rows;
	}

	public function getCheckbox($key, $privileges, $row)
	{
		$id = $row . '-' . $key->id;
		$text = strtoupper($row);
		$checked = "";
		if (isset($privileges[0]->status_aksi) && $privileges[0]->status_aksi) {
			$checked = "checked='true'";
		}
		$id_privileges = $status = "";
		if (isset($privileges[0])) {
			$id_privileges  = $privileges[0]->privileges_id;
			$status			= $privileges[0]->status_aksi;
			$nama_aksi	= $privileges[0]->nama_aksi;
		} else {
			$id_privileges  = 0;
			$status			= 0;
			$nama_aksi	= strtolower($row);
		}

		$html = '<div class="icheck-primary ms-2">
						<input type="checkbox" class="actions act act_'.$key->id.'" id="'.$id.'"
						data-id_modul="'.$key->id.'" data-id_privileges="'.$id_privileges.'" data-name="'.$nama_aksi.'" data-status="'.$status.'" '.$checked.' />
						<label for="'.$id.'">'.$text.'</label>
					</div>';

		return $html;
	}

	// function get_list() {
	// 	$result = array();
	// 	$items  = array();

	// 	$sql 	= "SELECT 
	// 				(select pw.menu_id from core.t_mtr_privilege_web pw where pw.menu_id= m.id and status=1 limit 1 ) as idprivilege,
	// 				parent_id, id, name, m.order, icon, slug
	// 			   FROM core.t_mtr_menu_web m
	// 			   WHERE  status = 1 
	// 			   ORDER BY m.order ASC";
	// 	$query 	= $this->db->query($sql)->result();

	// 	$dataParent=array();
	// 	$dataChild=array();
	// 	$dataIdChild=array();
	// 	foreach ($query as $key => $value) {
	// 		if($value->parent_id==0 or $value->parent_id==null or $value->parent_id=="" )
	// 		{
	// 			$dataParent[]=$value;
	// 		}
	// 		else
	// 		{
	// 			$dataChild[]=$value;
	// 			$dataIdChild[]=$value->parent_id;
	// 		}
	// 	}


	// 	$status    = '<span class="label bg-green">status</span>';
    //     $nonstatus = '<span class="label bg-red">Not status</span>';
		
	// 	$getBtnEdit = generate_button_new($this->_module, 'edit', $this->_module."/edit/");
	// 	$getBtnDelete = generate_button_new($this->_module, 'delete', $this->_module."/delete/");

	// 	if($dataParent){
	// 		foreach ($dataParent as $row){
	// 			$searchChild 	  = array_search($row->id, $dataIdChild);
	// 			$has_child 	  = $searchChild !=""?true:false ;
	// 			if (substr(trim($row->icon), 1, 3) == 'svg') {
	// 				$row->iconCls = 'fa fa-folder-open';
	// 			} else {
	// 				$row->iconCls = 'fa fa-' . $row->icon;
	// 			}
	// 			$id 	   	  = $this->enc->encode($row->id);
	//      		$edit_url     = site_url($this->_module."/edit/{$id}");
	//      		$delete_url   = site_url($this->_module."/action_delete/{$id}");

	//             if($has_child){
	// 				// $row->state = 'closed';
	// 				$row->children = $this->get_list_children($row->id, $dataChild,$getBtnEdit,$getBtnDelete);
	// 			}

	// 			if(!empty($getBtnEdit))
	// 			{
	// 				$row->action = '<button onclick="showModal(\''.$edit_url.'\')" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></button> ';
	// 			}

	//             if(strtolower($row->slug) != $this->_module && strtolower($row->slug) != 'privilege'){
	// 				if(empty($row->idprivilege)){
	// 					if(!empty($getBtnDelete)){
	// 						$row->action .='<button class="btn btn-sm btn-danger" title="Hapus" onclick="delete_menu(\'Apakah Anda yakin menghapus data ini ?\', \''.$delete_url.'\')" title="Hapus"> <i class="fa fa-trash-o"></i> </button> ';
	// 					}
	// 				}
	//             }
					
	// 			array_push($items, $row);
	// 		}
	// 	}
		
	// 	$result["rows"] = $items;
		
	// 	return $result;
	// }
}

?>