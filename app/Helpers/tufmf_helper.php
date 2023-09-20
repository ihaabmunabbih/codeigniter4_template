<?php

if (! function_exists('get_data_session')) {
    function get_data_session() {
        $session = \Config\Services::session();

        return $session;
    }
}

if (!function_exists('json_api')) {
    function json_api($code, $message, $data = '')
    {
        if ($data == '') {
            $array = array(
            'code'  => $code,
            'message' => $message
            );
        } else {
            $array = array(
            'code'  => $code,
            'message' => $message,
            'data'   => $data
            );
        }
        return json_encode($array);
    }
}

//untuk mengetahui bulan bulan
if ( ! function_exists('bulan'))
{
    function bulan($bln)
    {
        switch ($bln)
        {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

//format tanggal yyyy-mm-dd
if ( ! function_exists('tgl_indo'))
{
    function tgl_indo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);  //memecah variabel berdasarkan -
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun; //hasil akhir
    }
}

function success_label($text)
{
  return "<span class='badge bg-success'>" . $text . "<span>";
}

function failed_label($text)
{
  return "<span class='badge bg-danger'>" . $text . "<span>";
}

function warning_label($text)
{
  return "<span class='badge bg-warning'>" . $text . "<span>";
}
  
function idr_currency($nominal)
{
  return is_numeric($nominal) ? number_format($nominal, 0, ',', '.') : "";
}
?>