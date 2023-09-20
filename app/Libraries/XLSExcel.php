<?php
namespace App\Libraries;

require_once ROOTPATH.'App\Libraries\xlsxwriter.class.php';
// require_once ROOTPATH.'App\Libraries\PHPExcel\PHPExcel.php';
use Xlsxwriter;

class XLSExcel extends Xlsxwriter {
    public function __construct() {
       parent::__construct();
    }
 }