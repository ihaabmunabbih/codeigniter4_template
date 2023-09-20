<?php
namespace App\Modules\Modulaksi\Models;

use stdClass;

class ModulaksiModel extends \App\Models\BaseModel
{
	protected $table   = 'user_group';
	public function __construct() {
		parent::__construct();

		$this->url = 'aksimodul';
	}
	
	public function dataTable($post) {
		$start = $post['start'];
		$length = $post['length'];
		$draw = $post['draw'];
		$search = $post['search'];
		$order = $post['order'];
		$order_column = $order[0]['column'];
		$order_dir = strtoupper($order[0]['dir']);
		$iLike        = trim(strtoupper($this->db->escapeLikeString($search['value'])));

		
		$field = array(
			0 => 'id',
			1 => 'nama_aksi',
			2 => 'deskripsi',
		);

		$order_column = $field[$order_column];

		$sql = "SELECT 
					*
				FROM mst_modul_aksi WHERE status <> -5";
				
		$query         = $this->db->query($sql);
		$records_total = count($query->getResult());
		$sql 		  .= " ORDER BY ".$order_column." {$order_dir}";

		if($length != -1){
			$sql .=" LIMIT {$length} OFFSET {$start}";
		}

		$query     = $this->db->query($sql);
		$rows_data = $query->getResult();

		$rows 	= array();
		$i  	= ($start + 1);


		foreach ($rows_data as $row) {

			$data_delete 	= [
				"title"			=> "Hapus",
				"message"		=> "Anda yakin menghapus data ini?",
				"idTable"		=> "modulaksi",
				"url_delete"	=> base_url("aksimodul/delete/".$row->id),
			];

			$data_edit 		= [
				"url_edit"		=> base_url("aksimodul/edit/".$row->id),
			];

     		$row->No			= $i;
			
			$row->Action	= generate_button_new($this->url, "edit", $data_edit);
			$row->Action	.= generate_button_new($this->url, "delete", $data_delete);						
									
			$rows[] = $row;

			$i++;
		}

		return array(
			'draw'           => $draw,
			'recordsTotal'   => $records_total,
			'recordsFiltered'=> $records_total,
			'data'           => $rows
		);
	}
}

?>