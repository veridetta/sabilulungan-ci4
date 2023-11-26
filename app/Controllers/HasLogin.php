<?php

namespace App\Controllers;

use CodeIgniter\Controller;

session();

class HasLogin extends Controller {

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
    public function report($p=0, $dx=0)
	{
		
        $session = \Config\Services::session();

        if($session->has('sabilulungan')) {
            return view('content/report',['db' => $this->db,'p'=>$p,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }
		
	}
    public function hibah($tp='', $dx=0)
	{
		
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && ($session->get('sabilulungan')['role'] == 6 || $session->get('sabilulungan')['role'] == 7 || $session->get('sabilulungan')['role'] == 5 || $session->get('sabilulungan')['role'] == 9)) {
            return view('content/hibah',['db' => $this->db,'tp'=>$tp,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }	
	}
    public function tatausaha($tp='', $dx=0)
	{
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && ($session->get('sabilulungan')['role'] == 5 || $session->get('sabilulungan')['role'] == 7 || $session->get('sabilulungan')['role'] == 9)) {
            return view('content/tatausaha',['db' => $this->db,'tp'=>$tp,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }
		
	}

    public function walikota($tp='', $dx=0)
	{
		
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && ($session->get('sabilulungan')['role'] == 1 || $session->get('sabilulungan')['role'] == 7 || $session->get('sabilulungan')['role'] == 9)) {
            return view('content/walikota',['db' => $this->db,'tp'=>$tp,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }
	}
    public function pertimbangan($tp='', $dx=0)
	{
		
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && ($session->get('sabilulungan')['role'] == 4 || $session->get('sabilulungan')['role'] == 7 || $session->get('sabilulungan')['role'] == 9)) {
            return view('content/pertimbangan',['db' => $this->db,'tp'=>$tp,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }
	}
    public function skpd($tp='', $dx=0)
	{
		
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && ($session->get('sabilulungan')['role'] == 3 || $session->get('sabilulungan')['role'] == 7 || $session->get('sabilulungan')['role'] == 9)) {
            return view('content/skpd',['db' => $this->db,'tp'=>$tp,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }
	}
    public function tapd($tp='', $p=0, $dx=0)
	{
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && ($session->get('sabilulungan')['role'] == 2 || $session->get('sabilulungan')['role'] == 7 || $session->get('sabilulungan')['role'] == 9)) {
            return view('content/tapd',['db' => $this->db,'tp'=>$tp,'p'=>$p,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }
	}
    
    public function admin($tp='', $dx=0)
	{
		
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && ($session->get('sabilulungan')['role'] == 7 || $session->get('sabilulungan')['role'] == 9)) {
            return view('content/admin',['db' => $this->db,'tp'=>$tp,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));		
        }
		
	}

    public function detil($tp='', $dx=0)
	{
		
        $session = \Config\Services::session();

        if($session->has('sabilulungan')) {
            return view('content/detil',['db' => $this->db,'tp'=>$tp,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }
	}
    public function cms($tp='koordinator', $p=0, $dx=0)
	{
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && $session->get('sabilulungan')['role'] == 9) {
            return view('content/cms',['db' => $this->db,'tp'=>$tp,'p'=>$p,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }
	}
    public function realisasi($tp='index', $p=0, $dx=0)
	{
		
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && $session->get('sabilulungan')['role'] == 9) {
            return view('content/realisasi',['db' => $this->db,'tp'=>$tp,'p'=>$p,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        }else{
            return redirect()->to(base_url('login'));
        }
	}

    public function lpj($tp='list', $dx=0, $p=0)
	{
		
        $session = \Config\Services::session();

        if($session->has('sabilulungan') && ($session->get('sabilulungan')['role'] == 6 || $session->get('sabilulungan')['role'] == 7 || $session->get('sabilulungan')['role'] == 9)) {
            return view('content/lpj',['db' => $this->db,'tp'=>$tp,'dx'=>$dx,'p'=>$p, 'ifunction' => $this->ifunction]);
        } else {
            return redirect()->to(base_url('login'));
        }
	}

    public function form($tp = null, $dx = 0)
    {
        $session = \Config\Services::session();

        if($session->has('sabilulungan')){
            return view('content/form',['db' => $this->db,'tp'=>$tp,'dx'=>$dx, 'ifunction' => $this->ifunction]);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
}