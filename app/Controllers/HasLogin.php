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
        $limit = 15;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $this->db->_protect_identifiers=false;
        if(isset($_POST['search'])){
            //Query Search
            $builder = $this->db->table('proposal');
            $builder->select("proposal.id, proposal.name, proposal.address, proposal.judul, proposal.current_stat, proposal.nphd, proposal.tanggal_lpj, proposal_checklist.value,(SELECT SUM(amount) FROM proposal_dana WHERE proposal_dana.proposal_id = proposal.id) as total_amount");
            $builder->join('proposal_checklist', 'proposal.id = proposal_checklist.proposal_id');
            $builder->where('proposal_checklist.checklist_id', 28);
            $builder->like('proposal.name', $_POST['keyword']);
            $builder->orderBy('proposal.id', 'DESC');
            $builder->limit($limit, $position);
            $Qlist = $builder->get()->getResult();
        }elseif(isset($_POST['filter'])){
            $kategori = $_POST['kategori'];
            $dari = $_POST['dari'];
            $sampai = $_POST['sampai'];
            $skpd = $_POST['skpd'];            
            $where = ''; 
            $stat = 'proposal.current_stat=7';
            //kategori
            if($kategori && !$dari && !$sampai && !$skpd){
                if($kategori=='all') $where .= "$stat";
                else $where .= "WHERE proposal.type_id = $kategori AND $stat";
            }elseif($kategori && $dari && !$sampai && !$skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND $stat";
            }elseif($kategori && !$dari && $sampai && !$skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            }elseif($kategori && !$dari && !$sampai && $skpd){
                if($kategori=='all' AND $skpd=='all') $where .= "$stat";
                elseif($kategori!='all' AND $skpd=='all') $where .= "WHERE proposal.type_id = $kategori AND $stat";
                elseif($kategori=='all' AND $skpd!='all') $where .= "WHERE proposal.skpd_id = $skpd AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND proposal.skpd_id = $skpd AND $stat";
            }                        

            //dari
            elseif(!$kategori && $dari && !$sampai && !$skpd) $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND $stat";
            elseif(!$kategori && $dari && $sampai && !$skpd) $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            elseif(!$kategori && $dari && !$sampai && $skpd){
                if($skpd=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND $stat";
                else $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND proposal.skpd_id = $skpd AND $stat";
            }

            //sampai
            elseif(!$kategori && !$dari && $sampai && !$skpd) $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            elseif(!$kategori && !$dari && $sampai && $skpd){
                if($skpd=='all') $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
            }

            //skpd
            elseif(!$kategori && !$dari && !$sampai && $skpd){
                if($skpd=='all') $where .= "$stat";
                else $where .= "WHERE proposal.skpd_id = $skpd AND $stat";
            }

            //mixed
            elseif($kategori && $dari && $sampai && !$skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            }elseif(!$kategori && $dari && $sampai && $skpd){
                if($skpd=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE proposal.skpd_id = $skpd AND YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            }elseif($kategori && $dari && !$sampai && $skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND proposal.skpd_id = $skpd AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND proposal.skpd_id = $skpd AND $stat";
            }elseif($kategori && !$dari && $sampai && $skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
            }elseif($kategori && $dari && $sampai && $skpd){
                if($kategori=='all' && $skpd=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                elseif($kategori!='all' && $skpd=='all') $where .= "WHERE type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                elseif($kategori=='all' && $skpd!='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
            }

            $Qlist = $this->db->query("SELECT proposal.id, proposal.maksud_tujuan, proposal.name, proposal.address, proposal.judul, proposal.current_stat, proposal.nphd, proposal.tanggal_lpj, proposal_checklist.value,(SELECT SUM(amount) FROM proposal_dana WHERE proposal_dana.proposal_id = proposal.id) as total_amount FROM proposal 
            JOIN proposal_checklist ON proposal.id = proposal_checklist.proposal_id
            $where AND proposal_checklist.checklist_id = 28
            ORDER BY proposal.id DESC 
            LIMIT $position,$limit")->getResult();           
        }else{
            //Query List
            
            $builder = $this->db->table('proposal');
            $builder->select("proposal.id, proposal.name, proposal.maksud_tujuan, proposal.address, proposal.judul, proposal.current_stat, proposal.nphd, proposal.tanggal_lpj, 
            (SELECT proposal_checklist.value FROM proposal_checklist WHERE proposal_checklist.proposal_id = proposal.id AND (proposal_checklist.checklist_id IS NULL OR proposal_checklist.checklist_id IN (26, 28)) LIMIT 1) as value,
            (SELECT SUM(amount) FROM proposal_dana WHERE proposal_dana.proposal_id = proposal.id) as total_amount");
            if (isset($_POST['keyword'])) {
                $builder->like('proposal.judul', $_POST['keyword']);
            }
            $builder->orderBy('proposal.id', 'DESC');
            $builder->limit($limit, $position);
            $Qlist = $builder->get()->getResult();
        }
        if($session->has('sabilulungan')) {
            return view('content/report',['db' => $this->db,'p'=>$p,'dx'=>$dx, 'ifunction' => $this->ifunction, 'Qlist' => $Qlist]);
        }else{
            return redirect()->to(base_url('login'));
        }
		
	}
    public function tapd_report($p=0, $dx=0)
	{
		
        $session = \Config\Services::session();
        $limit = 15;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $this->db->_protect_identifiers=false;
        if(isset($_POST['search'])){
            //Query Search
            $builder = $this->db->table('proposal');
            $builder->select("proposal.id, proposal.name, proposal.address, proposal.judul, proposal.current_stat, proposal.nphd, proposal.tanggal_lpj, proposal_checklist.value,(SELECT SUM(amount) FROM proposal_dana WHERE proposal_dana.proposal_id = proposal.id) as total_amount");
            $builder->join('proposal_checklist', 'proposal.id = proposal_checklist.proposal_id');
            $builder->where('proposal_checklist.checklist_id', 28);
            $builder->like('proposal.name', $_POST['keyword']);
            $builder->orderBy('proposal.id', 'DESC');
            $builder->limit($limit, $position);
            $Qlist = $builder->get()->getResult();
        }elseif(isset($_POST['filter'])){
            $kategori = $_POST['kategori'];
            $dari = $_POST['dari'];
            $sampai = $_POST['sampai'];
            $skpd = $_POST['skpd'];            
            $where = ''; 
            $stat = 'proposal.current_stat=7';
            //kategori
            if($kategori && !$dari && !$sampai && !$skpd){
                if($kategori=='all') $where .= "$stat";
                else $where .= "WHERE proposal.type_id = $kategori AND $stat";
            }elseif($kategori && $dari && !$sampai && !$skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND $stat";
            }elseif($kategori && !$dari && $sampai && !$skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            }elseif($kategori && !$dari && !$sampai && $skpd){
                if($kategori=='all' AND $skpd=='all') $where .= "$stat";
                elseif($kategori!='all' AND $skpd=='all') $where .= "WHERE proposal.type_id = $kategori AND $stat";
                elseif($kategori=='all' AND $skpd!='all') $where .= "WHERE proposal.skpd_id = $skpd AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND proposal.skpd_id = $skpd AND $stat";
            }                        

            //dari
            elseif(!$kategori && $dari && !$sampai && !$skpd) $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND $stat";
            elseif(!$kategori && $dari && $sampai && !$skpd) $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            elseif(!$kategori && $dari && !$sampai && $skpd){
                if($skpd=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND $stat";
                else $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND proposal.skpd_id = $skpd AND $stat";
            }

            //sampai
            elseif(!$kategori && !$dari && $sampai && !$skpd) $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            elseif(!$kategori && !$dari && $sampai && $skpd){
                if($skpd=='all') $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
            }

            //skpd
            elseif(!$kategori && !$dari && !$sampai && $skpd){
                if($skpd=='all') $where .= "$stat";
                else $where .= "WHERE proposal.skpd_id = $skpd AND $stat";
            }

            //mixed
            elseif($kategori && $dari && $sampai && !$skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            }elseif(!$kategori && $dari && $sampai && $skpd){
                if($skpd=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE proposal.skpd_id = $skpd AND YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
            }elseif($kategori && $dari && !$sampai && $skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND proposal.skpd_id = $skpd AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND proposal.skpd_id = $skpd AND $stat";
            }elseif($kategori && !$dari && $sampai && $skpd){
                if($kategori=='all') $where .= "WHERE YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
            }elseif($kategori && $dari && $sampai && $skpd){
                if($kategori=='all' && $skpd=='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                elseif($kategori!='all' && $skpd=='all') $where .= "WHERE type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND $stat";
                elseif($kategori=='all' && $skpd!='all') $where .= "WHERE YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
                else $where .= "WHERE proposal.type_id = $kategori AND YEAR(proposal.time_entry) >= '$dari' AND YEAR(proposal.time_entry) <= '$sampai' AND proposal.skpd_id = $skpd AND $stat";
            }

            $Qlist = $this->db->query("SELECT proposal.id, proposal.maksud_tujuan, proposal.name, proposal.address, proposal.judul, proposal.current_stat, proposal.nphd, proposal.tanggal_lpj, proposal_checklist.value,(SELECT SUM(amount) FROM proposal_dana WHERE proposal_dana.proposal_id = proposal.id) as total_amount FROM proposal 
            JOIN proposal_checklist ON proposal.id = proposal_checklist.proposal_id
            $where AND proposal_checklist.checklist_id = 28
            ORDER BY proposal.id DESC 
            LIMIT $position,$limit")->getResult();           
        }else{
            //Query List
            
            $builder = $this->db->table('proposal');
            $builder->select("proposal.id, proposal.name, proposal.maksud_tujuan, proposal.address, proposal.judul, proposal.current_stat, proposal.nphd, proposal.tanggal_lpj, proposal_checklist.value, 
            (SELECT SUM(amount) FROM proposal_dana WHERE proposal_dana.proposal_id = proposal.id) as total_amount");
            $builder->join('proposal_checklist', 'proposal.id = proposal_checklist.proposal_id');
            if (isset($_POST['keyword'])) {
                $builder->like('proposal.judul', $_POST['keyword']);
            }
            $builder->where('proposal_checklist.checklist_id', 28);
            $builder->orderBy('proposal.id', 'DESC');
            $builder->limit($limit, $position);
            $Qlist = $builder->get()->getResult();
        }
        $userid=$session->get('sabilulungan')['uid'];

        if($session->has('sabilulungan')) {
            return view('content/tapd-report',['db' => $this->db,'p'=>$p,'dx'=>$dx, 'ifunction' => $this->ifunction, 'Qlist' => $Qlist, 'userid' => $userid]);
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