<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Ifunction;
use PHPMailer\PHPMailer\PHPMailer;

session();

class Process extends Controller {

	protected $db;
	protected $ifunction;
	protected $session;

    public function __construct()
    {
        // Load database
        $this->db = \Config\Database::connect();
		$this->ifunction = new \App\Models\Ifunction();
		$this->session = \Config\Services::session();


        // Atau jika ingin menggunakan instance model
        // $this->db = new \App\Models\YourModel();
    }
    public function lapor($tp, $dx=0)
	{
		switch($tp){
			case 'send':			
			$name = $this->request->getPost('name');
			$email = $this->request->getPost('email');
			$subject = $this->request->getPost('subject');
			$message = $this->request->getPost('message');

		    date_default_timezone_set('Etc/UTC');

		    require "application/libraries/mail/PHPMailerAutoload.php";

		    //Create a new PHPMailer instance
		    $mail = new PHPMailer();

		    //Tell PHPMailer to use SMTP
		    $mail->isSMTP();

		    //Enable SMTP debugging
		    $mail->SMTPDebug = 2;

		    //Ask for HTML-friendly debug output
		    $mail->Debugoutput = 'html';

		    //Set the hostname of the mail server
		    $mail->Host = 'smtp.gmail.com';

		    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		    $mail->Port = 587;

		    //Set the encryption system to use - ssl (deprecated) or tls
		    $mail->SMTPSecure = 'tls';

		    //Whether to use SMTP authentication
		    $mail->SMTPAuth = true;

		    //Username to use for SMTP authentication - use full email address for gmail
		    $mail->Username = "hibahbansos@mailinator.com";

		    //Password to use for SMTP authentication
		    $mail->Password = "";

		    //Set who the message is to be sent from
		    $mail->setFrom($email, $name);

		    //Set an alternative reply-to address
		    //$mail->addReplyTo('replyto@example.com', 'First Last');

		    //Set who the message is to be sent to
		    $mail->addAddress('demo@mailinator.com', 'Sabilulungan Bansos dan Hibah Online');
		    //$mail->addAddress('mt.ilham@gmail.com', 'Sabilulungan Bansos dan Hibah Online');

		    //Set the subject line
		    $mail->Subject = $subject;

		    $msg = '<p><span style="font-size: medium;"><strong>Lapor - Sabilulungan Bansos dan Hibah Online</strong></span></p>
		            <p>Name : '.$name.'</p>
		            <p>Email : '.$email.'</p>
		            <p>Subject : '.$subject.'</p>
		            <p>Message : '.$message.'</p>';

		    $mail->MsgHTML($msg);

		    if(!$mail->send()) {
		       	$_SESSION['notify']['type'] = 'failed';
				$_SESSION['notify']['message'] = 'Laporan Anda Gagal Dikirim.';

				header('location:'.$_SERVER['HTTP_REFERER']);
		    }else{
		    	$_SESSION['notify']['type'] = 'success';
				$_SESSION['notify']['message'] = 'Laporan Anda Berhasil Dikirim.';

				header('location:'.$_SERVER['HTTP_REFERER']); 
		    }

			break;
		}
	}

	public function hibah($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		$db = \Config\Database::connect();
		$session = \Config\Services::session();
		switch($tp){

			case 'daftar':
			$user_id = $this->request->getPost('user_id');
			$name = $this->request->getPost('name');
			$address = $this->request->getPost('address');
			$judul = $this->request->getPost('judul');
			$latar = $this->request->getPost('latar');
			$maksud = $this->request->getPost('maksud');
			$deskripsi = $this->request->getPost('deskripsi');
			$jumlah = $this->request->getPost('jumlah');
			$role_id = $this->request->getPost('role_id');

			if (!empty($name) && !empty($address) && !empty($judul) && !empty($latar) && !empty($maksud)) {
				// Lakukan validasi file proposal di sini

				if ($this->request->getFiles() && $proposalFile = $this->request->getFile('proposal')) {
					if ($proposalFile->isValid() && $proposalFile->getExtension() === 'pdf') {
						$path = './media/proposal/';
						$newFileName = $proposalFile->getRandomName();

						if ($proposalFile->move($path, $newFileName)) {
							$proposalData = [
								'user_id' => $user_id,
								'name' => $name,
								'judul' => $judul,
								'latar_belakang' => $latar,
								'maksud_tujuan' => $maksud,
								'address' => $address,
								'file' => $newFileName,
								'time_entry' => $this->request->getPost('tanggal') ?? date("Y-m-d")
							];

							$this->db->table('proposal')->insert($proposalData);

							$proposalId = $this->db->insertID();
							$hasil = false;
							if ($deskripsi) {
								foreach ($deskripsi as $index => $value) {
									if($this->db->table('proposal_dana')->insert([
										'proposal_id' => $proposalId,
										'sequence' => $index + 1,
										'description' => $value,
										'amount' => $jumlah[$index]
									])) {
										$hasil = true;
									}else{
										$hasil = false;
									}
								}
							}
							$request = \Config\Services::request();
							$session = \Config\Services::session();
							$files = $this->request->getFileMultiple('foto');
							$path = './media/proposal_foto/';
							$i = 1;
							$hasil = false;
						
							if($files){
								foreach ($files as $file) {
									if ($file->isValid() && !$file->hasMoved()) {
										$new_file_name = $this->ifunction->upload($path, $file->getName(), $file->getTempName());
										if(file_exists($path.$new_file_name)){
											if($this->db->table("proposal_photo")->insert(['proposal_id' => $proposalId, 'sequence' => $i, 'path' => $new_file_name])){
												$hasil = true;
											}else{
												echo "disni ada foto cua gagal";
												exit;
											}
										}else{
											$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah foto, silakan ulangi lagi.']);
											return redirect()->to(previous_url());
										}
										$i++;
									}
								}
							}else{
								echo "disini ga ada foto";
								print_r($files);
								exit;
							}

							// Log aktivitas
							if($hasil){
								$this->db->table('log')->insert([
									'user_id' => $this->session->get('sabilulungan')['uid'],
									'activity' => 'daftar_hibah',
									'id' => $proposalId,
									'ip' => $_SERVER['REMOTE_ADDR']
								]);
	
								// Set notifikasi
								$this->session->setFlashdata('notify', [
									'type' => 'success',
									'message' => 'Pendaftaran hibah bansos berhasil.'
								]);
	
								// Redirect
								$redirectURL = ($role_id == 7) ? site_url('report') : $_SERVER['HTTP_REFERER'];
								return redirect()->to($redirectURL);
							}else{
								$this->session->setFlashdata('notify', [
									'type' => 'failed',
									'message' => 'Terjadi kesalahan saat mengunggah foto, silakan ulangi lagi.'
								]);
	
								return redirect()->to(previous_url());
							}
							
						}
					} else {
						// Error jika file tidak valid
						$this->session->setFlashdata('notify', [
							'type' => 'failed',
							'message' => 'Format proposal harus PDF, silakan ulangi lagi.'
						]);

						return redirect()->back();
					}
				} else {
					// Error jika file proposal tidak ada
					$this->session->setFlashdata('notify', [
						'type' => 'failed',
						'message' => 'Silahkan masukkan proposal.'
					]);

					return redirect()->back();
				}
			} else {
				// Error jika ada data yang kosong
				$this->session->setFlashdata('notify', [
					'type' => 'failed',
					'message' => 'Silahkan lengkapi formulir berikut.'
				]);

				return redirect()->back();
			}

			break;

			case 'edit':
				$user_id = $this->request->getPost('user_id');
				$tanggal = $this->request->getPost('tanggal') ?? date("Y-m-d");
				$name = $this->request->getPost('name');
				$address = $this->request->getPost('address');
				$judul = $this->request->getPost('judul');
				$latar = $this->request->getPost('latar');
				$maksud = $this->request->getPost('maksud');
				$deskripsi = $this->request->getPost('deskripsi');
				$jumlah = $this->request->getPost('jumlah');
				$role_id = $this->request->getPost('role_id');
				$old_proposal = $this->request->getPost('old_proposal');
				$old_foto = $this->request->getPost('old_foto');
				$dana = $this->request->getPost('dana');
				$del_dana = $this->request->getPost('del_dana');
				$del_foto = $this->request->getPost('del_foto');
			if($name && $address && $judul && $latar && $maksud){
				$file = $this->request->getFile('proposal');
				if($file->isValid() && !$file->hasMoved()){
					$allowedExts = array("pdf");
					$extension = $file->getExtension();

					if(!in_array($extension, $allowedExts)){
						
						session()->setFlashdata('message', 'Format proposal harus PDF, silakan ulangi lagi.');
						return redirect()->back();
					}

					$path = './media/proposal/';
					$new_file_name = $file->getRandomName();
					$file->move($path, $new_file_name);

					if(!file_exists($path.$new_file_name)){
						session()->setFlashdata('message', 'Terjadi kesalahan saat mengunggah proposal, silakan ulangi lagi.');
						return redirect()->back();
					}else{
						unlink($path.$old_proposal);
					}
				}else{
					$new_file_name = $old_proposal;
				}

				$this->db->table('proposal')->update(['name' => $name, 'judul' => $judul, 'latar_belakang' => $latar, 'maksud_tujuan' => $maksud, 'address' => $address, 'file' => $new_file_name, 'time_entry' => $tanggal], ['id' => $dx]);

				if(isset($deskripsi)){
					$i = 1; $j = count($dana);
					foreach($deskripsi as $index => $value) {
						if($i <= $j){
							$this->db->table('proposal_dana')->update(['description' => $value, 'amount' => $jumlah[$index]], ['proposal_id' => $dx, 'sequence' => $i]);
						}else{
							$this->db->table('proposal_dana')->insert(['proposal_id' => $dx, 'sequence' => $i, 'description' => $value, 'amount' => $jumlah[$index]]);
						}
						$i++;
					}
				}

				if(isset($del_dana)){
					foreach($del_dana as $index => $value) {
						$this->db->table('proposal_dana')->delete(['sequence' => $value, 'proposal_id' => $dx]);
					}
				}

				if($imagefile = $this->request->getFiles()){
					$Qurut = $db->query("SELECT sequence FROM proposal_photo WHERE `proposal_id`='$dx' ORDER BY sequence DESC LIMIT 1");
					$urut = $Qurut->getResult();
					$Qpos = $db->query("SELECT sequence FROM proposal_photo WHERE `proposal_id`='$dx' AND is_nphd='0' ORDER BY sequence ASC");
					$pos = $Qpos->getResult();

					$i = 1; $j = count($old_foto); $k = $urut[0]->sequence+1;
					foreach($imagefile['foto'] as $img){
						$path = './media/proposal_foto/';
						if($img->isValid() && !$img->hasMoved()){
							$new_file_name = $img->getRandomName();
							$img->move($path, $new_file_name);

							if(!file_exists($path.$new_file_name)){
								session()->setFlashdata('message', 'Terjadi kesalahan saat mengunggah foto, silakan ulangi lagi.');
								return redirect()->back();
							}else{
								unlink($path.$old_foto[$file]);
							}

							if($i <= $j){
								$db->table('proposal_photo')->update(['path' => $new_file_name], ['proposal_id' => $dx, 'sequence' => $pos[$file]->sequence]);
							}else{
								$db->table('proposal_photo')->insert(['proposal_id' => $dx, 'sequence' => $k, 'path' => $new_file_name]); $k++;
							}
						}

						$i++;
					}
				}

				
				if(isset($del_foto)){
					foreach($del_foto as $index => $value) {
						$Qpos = $db->query("SELECT `path` FROM proposal_photo WHERE `proposal_id`='$dx' AND sequence='$value'");
						$pos = $Qpos->getResult(); 
						$path = './media/proposal_foto/';

						if(file_exists($path.$pos[0]->path)){
							unlink($path.$pos[0]->path);
						}
						$db->table('proposal_photo')->delete(['sequence' => $value, 'proposal_id' => $dx]);
					}
				}

				
				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_hibah', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);
				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Koreksi hibah bansos berhasil.']);
			

				return redirect()->back();
			}else{
				$session = \Config\Services::session();
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
				

				return redirect()->back();
			}
			break;
		}
	}
	public function tatausaha($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		$db = \Config\Database::connect();
		$session = \Config\Services::session();
		switch($tp){			

			case 'periksa':
			$user_id = $this->request->getPost('user_id');
			$role_id = $this->request->getPost('role_id');
			$kategori = $this->request->getPost('kategori');
			$kelengkapan = $this->request->getPost('kelengkapan');
			$persyaratan = $this->request->getPost('persyaratan');
			$keterangan = $this->request->getPost('keterangan');
			
			if($user_id && $role_id && $kategori && $kelengkapan && $persyaratan && $keterangan){
				

				if(count($kelengkapan) < 4 || count($persyaratan) < 8){
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi semua persyaratan.']);
					
					return redirect()->back();
				}

				$db->table('proposal')->update(['current_stat' => 1], ['id' => $dx]);
				$db->table('proposal')->update(['type_id' => $kategori], ['id' => $dx]);

				foreach($kelengkapan as $index => $value) {
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => $value]);
				}


				foreach($persyaratan as $index => $value) {
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => $value]);
				}

				$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 13, 'value' => $this->request->getPost('keterangan')]);

				$status = $this->request->getPost('lanjut') ? 1 : ($this->request->getPost('tolak') ? 2 : 0);

				$Qcheck = $db->table('proposal_approval')->select("user_id")->where('proposal_id', $dx)->where('flow_id', 1)->get();
				if($Qcheck->getResult()) $db->table('proposal_approval')->update(['user_id' => $user_id, 'action' => $status], ['proposal_id' => $dx, 'flow_id' => 1]);
				else $db->table('proposal_approval')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 1, 'action' => $status]);

				$db->table('proposal_approval_history')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 1, 'role_id' => $role_id, 'action' => $status]);

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'tu_periksa', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);
				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pemeriksaan hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
                return redirect()->back();
				
			}
			break;

			case 'edit':
			$user_id = $this->request->getPost('user_id');
			$role_id = $this->request->getPost('role_id');
			$kategori = $this->request->getPost('kategori');
			$kelengkapan = $this->request->getPost('kelengkapan');
			$persyaratan = $this->request->getPost('persyaratan');
			$keterangan = $this->request->getPost('keterangan');

			if($user_id && $role_id && $kategori && $kelengkapan && $persyaratan && $keterangan){
				if(count($kelengkapan) < 4 || count($persyaratan) < 8){
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi semua persyaratan.']);
					return redirect()->back();
				}

				$db->table('proposal')->update(['type_id' => $kategori], ['id' => $dx]);
				$db->table('proposal_checklist')->delete(['proposal_id' => $dx, 'checklist_id >=' => 1, 'checklist_id <=' => 12]);

				foreach($kelengkapan as $index => $value) {
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => $value]);
				}

				foreach($persyaratan as $index => $value) {
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => $value]);
				}

				$db->table('proposal_checklist')->update(['value' => $this->request->getPost('keterangan')], ['proposal_id' => $dx, 'checklist_id' => 13]);
				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'tu_periksa_edit', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);
				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Edit hibah bansos berhasil.']);
				

				return redirect()->to(site_url('report'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
				return redirect()->back();
			}
			break;
		}
	}
	public function walikota($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		$db = \Config\Database::connect();
		$session = \Config\Services::session();
		switch($tp){			

			case 'periksa':
			$user_id = $this->request->getPost('user_id');
			$role_id = $this->request->getPost('role_id');

			if($user_id && $role_id){
				$db->table('proposal')->update(['current_stat' => 2], ['id' => $dx]);

				if($this->request->getPost('keterangan') != '') {
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 14, 'value' => $this->request->getPost('keterangan')]);
				}

				$status = $this->request->getPost('lanjut') ? 1 : ($this->request->getPost('tolak') ? 2 : 0);

				$Qcheck = $db->table('proposal_approval')->select("user_id")->where('proposal_id', $dx)->where('flow_id', 2)->get();
				if($Qcheck->getResult()) {
					$db->table('proposal_approval')->update(['user_id' => $user_id, 'action' => $status], ['proposal_id' => $dx, 'flow_id' => 2]);
				} else {
					$db->table('proposal_approval')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 2, 'action' => $status]);
				}

				$db->table('proposal_approval_history')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 2, 'role_id' => $role_id, 'action' => $status]);
				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'walikota_periksa', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pemeriksaan hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			} else {
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'edit':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');

			if($user_id && $role_id){
				if($this->request->getPost('keterangan') != '') {
					$db->table('proposal_checklist')->update(['value' => $this->request->getPost('keterangan')], ['proposal_id' => $dx, 'checklist_id' => 14]);
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'walikota_periksa_edit', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Edit hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			} else {
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'setuju':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');

			if($user_id && $role_id){
				$db->table('proposal')->update(['current_stat' => 7], ['id' => $dx]);

				if($this->request->getPost('keterangan') != '') {
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 30, 'value' => $this->request->getPost('keterangan')]);
				}

				$status = $this->request->getPost('lanjut') ? 1 : ($this->request->getPost('tolak') ? 2 : 0);

				$Qcheck = $db->table('proposal_approval')->select("user_id")->where('proposal_id', $dx)->where('flow_id', 7)->get();
				if($Qcheck->getResult()) {
					$db->table('proposal_approval')->update(['user_id' => $user_id, 'action' => $status], ['proposal_id' => $dx, 'flow_id' => 7]);
				} else {
					$db->table('proposal_approval')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 7, 'action' => $status]);
				}

				$db->table('proposal_approval_history')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 7, 'role_id' => $role_id, 'action' => $status]);
				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'walikota_setuju', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pemeriksaan hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			} else {
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'view':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');

			if($user_id && $role_id){
				if($this->request->getPost('keterangan') != '') {
					$db->table('proposal_checklist')->update(['value' => $this->request->getPost('keterangan')], ['proposal_id' => $dx, 'checklist_id' => 30]);
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'walikota_setuju_edit', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Edit hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			} else {
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;
		}
	}
	public function pertimbangan($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		$db = \Config\Database::connect();
		$session = \Config\Services::session();
		switch($tp){			

			case 'periksa':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');
			

			if($user_id && $role_id){
				$db->table('proposal')->update(['current_stat' => 3], ['id' => $dx]);

				if($this->request->getPost('skpd')){
					$db->table('proposal')->update(['skpd_id' => $this->request->getPost('skpd')], ['id' => $dx]);
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 31, 'value' => $this->request->getPost('skpd')]);
				}

				$status = $this->request->getPost('lanjut') ? 1 : ($this->request->getPost('tolak') ? 2 : 0);

				$Qcheck = $db->table('proposal_approval')->select("user_id")->where('proposal_id', $dx)->where('flow_id', 3)->get();
				if($Qcheck->getResult()) {
					$db->table('proposal_approval')->update(['user_id' => $user_id, 'action' => $status], ['proposal_id' => $dx, 'flow_id' => 3]);
				} else {
					$db->table('proposal_approval')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 3, 'action' => $status]);
				}

				$db->table('proposal_approval_history')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 3, 'role_id' => $role_id, 'action' => $status]);
				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'pertimbangan_periksa', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pemeriksaan hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			} else {
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'edit':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');

			if($user_id && $role_id){
				if($this->request->getPost('skpd')){
					$db->table('proposal')->update(['skpd_id' => $this->request->getPost('skpd')], ['id' => $dx]);
					$db->table('proposal_checklist')->update(['value' => $this->request->getPost('skpd')], ['proposal_id' => $dx, 'checklist_id' => 31]);
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'pertimbangan_periksa_edit', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Edit hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			} else {
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'verifikasi':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');

			if($user_id && $role_id){
				$db->table('proposal')->update(['current_stat' => 5], ['id' => $dx]);

				if($this->request->getPost('koreksi')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 26, 'value' => $this->request->getPost('koreksi')]);
				}

				if($this->request->getPost('keterangan')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 27, 'value' => $this->request->getPost('keterangan')]);
				}

				$status = $this->request->getPost('lanjut') ? 1 : ($this->request->getPost('tolak') ? 2 : 0);

				$Qcheck = $db->table('proposal_approval')->select("user_id")->where('proposal_id', $dx)->where('flow_id', 5)->get();
				if($Qcheck->getResult()) {
					$db->table('proposal_approval')->update(['user_id' => $user_id, 'action' => $status], ['proposal_id' => $dx, 'flow_id' => 5]);
				} else {
					$db->table('proposal_approval')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 5, 'action' => $status]);
				}

				$db->table('proposal_approval_history')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 5, 'role_id' => $role_id, 'action' => $status]);
				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'pertimbangan_verifikasi', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pemeriksaan hibah bansos berhasil.']);

				return redirect()->back();
			} else {
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'view':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');

			if($user_id && $role_id){
				if($this->request->getPost('koreksi')){
					$db->table('proposal_checklist')->update(['value' => $this->request->getPost('koreksi')], ['proposal_id' => $dx, 'checklist_id' => 26]);
				}

				if($this->request->getPost('keterangan')){
					$db->table('proposal_checklist')->update(['value' => $this->request->getPost('keterangan')], ['proposal_id' => $dx, 'checklist_id' => 27]);
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'pertimbangan_verifikasi_edit', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Edit hibah bansos berhasil.']);

				return redirect()->back();
			} else {
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;
		}
	}

	public function skpd($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		$db = \Config\Database::connect();
		$session = \Config\Services::session();
		switch($tp){			

			case 'periksa':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');
				$syarat = $this->request->getPost('syarat');
			
			if($user_id && $role_id){

				if(count($syarat) < 7){
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi semua persyaratan.']);

					return redirect()->back();
				}

				$db->table('proposal')->update(['current_stat' => 4], ['id' => $dx]);

				if($this->request->getPost('beri')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => $this->request->getPost('beri')]);
				}

				if($this->request->getPost('besar')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 17, 'value' => $this->request->getPost('besar')]);
				}

				foreach($syarat as $index => $value) {
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => $value]);
				}


				if($this->request->getPost('keterangan')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 25, 'value' => $this->request->getPost('keterangan')]);
				}

				$status = $this->request->getPost('lanjut') ? 1 : ($this->request->getPost('tolak') ? 2 : 0);

				$Qcheck = $db->table('proposal_approval')->select("user_id")->where('proposal_id', $dx)->where('flow_id', 4)->get();
				if($Qcheck->getResult()) {
					$db->table('proposal_approval')->update(['user_id' => $user_id, 'action' => $status], ['proposal_id' => $dx, 'flow_id' => 4]);
				} else {
					$db->table('proposal_approval')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 4, 'action' => $status]);
				}

				$db->table('proposal_approval_history')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 4, 'role_id' => $role_id, 'action' => $status]);
				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'skpd_periksa', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pemeriksaan hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));

			}else{
				
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'edit':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');
				$syarat = $this->request->getPost('syarat');
			
			if($user_id && $role_id){
				if(count($syarat) < 7){
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi semua persyaratan.']);

					return redirect()->back();
				}

				$db->table('proposal_checklist')->delete(['proposal_id' => $dx, 'checklist_id >=' => 15, 'checklist_id <=' => 25]);

				if($this->request->getPost('beri')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => $this->request->getPost('beri')]);
				}

				if($this->request->getPost('besar')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 17, 'value' => $this->request->getPost('besar')]);
				}

				foreach($syarat as $index => $value) {
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => $value]);
				}

				if($this->request->getPost('keterangan')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 25, 'value' => $this->request->getPost('keterangan')]);
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'skpd_periksa_edit', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Edit hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;
		}
	}

	public function tapd($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		$db = \Config\Database::connect();
		$session = \Config\Services::session();
		switch($tp){				

			case 'verifikasi':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');

			if($user_id && $role_id){
				$db->table('proposal')->update(['current_stat' => 6], ['id' => $dx]);

				if($this->request->getPost('rekomendasi')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 28, 'value' => $this->request->getPost('rekomendasi')]);
				}

				if($this->request->getPost('keterangan')){
					$db->table('proposal_checklist')->insert(['proposal_id' => $dx, 'checklist_id' => 29, 'value' => $this->request->getPost('keterangan')]);
				}

				$status = $this->request->getPost('lanjut') ? 1 : ($this->request->getPost('tolak') ? 2 : null);

				$Qcheck = $db->table('proposal_approval')->where('proposal_id', $dx)->where('flow_id', 6)->get()->getResult();

				if(count($Qcheck)){
					$db->table('proposal_approval')->update(['user_id' => $user_id, 'action' => $status], ['proposal_id' => $dx, 'flow_id' => 6]);
				}else{
					$db->table('proposal_approval')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 6, 'action' => $status]);
				}

				$db->table('proposal_approval_history')->insert(['proposal_id' => $dx, 'user_id' => $user_id, 'flow_id' => 6, 'role_id' => $role_id, 'action' => $status]);

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'tapd_verifikasi', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pemeriksaan hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'edit':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');

			if($user_id && $role_id){
				if($this->request->getPost('rekomendasi')){
					$db->table('proposal_checklist')->update(['value' => $this->request->getPost('rekomendasi')], ['proposal_id' => $dx, 'checklist_id' => 28]);
				}

				if($this->request->getPost('keterangan')){
					$db->table('proposal_checklist')->update(['value' => $this->request->getPost('keterangan')], ['proposal_id' => $dx, 'checklist_id' => 29]);
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'tapd_verifikasi_edit', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Edit hibah bansos berhasil.']);

				return redirect()->to(site_url('report'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;
		}
	}

	public function admin($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		$db = \Config\Database::connect();
		$session = \Config\Services::session();
		switch($tp){

			case 'nphd':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');
				$koreksi = $this->request->getPost('koreksi');	
			
			if($user_id && $role_id){
				$file = $this->request->getFile('nphd');
				if($file && $file->isValid()){
					$allowedExts = ['pdf'];
					$extension = $file->getExtension();

					if(!in_array($extension, $allowedExts)){
						$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Format NPHD harus PDF, silakan ulangi lagi.']);

						return redirect()->back();
					}

					$path = WRITEPATH.'uploads/nphd/';

					if($file->move($path)){
						$new_file_name = $file->getName();

						if(!file_exists($path.$new_file_name)){
							$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah NPHD, silakan ulangi lagi.']);

							return redirect()->back();
						}
					}
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan masukkan NPHD.']);

					return redirect()->back();
				}

				$db->table('proposal')->update(['nphd' => $new_file_name], ['id' => $dx]);

				$files = $this->request->getFiles();

				if(isset($files['foto'])){
					$query = $db->query("SELECT sequence FROM proposal_photo WHERE proposal_id = ?", [$dx]);
					$sequence = $query->getRow()->sequence;

					$i = $sequence + 1;
					foreach($files['foto'] as $file){
						if($file->isValid()){
							$path = WRITEPATH.'uploads/proposal_foto/';

							if($file->move($path)){
								$new_file_name = $file->getName();

								if(!file_exists($path.$new_file_name)){
									$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah foto, silakan ulangi lagi.']);

									return redirect()->back();
								}

								$db->table('proposal_photo')->insert(['proposal_id' => $dx, 'sequence' => $i, 'path' => $new_file_name, 'is_nphd' => 1]);
								$i++;
							}
						}
					}
				}

				if($koreksi){
					$i = 1;
					foreach($koreksi as $index => $value) {
						$db->table('proposal_dana')->update(['correction' => $value], ['proposal_id' => $dx, 'sequence' => $i]); 
						$i++;
					}
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'add_nphd', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'NPHD berhasil ditambahkan.']);

				return redirect()->to(site_url('report'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'edit':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');
				$koreksi = $this->request->getPost('koreksi');
				$old_nphd = $this->request->getPost('old_nphd');
				$old_foto = $this->request->getPost('old_foto');
				$del_foto = $this->request->getPost('del_foto');
			
			if($user_id && $role_id){
				$file = $this->request->getFile('nphd');

				if($file && $file->isValid()){
					$allowedExts = ['pdf'];
					$extension = $file->getExtension();

					if(!in_array($extension, $allowedExts)){
						$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Format NPHD harus PDF, silakan ulangi lagi.']);

						return redirect()->back();
					}

					$path = WRITEPATH.'uploads/nphd/';

					if($file->move($path)){
						$new_file_name = $file->getName();

						if(!file_exists($path.$new_file_name)){
							$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah NPHD, silakan ulangi lagi.']);

							return redirect()->back();
						}
						// Assuming $this->ifunction->un_link() is equivalent to unlink() function in PHP
						unlink($path.$old_nphd);
					}
				}else{
					$new_file_name = $old_nphd;
				}
				$db->table('proposal')->update(['nphd' => $new_file_name], ['id' => $dx]);
				$files = $this->request->getFiles();

				if(isset($files['foto'])){
					$query = $db->query("SELECT sequence FROM proposal_photo WHERE proposal_id = ? ORDER BY sequence DESC LIMIT 1", [$dx]);
					$sequence = $query->getRow()->sequence;

					$query = $db->query("SELECT sequence FROM proposal_photo WHERE proposal_id = ? AND is_nphd = 1 ORDER BY sequence ASC", [$dx]);
					$positions = $query->getResult();

					$i = 1; 
					$j = count($old_foto); 
					$k = $sequence + 1;
					foreach($files['foto'] as $file){
						if($file->isValid()){
							$path = WRITEPATH.'uploads/proposal_foto/';

							if($file->move($path)){
								$new_file_name = $file->getName();

								if(!file_exists($path.$new_file_name)){
									$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah foto, silakan ulangi lagi.']);

									return redirect()->back();
								}
								// Assuming $this->ifunction->un_link() is equivalent to unlink() function in PHP
								unlink($path.$old_foto[$file]);

								if($i <= $j){
									$db->table('proposal_photo')->update(['path' => $new_file_name], ['proposal_id' => $dx, 'sequence' => $positions[$file]->sequence]);
								}else{
									$db->table('proposal_photo')->insert(['proposal_id' => $dx, 'sequence' => $k, 'path' => $new_file_name, 'is_nphd' => 1]); 
									$k++;
								}
							}
						}

						$i++;
					}
				}

				if(isset($del_foto)){
					foreach($del_foto as $index => $value) {
						$query = $db->query("SELECT `path` FROM proposal_photo WHERE `proposal_id` = ? AND sequence = ?", [$dx, $value]);
						$path = $query->getRow()->path;

						// Assuming $this->ifunction->un_link() is equivalent to unlink() function in PHP
						unlink(WRITEPATH.'uploads/proposal_foto/'.$path);
						$db->table('proposal_photo')->delete(['sequence' => $value, 'proposal_id' => $dx]);
					}
				}

				if($koreksi){
					$i = 1;
					foreach($koreksi as $index => $value) {
						$db->table('proposal_dana')->update(['correction' => $value], ['proposal_id' => $dx, 'sequence' => $i]); 
						$i++;
					}
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_nphd', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'NPHD berhasil diedit.']);

				return redirect()->to(site_url('report'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'lpj':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');
				$tanggal = $this->request->getPost('tanggal') ?? date('Y-m-d');
			
			if($user_id && $role_id && $tanggal){	
				$files = $this->request->getFiles();

				$db->table('proposal')->update(['tanggal_lpj' => $tanggal], ['id' => $dx]);

				if(isset($files['foto'])){
					$i = 1;
					foreach($files['foto'] as $file){
						if($file->isValid()){
							$path = WRITEPATH.'uploads/proposal_lpj/';

							if($file->move($path)){
								$new_file_name = $file->getName();

								if(!file_exists($path.$new_file_name)){
									$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah foto, silakan ulangi lagi.']);

									return redirect()->back();
								}

								$db->table('proposal_lpj')->insert(['proposal_id' => $dx, 'sequence' => $i, 'path' => $new_file_name, 'type' => 1]); 
								$i++;
							}
						}
					}
				}

				if($this->request->getPost('video')){
					$video = $this->request->getPost('video');

					$j = $i;
					foreach($video as $index => $value) {
						preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $value, $matches);
						$id = $matches[1]; 
						$url = 'http://www.youtube.com/embed/'.$id.'?autoplay=1';

						$db->table('proposal_lpj')->insert(['proposal_id' => $dx, 'sequence' => $j, 'path' => $url, 'type' => 2]); 
						$j++;
					}
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'add_lpj', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'LPJ berhasil ditambahkan.']);

				return redirect()->to(site_url('report'));
			}else{

				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'view':
				$user_id = $this->request->getPost('user_id');
				$role_id = $this->request->getPost('role_id');
				$tanggal = $this->request->getPost('tanggal') ?? date('Y-m-d');
				$old_foto = $this->request->getPost('old_foto');
				$old_video = $this->request->getPost('old_video');
				$del_foto = $this->request->getPost('del_foto');
				$del_video = $this->request->getPost('del_video');
			
			if($user_id && $role_id && $tanggal){	
				$files = $this->request->getFiles();

				$db->table('proposal')->update(['tanggal_lpj' => $tanggal], ['id' => $dx]);

				if(isset($files['foto'])){
					$queryUrut = $db->query("SELECT sequence FROM proposal_lpj WHERE proposal_id = ? ORDER BY sequence DESC LIMIT 1", [$dx]);
					$urut = $queryUrut->getRow();

					$queryPos = $db->query("SELECT sequence FROM proposal_lpj WHERE proposal_id = ? AND type = 1 ORDER BY sequence ASC", [$dx]);
					$pos = $queryPos->getResult();

					$i = 1; 
					$j = count($old_foto); 
					$k = $urut->sequence + 1;

					foreach($files['foto'] as $file){
						if($file->isValid()){
							$path = WRITEPATH.'uploads/proposal_lpj/';

							if($file->move($path)){
								$new_file_name = $file->getName();

								if(!file_exists($path.$new_file_name)){
									$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah foto, silakan ulangi lagi.']);

									return redirect()->back();
								}else{
									unlink($path.$old_foto[$file->getClientName()]);
								}

								if($i <= $j){
									$db->table('proposal_lpj')->update(['path' => $new_file_name], ['proposal_id' => $dx, 'sequence' => $pos[$file->getClientName()]->sequence]);
								}else{
									$db->table('proposal_lpj')->insert(['proposal_id' => $dx, 'sequence' => $k, 'path' => $new_file_name, 'type' => 1]); 
									$k++;
								}
							}
						}
						$i++;                        
					}
				}

				if(isset($del_foto)){
					foreach($del_foto as $index => $value) {
						$queryPos = $db->query("SELECT path FROM proposal_lpj WHERE proposal_id = ? AND sequence = ?", [$dx, $value]);
						$pos = $queryPos->getRow(); 
						$path = WRITEPATH.'uploads/proposal_lpj/';

						if(file_exists($path.$pos->path)){
							unlink($path.$pos->path);
						}
						$db->table('proposal_lpj')->delete(['sequence' => $value, 'proposal_id' => $dx]);
					}
				}

				if($this->request->getPost('video')){
					$queryUrut = $db->query("SELECT sequence FROM proposal_lpj WHERE proposal_id = ? ORDER BY sequence DESC LIMIT 1", [$dx]);
					$urut = $queryUrut->getRow();

					$queryPos = $db->query("SELECT sequence FROM proposal_lpj WHERE proposal_id = ? AND type = 2 ORDER BY sequence ASC", [$dx]);
					$pos = $queryPos->getResult();

					$video = $this->request->getPost('video');

					$i = 1; 
					$j = count($old_video); 
					$k = $urut->sequence + 1;

					foreach($video as $index => $value) {                        
						preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $value, $matches);
						$id = $matches[1]; 
						$url = 'http://www.youtube.com/embed/'.$id.'?autoplay=1';

						if(!empty($id)){
							if($i <= $j){
								$db->table('proposal_lpj')->update(['path' => $url], ['proposal_id' => $dx, 'sequence' => $pos[$index]->sequence]);
							}else{
								$db->table('proposal_lpj')->insert(['proposal_id' => $dx, 'sequence' => $k, 'path' => $url, 'type' => 2]); 
								$k++;
							}       
						}               
						$i++;
					}
				}

				if(isset($del_video)){
					foreach($del_video as $index => $value) {
						$db->table('proposal_lpj')->delete(['sequence' => $value, 'proposal_id' => $dx]);
					}
				}

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_lpj', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'LPJ berhasil diedit.']);

				return redirect()->to(site_url('report'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'detail':
				$tanggal = $this->request->getPost('tanggal') ?? date('Y-m-d');
				$tanggal1 = $this->request->getPost('tanggal1');
				$tanggal2 = $this->request->getPost('tanggal2');
				$tanggal3 = $this->request->getPost('tanggal3');
				$tanggal4 = $this->request->getPost('tanggal4');
				$tanggal5 = $this->request->getPost('tanggal5');
				$tanggal6 = $this->request->getPost('tanggal6');
				$tanggal7 = $this->request->getPost('tanggal7');
			
			if($tanggal){
				
				$db->table('proposal')->update(['time_entry' => $tanggal], ['id' => $dx]);

				if(isset($tanggal1)) $db->table('proposal_approval')->update(['time_entry' => $tanggal1], ['proposal_id' => $dx, 'flow_id' => 1]);
				if(isset($tanggal2)) $db->table('proposal_approval')->update(['time_entry' => $tanggal2], ['proposal_id' => $dx, 'flow_id' => 2]);
				if(isset($tanggal3)) $db->table('proposal_approval')->update(['time_entry' => $tanggal3], ['proposal_id' => $dx, 'flow_id' => 3]);
				if(isset($tanggal4)) $db->table('proposal_approval')->update(['time_entry' => $tanggal4], ['proposal_id' => $dx, 'flow_id' => 4]);
				if(isset($tanggal5)) $db->table('proposal_approval')->update(['time_entry' => $tanggal5], ['proposal_id' => $dx, 'flow_id' => 5]);
				if(isset($tanggal6)) $db->table('proposal_approval')->update(['time_entry' => $tanggal6], ['proposal_id' => $dx, 'flow_id' => 6]);
				if(isset($tanggal7)) $db->table('proposal_approval')->update(['time_entry' => $tanggal7], ['proposal_id' => $dx, 'flow_id' => 7]);

				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_detail', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Detail proposal berhasil diedit.']);

				return redirect()->to(site_url('report'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;
		}
	}

	public function cms($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		$db = \Config\Database::connect();
		$session = \Config\Services::session();
		switch($tp){
			//Koordinator
			case 'add_koordinator':
				$role = $this->request->getPost('role');
				$skpd = $this->request->getPost('skpd');
				$name = $this->request->getPost('name');
				$uname = $this->request->getPost('uname');
				$pswd = $this->request->getPost('pswd');
				$repswd = $this->request->getPost('repswd');
				$status = $this->request->getPost('status');
			
			if($role && $name && $uname && $pswd && $repswd){
				$db = \Config\Database::connect();
				$session = \Config\Services::session();
				$request = \Config\Services::request();

				if($pswd == $repswd){
					$data = [
						'name' => $name, 
						'username' => $uname, 
						'password' => password_hash($pswd, PASSWORD_DEFAULT), 
						'role_id' => $role, 
						'is_active' => $status
					];

					if($skpd) {
						$data['is_skpd'] = 1;
						$data['skpd_id'] = $skpd;
					}

					$db->table('user')->insert($data);

					$dx = $db->insertID();
					$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'add_koordinator', 'id' => $dx, 'ip' => $request->getIPAddress()]);

					$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Koordinator berhasil ditambahkan.']);

					return redirect()->to(site_url('cms/koordinator'));
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Password tidak sama.']);

					return redirect()->back();
				}			
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

					return redirect()->back();
				
			}
			break;

			case 'edit_koordinator':
				$role = $this->request->getPost('role');
				$skpd = $this->request->getPost('skpd');
				$name = $this->request->getPost('name');
				$uname = $this->request->getPost('uname');
				$pswd = $this->request->getPost('pswd');
				$repswd = $this->request->getPost('repswd');
				$status = $this->request->getPost('status');	
			
			if($role && $name && $uname){
				if($pswd != '' || $repswd != ''){
					$request = \Config\Services::request();

					if($pswd == $repswd){
						$data = [
							'name' => $name, 
							'username' => $uname, 
							'password' => password_hash($pswd, PASSWORD_DEFAULT), 
							'role_id' => $role, 
							'is_active' => $status
						];

						if($skpd) {
							$data['is_skpd'] = 1;
							$data['skpd_id'] = $skpd;
						} else {
							$data['is_skpd'] = 0;
							$data['skpd_id'] = null;
						}

						$db->table('user')->update($data, ['id' => $dx]);

						$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_koordinator', 'id' => $dx, 'ip' => $request->getIPAddress()]);

						$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Koordinator berhasil diedit.']);

						return redirect()->to(site_url('cms/koordinator'));
					}else{
						$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Password tidak sama.']);

						return redirect()->back();
					}
				}else{
					$request = \Config\Services::request();

					$data = [
						'name' => $name, 
						'username' => $uname, 
						'role_id' => $role, 
						'is_active' => $status
					];

					if($skpd) {
						$data['is_skpd'] = 1;
						$data['skpd_id'] = $skpd;
					} else {
						$data['is_skpd'] = 0;
						$data['skpd_id'] = null;
					}

					$db->table('user')->update($data, ['id' => $dx]);

					$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_koordinator', 'id' => $dx, 'ip' => $request->getIPAddress()]);

					$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Koordinator berhasil diedit.']);

					return redirect()->to(site_url('cms/koordinator'));			
				}							
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'delete_koordinator':
			$request = \Config\Services::request();

			$db->table('user')->delete(['id' => $dx]);

			$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'delete_koordinator', 'id' => $dx, 'ip' => $request->getIPAddress()]);

			$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Koordinator berhasil dihapus.']);

			return redirect()->to(site_url('cms/koordinator'));
			break;


			//Umum
			case 'add_umum':
				
				
				$uname = $this->request->getPost('uname');
				$pswd = $this->request->getPost('pswd');
				$repswd = $this->request->getPost('repswd');
				$status = $this->request->getPost('status');
				$name = $this->request->getPost('name');
				$address = $this->request->getPost('address');
				$phone = $this->request->getPost('phone');
				$ktp = $this->request->getPost('ktp');
				$email = $this->request->getPost('email');
			
			$request = \Config\Services::request();

			if($uname && $pswd && $repswd && $name && $address && $phone && $ktp && $email){
				if($pswd == $repswd){
					$db->table('user')->insert([
						'name' => $name, 
						'email' => $email, 
						'address' => $address, 
						'phone' => $phone, 
						'ktp' => $ktp, 
						'username' => $uname, 
						'password' => password_hash($pswd, PASSWORD_DEFAULT), 
						'role_id' => 6, 
						'is_active' => $status
					]);

					$dx = $db->insertID();
					$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'add_umum', 'id' => $dx, 'ip' => $request->getIPAddress()]);

					$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pendaftaran berhasil. Silahkan sign in untuk masuk.']);

					return redirect()->to(site_url('cms/umum'));
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Password tidak sama.']);

					return redirect()->back();
				}
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'edit_umum':
				$uname = $this->request->getPost('uname');
				$pswd = $this->request->getPost('pswd');
				$repswd = $this->request->getPost('repswd');
				$status = $this->request->getPost('status');
				$name = $this->request->getPost('name');
				$address = $this->request->getPost('address');
				$phone = $this->request->getPost('phone');
				$ktp = $this->request->getPost('ktp');
				$email = $this->request->getPost('email');
			
			$request = \Config\Services::request();

			$data = [
				'name' => $name, 
				'email' => $email, 
				'address' => $address, 
				'phone' => $phone, 
				'ktp' => $ktp, 
				'username' => $uname, 
				'is_active' => $status
			];

			if($uname && $name && $address && $phone && $ktp && $email){
				if($pswd != '' || $repswd != ''){
					if($pswd == $repswd){
						$data['password'] = password_hash($pswd, PASSWORD_DEFAULT);
						$db->table('user')->update($data, ['id' => $dx]);

						$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_umum', 'id' => $dx, 'ip' => $request->getIPAddress()]);

						$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pengguna umum berhasil diedit.']);

						return redirect()->to(site_url('cms/umum'));
					}else{
						$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Password tidak sama.']);

						return redirect()->back();
					}
				}else{
					$db->table('user')->update($data, ['id' => $dx]);

					$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_umum', 'id' => $dx, 'ip' => $request->getIPAddress()]);

					$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pengguna umum berhasil diedit.']);

					return redirect()->to(site_url('cms/umum'));
				}
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->back();
			}
			break;

			case 'delete_umum':
			$request = \Config\Services::request();

			$db->table('user')->delete(['id' => $dx]);

			$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'delete_umum', 'id' => $dx, 'ip' => $request->getIPAddress()]);

			$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pengguna umum berhasil dihapus.']);

			return redirect()->to(site_url('cms/umum'));
			break;


			//Home
			case 'home':			
			$request = \Config\Services::request();
			$files = $request->getFiles();
			if(isset($files['image1'])){
				$path = './media/cms/';
				$new_foto_name = $files['image1']->move($path);

				if(!$new_foto_name){
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah gambar, silakan ulangi lagi.']);
					return redirect()->back();
				}else{
					unlink($path.$request->getPost('old_image1'));
				}

				$db->table('cms')->update(['content' => $new_foto_name], ['page_id' => 'home', 'sequence' => $request->getPost('sequence1')]);
			}

			if(isset($files['image2'])){
				$path = './media/cms/';
				$new_foto_name = $files['image2']->move($path);

				if(!$new_foto_name){
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah gambar, silakan ulangi lagi.']);
					return redirect()->back();
				}else{
					unlink($path.$request->getPost('old_image2'));
				}

				$db->table('cms')->update(['content' => $new_foto_name], ['page_id' => 'home', 'sequence' => $request->getPost('sequence2')]);
			}

			$request = \Config\Services::request();

			$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'home', 'ip' => $request->getIPAddress()]);

			$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Home berhasil diedit.']);

			return redirect()->to(site_url('cms/home'));					
			break;


			//Tentang
			case 'tentang':
				$content = $this->request->getPost('content');
				$session = \Config\Services::session();
				if($content){
					$db->table('cms')->update(['content' => $content], ['page_id' => 'tentang', 'sequence' => $request->getPost('sequence0')]);
				
					$files = $request->getFiles();
				
					if(isset($files['image1'])){
						$path = './media/cms/';
						$new_foto_name = $files['image1']->move($path);
				
						if(!$new_foto_name){
							$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah gambar, silakan ulangi lagi.']);
							return redirect()->back();
						}else{
							unlink($path.$request->getPost('old_image1'));
						}
				
						$db->table('cms')->update(['content' => $new_foto_name], ['page_id' => 'tentang', 'sequence' => $request->getPost('sequence1')]);
					}
				
					if(isset($files['image2'])){
						$path = './media/cms/';
						$new_foto_name = $files['image2']->move($path);
				
						if(!$new_foto_name){
							$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah gambar, silakan ulangi lagi.']);
							return redirect()->back();
						}else{
							unlink($path.$request->getPost('old_image2'));
						}
				
						$db->table('cms')->update(['content' => $new_foto_name], ['page_id' => 'tentang', 'sequence' => $request->getPost('sequence2')]);
					}
				
					$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'tentang', 'ip' => $request->getIPAddress()]);
				
					$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Tentang Sabilulungan berhasil diedit.']);
				
					return redirect()->to(site_url('cms/tentang'));
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
					return redirect()->back();
				}
			break;


			//Peraturan
			case 'add_peraturan':

			$request = \Config\Services::request();
			$session = \Config\Services::session();

			$title = $request->getPost('title');

			if($title){
				$files = $request->getFiles();

				if(isset($files['file'])){
					$path = './media/peraturan/';
					$new_file_name = $files['file']->move($path);

					if(!$new_file_name){
						$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah file, silakan ulangi lagi.']);
						return redirect()->back();
					}
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan masukkan file peraturan.']);
					return redirect()->back();
				}

				$query = $db->query("SELECT sequence FROM cms WHERE `page_id`='peraturan' ORDER BY sequence DESC LIMIT 1");
				$urut = $query->getResult();
				$i = $urut[0]->sequence+1;

				$db->table('cms')->insert(['page_id' => 'peraturan', 'sequence' => $i, 'title' => $title, 'content' => $new_file_name, 'type' => 3]);

				$lastId = $db->insertID();
				$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'add_peraturan', 'id' => $lastId, 'ip' => $request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Peraturan berhasil ditambahkan.']);

				return redirect()->to(site_url('cms/peraturan'));
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
				return redirect()->back();
			}
			break;

			case 'edit_peraturan':
				$request = \Config\Services::request();

				$title = $request->getPost('title');

				if($title){
					$files = $request->getFiles();

					if(isset($files['file'])){
						$path = './media/peraturan/';
						$new_file_name = $files['file']->move($path);

						if(!$new_file_name){
							$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah file, silakan ulangi lagi.']);
							return redirect()->back();
						}else{
							unlink($path.$request->getPost('old_file'));
						}
					}else{
						$new_file_name = $request->getPost('old_file');
					}

					$db->table('cms')->update(['title' => $title, 'content' => $new_file_name], ['page_id' => 'peraturan', 'sequence' => $request->getPost('sequence')]);

					$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_peraturan', 'id' => $request->getPost('sequence'), 'ip' => $request->getIPAddress()]);

					$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Peraturan berhasil diedit.']);

					return redirect()->to(site_url('cms/peraturan'));
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
					return redirect()->back();
				}
			break;

			case 'delete_peraturan':
			$request = \Config\Services::request();

			$dx = $request->getPost('sequence');

			$query = $db->query("SELECT content FROM cms WHERE `page_id`='peraturan' AND sequence='$dx'");
			$urut = $query->getResult();
			$path = './media/peraturan/';

			unlink($path.$urut[0]->content);
			$db->table('cms')->delete(['sequence' => $dx, 'page_id' => 'peraturan']);

			$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'delete_peraturan', 'id' => $dx, 'ip' => $request->getIPAddress()]);

			$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Peraturan berhasil dihapus.']);

			return redirect()->to(site_url('cms/peraturan'));
			break;


			//Pengumuman
			case 'add_pengumuman':
				$request = \Config\Services::request();
				$judul = $request->getPost('judul');
				$konten = $request->getPost('konten');

				if($judul && $konten){
					$db->table('pengumuman')->insert(['judul' => $judul, 'konten' => $konten]);

					$lastId = $db->insertID();
					$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'add_pengumuman', 'id' => $lastId, 'ip' => $request->getIPAddress()]);

					$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pengumuman berhasil ditambahkan.']);

					return redirect()->to(site_url('cms/pengumuman'));
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
					return redirect()->back();
				}
			break;

			case 'edit_pengumuman':
				$request = \Config\Services::request();

				$judul = $request->getPost('judul');
				$konten = $request->getPost('konten');
				$dx = $request->getPost('pengumuman_id');

				if($judul && $konten){
					$db->table('pengumuman')->update(['judul' => $judul, 'konten' => $konten], ['pengumuman_id' => $dx]);

					$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_pengumuman', 'id' => $dx, 'ip' => $request->getIPAddress()]);

					$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pengumuman berhasil diedit.']);

					return redirect()->to(site_url('cms/pengumuman'));
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
					return redirect()->back();
				}
			break;

			case 'delete_pengumuman':
			$request = \Config\Services::request();
			$dx = $request->getPost('pengumuman_id');

			$db->table('pengumuman')->delete(['pengumuman_id' => $dx]);

			$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'delete_pengumuman', 'id' => $dx, 'ip' => $request->getIPAddress()]);

			$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pengumuman berhasil dihapus.']);

			return redirect()->to(site_url('cms/pengumuman'));
		}
	}
	public function realisasi($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		switch($tp){

			//Koordinator
			case 'add_laporan':
				$request = \Config\Services::request();
				$session = \Config\Services::session();
				$db = \Config\Database::connect();
				$file = $request->getFile('laporan');
				
				$tahun = $request->getPost('tahun');
				$anggaran = $request->getPost('anggaran');
				$realisasi_rp = $request->getPost('realisasi_rp');
				$realisasi_persen = $request->getPost('realisasi_persen');
				$penerima_cair = $request->getPost('penerima_cair');
				$penerima_lapor = $request->getPost('penerima_lapor');
				$nilai_lapor = $request->getPost('nilai_lapor');
				
				if($tahun && $anggaran && $realisasi_rp && $realisasi_persen && $penerima_cair && $penerima_lapor && $nilai_lapor){
					if($file->isValid() && !$file->hasMoved()){
						$newName = $file->getRandomName();
						$file->move('./media/laporan/', $newName);
				
						$db->table('laporan')->insert(['tahun' => $tahun, 'anggaran' => $anggaran, 'realisasi_rp' => $realisasi_rp, 'realisasi_persen' => $realisasi_persen, 'penerima_cair' => $penerima_cair, 'penerima_lapor' => $penerima_lapor, 'nilai_lapor' => $nilai_lapor, 'file' => $newName]);
				
						$lastId = $db->insertID();
						$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'add_laporan', 'id' => $lastId, 'ip' => $request->getIPAddress()]);
				
						$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Laporan berhasil ditambahkan.']);
				
						return redirect()->to(site_url('realisasi'));
					}else{
						$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan masukkan Laporan.']);
						return redirect()->back();
					}
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
					return redirect()->back();
				}
			break;

			case 'edit_laporan':
			$request = \Config\Services::request();
			$session = \Config\Services::session();
			$db = \Config\Database::connect();
			$file = $request->getFile('laporan');

			$tahun = $request->getPost('tahun');
			$anggaran = $request->getPost('anggaran');
			$realisasi_rp = $request->getPost('realisasi_rp');
			$realisasi_persen = $request->getPost('realisasi_persen');
			$penerima_cair = $request->getPost('penerima_cair');
			$penerima_lapor = $request->getPost('penerima_lapor');
			$nilai_lapor = $request->getPost('nilai_lapor');
			$old_laporan = $request->getPost('old_laporan');

			if($tahun && $anggaran && $realisasi_rp && $realisasi_persen && $penerima_cair && $penerima_lapor && $nilai_lapor){
				if($file->isValid() && !$file->hasMoved()){
					$newName = $file->getRandomName();
					$file->move('./media/laporan/', $newName);

					if(file_exists('./media/laporan/'.$old_laporan)){
						unlink('./media/laporan/'.$old_laporan);
					}

					$db->table('laporan')->update(['tahun' => $tahun, 'anggaran' => $anggaran, 'realisasi_rp' => $realisasi_rp, 'realisasi_persen' => $realisasi_persen, 'penerima_cair' => $penerima_cair, 'penerima_lapor' => $penerima_lapor, 'nilai_lapor' => $nilai_lapor, 'file' => $newName], ['laporan_id' => $dx]);

					$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'edit_laporan', 'id' => $dx, 'ip' => $request->getIPAddress()]);

					$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Laporan berhasil diedit.']);

					return redirect()->to(site_url('realisasi'));
				}else{
					$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan masukkan Laporan.']);
					return redirect()->back();
				}
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
				return redirect()->back();
			}
			break;

			case 'delete_laporan':
			$db = \Config\Database::connect();
			$session = \Config\Services::session();
			$request = \Config\Services::request();

			$dx = $request->getPost('laporan_id');

			$Qpos = $db->query("SELECT `file` FROM laporan WHERE `laporan_id`='$dx'");
			$pos = $Qpos->getResult();

			$path = './media/laporan/';

			if(file_exists($path.$pos[0]->file)){
				unlink($path.$pos[0]->file);
			}

			$db->table('laporan')->delete(['laporan_id' => $dx]);

			$db->table('log')->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'delete_laporan', 'id' => $dx, 'ip' => $request->getIPAddress()]);

			$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Laporan berhasil dihapus.']);

			return redirect()->to(site_url('realisasi'));
			break;
		}
	}

	public function lpj($tp, $dx=0)
	{
		$session = \Config\Services::session();

		if(!$session->has('sabilulungan')) {
			die('<p align="center">Sesi Anda telah habis!<br />Silakan lakukan <a href="'.site_url('logout').'">otorisasi</a> ulang.</p>');
		}
		switch($tp){

			case 'add':
			$request = \Config\Services::request();
			$session = \Config\Services::session();

			$user_id = $request->getPost('user_id');
			$role_id = $request->getPost('role_id');
			$deskripsi = $request->getPost('deskripsi');

			if($user_id && $role_id){
				$files = $request->getFileMultiple('foto');

				if($files){
					$i = 1;
					foreach ($files as $index => $file) {
						$path = './media/proposal_lpj/';
						if ($file->isValid() && !$file->hasMoved()) {
							$new_file_name = $this->ifunction->upload($path, $file->getName(), $file->getTempName());
							if(file_exists($path.$new_file_name)){
								$this->db->table("proposal_lpj")->insert(['proposal_id' => $dx, 'sequence' => $i, 'path' => $new_file_name, 'description' => $deskripsi[$index]]);
								$i++;
							}else{
								$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Terjadi kesalahan saat mengunggah foto, silakan ulangi lagi.']);

								return redirect()->to(previous_url());
							}

							
						}
						
					}
				}

				$this->db->table("log")->insert(['user_id' => $session->get('sabilulungan')['uid'], 'activity' => 'add_lpj', 'id' => $dx, 'ip' => $request->getIPAddress()]);

				$session->setFlashdata('notify', ['type' => 'success', 'message' => 'Laporan Pertanggung Jawaban berhasil ditambahkan.']);

				return redirect()->to(previous_url());
			}else{
				$session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

				return redirect()->to(previous_url());
			}
			break;
		}
	}
}