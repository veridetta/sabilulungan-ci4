<?php

namespace App\Controllers;

use CodeIgniter\Controller;

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
                    $builder->select("id, name, role_id, skpd_id");
                    $builder->where("username", $uname);
                    $builder->where("password", $this->ifunction->pswd($ifpsd));
                    $builder->where("is_active", 1);
                    $Qcheck = $builder->get();

                    if($Qcheck->getNumRows()){
                        $check = $Qcheck->getResult();

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

                if($uname && $pswd && $repswd && $name && $address && $phone && $ktp && $email){
                    if($pswd == $repswd){
                        $db = \Config\Database::connect();
                        $db->table('user')->insert([
                            'name' => $name,
                            'email' => $email,
                            'address' => $address,
                            'phone' => $phone,
                            'ktp' => $ktp,
                            'username' => $uname,
                            'password' => $this->ifunction->pswd($pswd),
                            'role_id' => 6
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
}