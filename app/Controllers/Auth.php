<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

session();

class Auth extends Controller {

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
    public function login(){
        return view('content/login',['db' => $this->db, 'ifunction' => $this->ifunction]);
    }
    public function user($tp, $dx=0)
    {
        helper('url');
        $session = \Config\Services::session();

        switch($tp){
            case 'login':
                $uname = strip_tags($this->request->getPost('uname'));
                $ifpsd = strip_tags($this->request->getPost('pswd'));

                if($uname && $ifpsd){
                    $db = \Config\Database::connect();
                    $builder = $db->table('user');
                    $builder->select("id, name, role_id, skpd_id, is_active");
                    $builder->where("username", $uname);
                    $builder->where("password", $this->ifunction->pswd($ifpsd));
                    $Qcheck = $builder->get();

                    if($Qcheck->getNumRows()){
                        $check = $Qcheck->getResult();
                        if($check[0]->is_active == 1){
                            
                            $session->set('sabilulungan', [
                                'uid' => $check[0]->id,
                                'name' => $check[0]->name,
                                'role' => $check[0]->role_id,
                                'skpd' => $check[0]->skpd_id,
                                'base_url' => base_url()
                            ]);

                            $db->table('log')->insert(['user_id' => $check[0]->id, 'activity' => 'login', 'ip' => $this->request->getIPAddress()]);

                            return redirect()->to(base_url());
                        }else{
                            $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Akun Anda belum aktif. Silahkan hubungi administrator.']);

                            return redirect()->back();
                        }
                    }else{
                        $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Username dan password Anda tidak sesuai.']);

                        return redirect()->back();
                    }
                }else{
                    $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silakan lengkapi formulir berikut.']);

                    return redirect()->back();
                }
                break;

            case 'register':
                $uname = $this->request->getPost('uname');
                $pswd = $this->request->getPost('pswd');
                $repswd = $this->request->getPost('repswd');
                $name = $this->request->getPost('name');
                $address = $this->request->getPost('address');
                $phone = $this->request->getPost('phone');
                $ktp = $this->request->getPost('ktp');
                $email = $this->request->getPost('email');
                //cek email apakah sudah terdaftar
                if($email){
                    $db = \Config\Database::connect();
                    $builder = $db->table('user');
                    $builder->select("id");
                    $builder->where("email", $email);
                    $Qcheck = $builder->get();

                    if($Qcheck->getNumRows()){
                        $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Email sudah terdaftar.']);

                        return redirect()->back();
                    }
                }
                if($uname && $pswd && $repswd && $name && $address && $phone && $ktp && $email){
                    if($pswd == $repswd){
                        $verificationCode = $this->generateVerificationCode(); // Fungsi untuk menghasilkan kode verifikasi
                        $this->sendVerificationEmail($email, $verificationCode);

                        $db = \Config\Database::connect();
                        $db->table('user')->insert([
                            'name' => $name,
                            'email' => $email,
                            'address' => $address,
                            'phone' => $phone,
                            'ktp' => $ktp,
                            'username' => $uname,
                            'password' => $this->ifunction->pswd($pswd),
                            'role_id' => 6,
                            'is_active'=> 0,
                            'code'=>$verificationCode
                        ]);

                        $dx = $db->insertID();
                        $user_id = $session->get('sabilulungan')['uid'] ?? $dx;
                        $db->table('log')->insert(['user_id' => $user_id, 'activity' => 'register', 'id' => $dx, 'ip' => $this->request->getIPAddress()]);

                        $session->setFlashdata('notify', ['type' => 'success', 'message' => 'Pendaftaran berhasil. Silahkan sign in untuk masuk.']);

                        return redirect()->back();
                    }else{
                        $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Password tidak sama.']);

                        return redirect()->back();
                    }
                }else{
                    $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);

                    return redirect()->back();
                }
                break;
        }
    }
    public function logout($dx=0)
	{
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        $request = \Config\Services::request();

        $dx = $session->get('sabilulungan')['uid'];

        $session->remove('sabilulungan');

        $db->table('log')->insert(['user_id' => $dx, 'activity' => 'logout', 'ip' => $request->getIPAddress()]);

        return redirect()->to(base_url());
	}
    
    public function daftar()
	{
        return view('content/daftar',['db' => $this->db, 'ifunction' => $this->ifunction]);
	}
    public function sandi()
	{
		        return view('content/sandi',['db' => $this->db, 'ifunction' => $this->ifunction]);	
	}
    // Fungsi untuk mengirim email verifikasi
    function sendVerificationEmail($toEmail, $verificationCode) {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            //             sabilulungan442@gmail.com
            // Sabilulungan12345
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sabilulungan442@gmail.com'; // Email pengirim
            $mail->Password   = 'yourpassword';     // Password email pengirim
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('sabilulungan442@gmail.com', 'CS Sabilulungan');
            $mail->addAddress($toEmail); // Email penerima

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Verifikasi Email';
            $mail->Body    = 'Kode verifikasi Anda adalah: ' . $verificationCode;

            $mail->send();
            echo 'Email berhasil dikirim';
        } catch (Exception $e) {
            echo "Email gagal dikirim. Pesan error: {$mail->ErrorInfo}";
        }
    }

    // Fungsi untuk menghasilkan kode verifikasi
    function generateVerificationCode() {
        // Generate kode verifikasi acak, Anda dapat menyesuaikan logika sesuai kebutuhan Anda
        return substr(md5(uniqid(mt_rand(), true)), 0, 6); // Contoh kode verifikasi 6 karakter
    }
    public function confirm(){
        return view('content/confirm',['db' => $this->db, 'ifunction' => $this->ifunction]);
    }
    public function resend(){
        return view('content/resend',['db' => $this->db, 'ifunction' => $this->ifunction]);
    }
    //handel resend_post
    public function resend_post(){
        $email = $this->request->getPost('email');
        $session = \Config\Services::session();
        //check empty
        if(empty($email)){
            $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
            return redirect()->back();
        }
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->select("id, name, role_id, skpd_id, is_active");
        $builder->where("email", $email);
        $Qcheck = $builder->get();
        if($Qcheck->getNumRows()){
            $check = $Qcheck->getResult();
            $verificationCode = $this->generateVerificationCode(); // Fungsi untuk menghasilkan kode verifikasi
            $this->sendVerificationEmail($email, $verificationCode);
            $db->table('user')->where('email', $email)->update(['code'=>$verificationCode]);
            return redirect()->to(base_url('confirm'));
        }else{
            $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Email tidak terdaftar.']);
            return redirect()->back();
        }
    }
    //handel confirm_post
    public function confirm_post(){
        $email = $this->request->getPost('email');
        $code = $this->request->getPost('code');
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        //check empty
        if(empty($email) || empty($code)){
            $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Silahkan lengkapi formulir berikut.']);
            return redirect()->back();
        }
        $builder = $db->table('user');
        $builder->select("id, name, role_id, skpd_id, is_active");
        $builder->where("email", $email);
        $builder->where("code", $code);
        $Qcheck = $builder->get();
        if($Qcheck->getNumRows()){
            $check = $Qcheck->getResult();
            $db->table('user')->where('email', $email)->update(['is_active'=>1]);
            return redirect()->to(base_url('login'));
        }else{
            $session->setFlashdata('notify', ['type' => 'failed', 'message' => 'Kode verifikasi salah.']);
            return redirect()->back();
        }
    }
}