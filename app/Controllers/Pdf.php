<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

session();

class Pdf extends Controller {

	protected $db;
    protected $ifunction;
    protected $helpers = ['html', 'url'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['html', 'url']);
        //panggil model ifunction
        $this->ifunction = new \App\Models\Ifunction();
    }
    public function pdf($t, $tp, $d, $dx, $papers='portrait')
	{
        // Create a new DOMPDF instance
        $dompdf = new Dompdf();
		if($t == 'export'){
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0);
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
			global $_dompdf_show_warnings, $_dompdf_debug, $_DOMPDF_DEBUG_TYPES;
            // You can set options like this
            $dompdf->set_option('isRemoteEnabled', TRUE);

            // Get the server API name
            $sapi = php_sapi_name();
            $options = array();
				
			switch($sapi){
				
                    case "cli":
                        $opts = $this->ifunction->getoptions();

                        if(isset($opts["h"]) || (!isset($opts["filename"]) && !isset($opts["l"]))) exit($this->ifunction->dompdf_usage());

                        if(isset($opts["l"])){
                            echo "\nUnderstood paper sizes:\n";
                            foreach (array_keys((new Options())->getDefaultPaperSize()) as $size)
                            echo " " . mb_strtoupper($size) . "\n";
                            exit;
                        }

                        $file = $opts["filename"];
                        if(isset($opts["p"])) $paper = $opts["p"]; else $paper = "default";
                        if(isset($opts["o"])) $orientation = $opts["o"]; else $orientation = "portrait";
                        if(isset($opts["b"])) $base_path = $opts["b"];

                        if(isset($opts["f"])) $outfile = $opts["f"];
                        else {
                            if($file === "-") $outfile = "dompdf_out.pdf"; else $outfile = str_ireplace(array(".html", ".htm", ".php"), "", $file) . ".pdf";
                        }

                        if(isset($opts["v"])) $dompdf->set_option('debugKeepTemp', true);
                        if(isset($opts["d"])){
                            $dompdf->set_option('debugKeepTemp', true);
                            $dompdf->set_option('debugCss', true);
                            $dompdf->set_option('debugLayout', true);
                            $dompdf->set_option('debugLayoutLines', true);
                            $dompdf->set_option('debugLayoutBlocks', true);
                            $dompdf->set_option('debugLayoutInline', true);
                            $dompdf->set_option('debugLayoutPaddingBox', true);
                        }

                        if(isset($opts['t'])){
                            $arr = explode(',',$opts['t']);
                            $types = array();
                            foreach ($arr as $type) $types[ trim($type) ] = 1;
                            // There's no equivalent for $_DOMPDF_DEBUG_TYPES in the new version of DOMPDF
                        }

                        $save_file = true;
				break;
				
				default:
                    helper('url');
                    $session = \Config\Services::session();
                    $request = \Config\Services::request();

                    if($d==1) $file = rawurldecode(site_url('report_hibah/'.$dx));
                    elseif($d==2) $file = rawurldecode(site_url('report_bansos/'.$dx));

                    $paper = 'default'; // Update this with your desired default paper size
                    $orientation = $papers;

                    $file_parts = parse_url($file);

                    if(($file_parts['scheme'] == '' || $file_parts['scheme'] === 'file')){
                        $file = realpath($file);
                        // DOMPDF_CHROOT does not exist in the latest version of DOMPDF
                        // if(strpos($file, DOMPDF_CHROOT) !== 0) throw new \Dompdf\Exception("Permission denied on $file.");
                    }

                    $outfile = $tp.'.pdf';

                    $save_file = false;

                    $this->db->table('log')->insert([
                        'user_id' => $session->get('sabilulungan')['uid'], 
                        'activity' => 'report', 
                        'id' => $dx, 
                        'ip' => $request->getIPAddress()
                    ]);
				break;
			}

                    if($file === "-"){
                        $str = "";
                        while( !feof(STDIN)) $str .= fread(STDIN, 4096);
                        $dompdf->loadHtml($str);
                    }else{
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $file);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $output = curl_exec($ch);
                        curl_close($ch);

                        $dompdf->loadHtml($output);
                    }

                    if(isset($base_path)) $dompdf->setBasePath($base_path);

                    $dompdf->setPaper($paper, $orientation);
                    $dompdf->render();

                    if(isset($opts["v"])){
                        global $_dompdf_warnings;
                        foreach ($_dompdf_warnings as $msg) echo $msg . "\n";
                        echo $dompdf->getCanvas()->get_cpdf()->messages;
                        flush();
                    }

                    if($save_file){
                        $outfile = str_replace(".pdf", ".png", $outfile);
                        $file_parts = parse_url($outfile);
                        if($file_parts['scheme'] <> "") $outfile = $file_parts['path'];
                        $outfile = realpath(dirname($outfile)) . DIRECTORY_SEPARATOR . basename($outfile);
                        
                        file_put_contents($outfile, $dompdf->output( array("compress" => 0)));
                        exit(0);
                    }

                    if(!headers_sent()) $dompdf->stream($outfile, $options);
			
		}
		else{
            helper('url');
            $response = \Config\Services::response();

            if($d==1) $response->redirect(site_url('report_hibah/'.$dx));
            elseif($d==2) $response->redirect(site_url('report_bansos/'.$dx));			
		}
	}
    public function report_hibah($tp)
	{
		?>
        <!DOCTYPE html>
		<html>
		<head>
			<title></title>
		</head>
		<style type="text/css">
		table tr td{
			vertical-align: top
		}
		</style>
		<body>
			<table align="right" border="1" cellpadding="0" cellspacing="0" width="100"><tr><td align="center">HIBAH</td></tr></table><br>
			<p align="center"><span style="font-size:20px">REKOMENDASI</span><br>
			PEMBERIAN BELANJA HIBAH DAN BELANJA BANTUAN SOSIAL YANG<br>
			BERSUMBER DARI ANGGARAN PENDAPATAN DAN BELANJA DAERAH</p>
			<hr>
			<!-- <hr style="border: 2px solid #000;margin-top: -8px;"> -->

			<p>Yang bertanda tangan di bawah ini, kami telah melakukan evaluasi Proposal yang disusulkan oleh Permohonan Belanja Hibah dan memberikan Rekomendasi sebagai berikut:</p>

			<?php
			$Qisi = $this->db->query("SELECT a.id, a.judul, a.name, b.name AS ketua, b.address, a.maksud_tujuan, SUM(c.amount) AS usulan  FROM proposal a JOIN user b ON b.id=a.user_id JOIN proposal_dana c ON c.proposal_id=a.id WHERE a.id='$tp'");
			$isi = $Qisi->getResult(); $id = $isi[0]->id;

			$Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$id' AND checklist_id IN (26,27)"); $besar = $Qbesar->getResult();

			?>

			<table width="100%" >
				<tr><td width="3%">1.</td><td width="37%">NAMA KEGIATAN</td><td>:</td><td width="60%"><?php echo $isi[0]->judul ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>2.</td><td>NAMA ORGANISASI / KEPANITIAAN</td><td>:</td><td><?php echo $isi[0]->name ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>3.</td><td>NAMA KETUA/PIMPINAN ORGANISASI / KEPANITIAAN</td><td>:</td><td><?php echo $isi[0]->ketua ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>4.</td><td>ALAMAT ORGANISASI / KEPANITIAAN</td><td>:</td><td><?php echo $isi[0]->address ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>5.</td><td>RENCANA PELAKSANAAN KEGIATAN</td><td>:</td><td><?php echo $isi[0]->maksud_tujuan ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>6.</td><td>BESARNYA USULAN</td><td>:</td><td>Rp. <?php echo number_format($isi[0]->usulan,0,",","."); echo ',-'; ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>7.</td><td>BESARNYA REKOMENDASI</td><td>:</td><td><?php if(isset($besar[0]->value)) echo 'Rp. '.number_format($besar[0]->value,0,",",".").',-'; else echo '-'; ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>8.</td><td>CATATAN</td><td>:</td><td><?php if(isset($besar[1]->value)) echo $besar[1]->value; else echo '-'; ?></td></tr>
				<tr><td colspan="3"></td></tr>
			</table>

			<?php $bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember') ?>
			<p align="right">Bandung, <?php echo date('j').' '.$bulan[date('n')].' '.date('Y'); ?></p>
			<br>

			<table width="100%" border="1" cellpadding="0" cellspacing="0">
				<tr><td align="center" width="40%">JABATAN</td><td align="center" width="40%">NAMA/NIP</td><td align="center" width="20%">TANDA TANGAN</td></tr>
				<tr><td>Kepala SKPD................................</td><td></td><td></td></tr>
				<tr><td>Camat................................</td><td></td><td></td></tr>
				<tr><td>Lurah................................</td><td></td><td></td></tr>
			</table>

			<br>
			<p>Telah dilakukan pembahasan<br>Pada tanggal..........................</p>
			<p>Ketua Tim Pertimbangan Pemberian<br>Belanja Hibah dan Belanja Bantuan Sosial</p>
			<br>
			<p>....................................................................</p>
		</body>
		</html>
        <?php
	}
	public function report_bansos($tp)
	{
		?>
        <!DOCTYPE html>
		<html>
		<head>
			<title></title>
		</head>
		<style type="text/css">
		table tr td{
			vertical-align: top
		}
		</style>
		<body>
			<table align="right" border="1" cellpadding="0" cellspacing="0" width="100"><tr><td align="center">BANTUAN SOSIAL</td></tr></table><br><br>
			<p align="center"><span style="font-size:20px">REKOMENDASI</span><br>
			PEMBERIAN BELANJA HIBAH DAN BELANJA BANTUAN SOSIAL YANG<br>
			BERSUMBER DARI ANGGARAN PENDAPATAN DAN BELANJA DAERAH</p>
			<hr>
			<!-- <hr style="border: 2px solid #000;margin-top: -8px;"> -->

			<p>Yang bertanda tangan di bawah ini, kami telah melakukan evaluasi Proposal yang disusulkan oleh Permohonan Belanja Bantuan Sosial dan memberikan Rekomendasi sebagai berikut:</p>

			<?php
			$Qisi = $this->db->query("SELECT a.id, a.judul, a.name, b.name AS ketua, b.address, a.maksud_tujuan, SUM(c.amount) AS usulan  FROM proposal a JOIN user b ON b.id=a.user_id JOIN proposal_dana c ON c.proposal_id=a.id WHERE a.id='$tp'");
			$isi = $Qisi->getResult(); $id = $isi[0]->id;

			$Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$id' AND checklist_id IN (26,27)"); $besar = $Qbesar->getResult();

			//$this->db->insert("log", array('user_id' => $_SESSION['sabilulungan']['uid'], 'activity' => 'report_bansos', 'id' => $tp, 'ip' => $_SERVER['REMOTE_ADDR']));
			?>

			<table width="100%" >
				<tr><td width="3%">1.</td><td width="37%">NAMA KEGIATAN</td><td>:</td><td width="60%"><?php echo $isi[0]->judul ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>2.</td><td>NAMA ORGANISASI / KEPANITIAAN</td><td>:</td><td><?php echo $isi[0]->name ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>3.</td><td>NAMA KETUA/PIMPINAN ORGANISASI / KEPANITIAAN</td><td>:</td><td><?php echo $isi[0]->ketua ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>4.</td><td>ALAMAT ORGANISASI / KEPANITIAAN</td><td>:</td><td><?php echo $isi[0]->address ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>5.</td><td>RENCANA PELAKSANAAN KEGIATAN</td><td>:</td><td><?php echo $isi[0]->maksud_tujuan ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>6.</td><td>BESARNYA USULAN</td><td>:</td><td>Rp. <?php echo number_format($isi[0]->usulan,0,",","."); echo ',-'; ?></td></tr>
				<tr><td>7.</td><td>BESARNYA REKOMENDASI</td><td>:</td><td><?php if(isset($besar[0]->value)) echo 'Rp. '.number_format($besar[0]->value,0,",",".").',-'; else echo '-'; ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>8.</td><td>CATATAN</td><td>:</td><td><?php if(isset($besar[1]->value)) echo $besar[1]->value; else echo '-'; ?></td></tr>
				<tr><td colspan="3"></td></tr>
			</table>

			<?php $bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember') ?>
			<p align="right">Bandung, <?php echo date('j').' '.$bulan[date('n')].' '.date('Y'); ?></p>
			<br>

			<table width="100%" border="1" cellpadding="0" cellspacing="0">
				<tr><td align="center" width="40%">JABATAN</td><td align="center" width="40%">NAMA/NIP</td><td align="center" width="20%">TANDA TANGAN</td></tr>
				<tr><td>Kepala SKPD................................</td><td></td><td></td></tr>
				<tr><td>Camat................................</td><td></td><td></td></tr>
				<tr><td>Lurah................................</td><td></td><td></td></tr>
			</table>

			<br>
			<p>Telah dilakukan pembahasan<br>Pada tanggal..........................</p>
			<p>Ketua Tim Pertimbangan Pemberian<br>Belanja Hibah dan Belanja Bantuan Sosial</p>
			<br>
			<p>....................................................................</p>

			<!-- <table width="100%" border="1" cellpadding="0" cellspacing="0">
				<tr><td align="center" width="40%">JABATAN</td><td align="center" width="40%">NAMA/NIP</td><td align="center" width="20%">TANDA TANGAN</td></tr>
				<tr><td>Kepala SKPD................................</td><td></td><td></td></tr>
				<tr><td>Camat................................</td><td></td><td></td></tr>
				<tr><td>Lurah................................</td><td></td><td></td></tr>
			</table>

			<br>
			<p>Telah dilakukan pembahasan<br>Pada tanggal..........................</p>
			<p>Ketua Tim Pertimbangan Pemberian<br>Belanja Hibah dan Belanja Bantuan Sosial<br>
			....................................................................</p>

			<div style="margin-left: 65%"><p align="center">WALIKOTA BANDUNG,<br><br>TTD.<br><br>MOCHAMAD RIDWAN KAMIL</p></div>

			<p>Salinan sesuai dengan aslinya<br>
			KEPALA BAGIAN HUKUM DAN HAM</p>
			<br><br><br>

			<div style="width: 260px"><center>H. ADIN MUKHTARUDIN, SH, MH</center>
			<center>Pembina Tingkat I</center>
			<center>NIP. 19610625 198603 1 008</center></div> -->
		</body>
		</html>
        <?php
	}
	public function generate_dnc($kategori=0, $dari='', $sampai='', $skpd=0)
	{
		// if($dari!='' && $sampai!='' && $skpd!=0){
		// 	// $Qskpd = $this->db->query("SELECT name FROM skpd WHERE id='$skpd'");
		// 	// $skpd = $Qskpd->result_object(); $name = $skpd[0]->name;			
		// 	$tgl_dari = date('d/M/Y', strtotime($dari)); $tgl_sampai = date('d/M/Y', strtotime($sampai));

		// 	// $filename = 'DNC-PBH-'.$name.' - '.$tgl_dari.'-'.$tgl_sampai;
		// 	$filename = 'DNC-PBH-'.$tgl_dari.'-'.$tgl_sampai;
		// }else $filename = 'DNC-PBH-'.date('d/M/Y');

		$session = \Config\Services::session();
		$request = \Config\Services::request();

		$this->db->table('log')->insert([
			'user_id' => $session->get('sabilulungan')['uid'], 
			'activity' => 'generate_dnc', 
			'ip' => $request->getIPAddress()
		]);

		$filename = 'DNC-PBH-'.date('d/M/Y');

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$filename.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>DNC PBH</title>
        </head>
		<style type="text/css">
		table tr td{
			vertical-align: top
		}
		</style>
        <body>
        	<p align="center" style="font-size:15px">DAFTAR NOMINATIF CALON PENERIMA BELANJA BANTUAN SOSIAL<br>
			(DNCP-BBS)<br>
			PERSETUJUAN WALIKOTA TAHUN<br>
			ANGGARAN <?php echo date('Y') ?></p>

			<p>Nama OPD : ..............................<br>
			Jenis Belanja Bantuan Sosial: Uang/Barang *)</p>

        	<table border="1" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Nama Lengkap Calon Penerima</th>
                        <th rowspan="2">Alamat Lengkap</th>
                        <th rowspan="2">Rencana Penggunaan</th>
                        <th class="has-sub" colspan="3">Besaran Belanja Bantuan Sosial (Rp)</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>Permohonan</th>
                        <th>Hasil Evaluasi</th>
                        <th>Pertimbangan TAPD</th>
                    </tr>
                    <tr>
                    	<th>1</th>
                    	<th>2</th>
                    	<th>3</th>
                    	<th>4</th>
                    	<th>5</th>
                    	<th>6</th>
                    	<th>7</th>
                    	<th>8</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // if($dari!='' && $sampai!='' && $skpd!=0) $Qlist = $this->db->select("id, name, address, maksud_tujuan")->from('proposal')->where('time_entry >=', $dari)->where('time_entry <=', $sampai)->where('skpd_id', $skpd)->order_by('id', 'DESC')->get();                    
                    // else $Qlist = $this->db->select("id, name, address, maksud_tujuan")->from('proposal')->order_by('id', 'DESC')->get();

                    if($kategori || $dari || $sampai || $skpd){
                        $where = '';

                        //kategori
                        if($kategori && !$dari && !$sampai && !$skpd){
                            if($kategori=='all') $where .= "";
                            else $where .= "WHERE type_id = $kategori";
                        }elseif($kategori && $dari && !$sampai && !$skpd){
                            if($kategori=='all') $where .= "WHERE time_entry >= '$dari'";
                            else $where .= "WHERE type_id = $kategori AND time_entry >= '$dari'";
                        }elseif($kategori && !$dari && $sampai && !$skpd){
                            if($kategori=='all') $where .= "WHERE time_entry <= '$sampai'";
                            else $where .= "WHERE type_id = $kategori AND time_entry <= '$sampai'";
                        }elseif($kategori && !$dari && !$sampai && $skpd){
                            if($kategori=='all' AND $skpd=='all') $where .= "";
                            elseif($kategori!='all' AND $skpd=='all') $where .= "WHERE type_id = $kategori";
                            elseif($kategori=='all' AND $skpd!='all') $where .= "WHERE skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND skpd_id = $skpd";
                        }                        

                        //dari
                        elseif(!$kategori && $dari && !$sampai && !$skpd) $where .= "WHERE time_entry >= '$dari'";
                        elseif(!$kategori && $dari && $sampai && !$skpd) $where .= "WHERE time_entry >= '$dari' AND time_entry <= '$sampai'";
                        elseif(!$kategori && $dari && !$sampai && $skpd){
                            if($skpd=='all') $where .= "WHERE time_entry >= '$dari'";
                            else $where .= "WHERE time_entry >= '$dari' AND skpd_id = $skpd";
                        }

                        //sampai
                        elseif(!$kategori && !$dari && $sampai && !$skpd) $where .= "WHERE time_entry <= '$sampai'";
                        elseif(!$kategori && !$dari && $sampai && $skpd){
                            if($skpd=='all') $where .= "WHERE time_entry <= '$sampai'";
                            else $where .= "WHERE time_entry <= '$sampai' AND skpd_id = $skpd";
                        }

                        //skpd
                        elseif(!$kategori && !$dari && !$sampai && $skpd){
                            if($skpd=='all') $where .= "";
                            else $where .= "WHERE skpd_id = $skpd";
                        }

                        //mixed
                        elseif($kategori && $dari && $sampai && !$skpd){
                            if($kategori=='all') $where .= "WHERE time_entry >= '$dari' AND time_entry <= '$sampai'";
                            else $where .= "WHERE type_id = $kategori AND time_entry >= '$dari' AND time_entry <= '$sampai'";
                        }elseif(!$kategori && $dari && $sampai && $skpd){
                            if($skpd=='all') $where .= "WHERE time_entry >= '$dari' AND time_entry <= '$sampai'";
                            else $where .= "WHERE skpd_id = $skpd AND time_entry >= '$dari' AND time_entry <= '$sampai'";
                        }elseif($kategori && $dari && !$sampai && $skpd){
                            if($kategori=='all') $where .= "WHERE time_entry >= '$dari' AND skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND time_entry >= '$dari' AND skpd_id = $skpd";
                        }elseif($kategori && !$dari && $sampai && $skpd){
                            if($kategori=='all') $where .= "WHERE time_entry <= '$sampai' AND skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND time_entry <= '$sampai' AND skpd_id = $skpd";
                        }elseif($kategori && $dari && $sampai && $skpd){
                            if($kategori=='all' && $skpd=='all') $where .= "WHERE time_entry >= '$dari' AND time_entry <= '$sampai'";
                            elseif($kategori!='all' && $skpd=='all') $where .= "WHERE type_id = $kategori AND time_entry >= '$dari' AND time_entry <= '$sampai'";
                            elseif($kategori=='all' && $skpd!='all') $where .= "WHERE time_entry >= '$dari' AND time_entry <= '$sampai' AND skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND time_entry >= '$dari' AND time_entry <= '$sampai' AND skpd_id = $skpd";
                        }

                        $Qlist = $this->db->query("SELECT id, name, address, maksud_tujuan FROM proposal $where ORDER BY id DESC");
                    }else $Qlist = $this->db->table('proposal')->select("id, name, address, maksud_tujuan")->orderBy('id', 'DESC')->get()->getResult();

                    if(count($Qlist)){
                        $i = 1; $total_mohon = 0; $total_evaluasi = 0; $total_timbang = 0;
                        foreach($Qlist as $list){
                            $Qmohon = $this->db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$list->id'"); $mohon = $Qmohon->getResult(); 

                            $Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$list->id' AND checklist_id IN (26,28,29)"); $besar = $Qbesar->getResult(); 

                            echo '<tr>
                                    <td>'.$i.'</td>
                                    <td>'.$list->name.'</td>
                                    <td>'.$list->address.'</td>
                                    <td>'.$list->maksud_tujuan.'</td>
                                    <td>'; if(isset($mohon[0]->mohon)){ echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-'; $total_mohon += $mohon[0]->mohon; }else echo '-'; echo '</td>
                                    <td>'; if(isset($besar[0]->value)){ echo 'Rp. '.number_format($besar[0]->value,0,",",".").',-'; $total_evaluasi += $besar[0]->value; }else echo '-'; echo '</td>
                                    <td>'; if(isset($besar[1]->value)){ echo 'Rp. '.number_format($besar[1]->value,0,",",".").',-'; $total_timbang += $besar[1]->value; }else echo '-'; echo '</td>
                                    <td>'; if(isset($besar[2]->value)) echo $besar[2]->value; else echo '-'; echo '</td>
                                </tr>';
                            $i++;
                        }
                        echo '<tr>
                        		<td></td>
                        		<td>TOTAL</td>
                        		<td></td>
                        		<td></td>
                        		<td>Rp. '.number_format($total_mohon,0,",",".").',-</td>
                        		<td>Rp. '.number_format($total_evaluasi,0,",",".").',-</td>
                        		<td>Rp. '.number_format($total_timbang,0,",",".").',-</td>
                        		<td></td>
                        	</tr>';
                    }else echo '<tr><td colspan="8">No data.</td></tr>';
                    ?>
                </tbody>
            </table>

            <?php $bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember') ?>
			<p align="right">Bandung, <?php echo date('j').' '.$bulan[date('n')].' '.date('Y'); ?></p>

			<p align="right">WALIKOTA BANDUNG,<br><br><br><br>MOCHAMAD RIDWAN KAMIL</p>
			<!-- <div style="text-align:center;float:right;">WALIKOTA BANDUNG,<br><br><br><br>MOCHAMAD RIDWAN KAMIL</div> -->

			<p>*) Coret yang tidak perlu</p>
        </body>
		</html>
        <?php
	}
    
}