<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Ifunction;

session();

class Main extends Controller {

	protected $db;
    protected $ifunction;

    public function __construct()
    {
        // Load database
        $this->db = \Config\Database::connect();
        $this->ifunction = new \App\Models\Ifunction();

        // Atau jika ingin menggunakan instance model
        // $this->db = new \App\Models\YourModel();
    }
    public function index()
	{
		return view('content/home',['db' => $this->db, 'ifunction' => $this->ifunction]);
	}
    public function tentang()
	{
		return view('content/tentang',['db' => $this->db, 'ifunction' => $this->ifunction]);
	}
    public function proposal($t=0, $tp=0, $d=0, $dx=0, $id=0, $p=0)
	{
		return view('content/proposal',['db' => $this->db,'t'=>$t,'tp'=>$tp,'d'=>$d,'dx'=>$dx,'id'=>$id,'p'=>$p, 'ifunction' => $this->ifunction]);
	}
    public function peraturan()
	{
		return view('content/peraturan',['db' => $this->db, 'ifunction' => $this->ifunction]);		
	}
    public function lapor()
	{
		return view('content/lapor',['db' => $this->db, 'ifunction' => $this->ifunction]);		
	}
    public function listlaporan($p=0, $dx=0)
	{
		return view('content/listlaporan',['db' => $this->db,'p'=>$p,'dx'=>$dx, 'ifunction' => $this->ifunction]);	
	}
    public function pengumuman($p=0, $dx=0)
	{
	
        return view('content/pengumuman',['db' => $this->db,'p'=>$p,'dx'=>$dx, 'ifunction' => $this->ifunction]);
	}
	public function detail($dx=0)
	{
		return view('content/detail',['db' => $this->db,'dx'=>$dx, 'ifunction' => $this->ifunction]);	
	}
	public function galeri($dx=0)
	{
		return view('content/galeri',['db' => $this->db,'dx'=>$dx, 'ifunction' => $this->ifunction]);		
	}
	public function laporan($dx=0)
	{
		return view('content/laporan',['db' => $this->db,'dx'=>$dx, 'ifunction' => $this->ifunction]);			
	}
	public function view($dx=0)
	{
		return view('content/view',['db' => $this->db,'dx'=>$dx, 'ifunction' => $this->ifunction]);				
	}
	public function bcc()
	{
		return view('content/bcc',['db' => $this->db, 'ifunction' => $this->ifunction]);					
	}
	public function statistik($p=0, $dx=0)
	{
		return view('content/statistik',['db' => $this->db,'p'=>$p,'dx'=>$dx, 'ifunction' => $this->ifunction]);							
	}
}