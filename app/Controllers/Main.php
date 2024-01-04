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
	public function infografis(){
		//total proposaltahun ini
		$totalProposal = $this->db->table('proposal')
			->where('YEAR(time_entry)', date('Y'))
			->countAllResults();
		$proposalData = $this->db->table('proposal')
				->join('proposal_approval', 'proposal.id = proposal_approval.proposal_id')
				->where('proposal_approval.flow_id >', 3)
				->select('proposal.judul, proposal.id,proposal.name')
				->get()
				->getResult();
		$proposalDataTahunIni = $this->db->table('proposal')
					->join('proposal_approval', 'proposal.id = proposal_approval.proposal_id')
					->where('proposal_approval.flow_id >', 6)
					->where('YEAR(proposal.time_entry)', date('Y'))
					->select('proposal.judul, proposal.id,proposal.name')
					->get()
					->getResult();
		return view('content/dashboard',['db' => $this->db, 'ifunction' => $this->ifunction, 'totalProposal' => $totalProposal, 'proposalData' => $proposalData, 'proposalDataTahunIni' => $proposalDataTahunIni]);	 
	}
	public function api() {
		$builder = $this->db->table('proposal');
		$builder->select("proposal.id AS noreg, skpd.name AS opd, proposal.name AS nama_pengaju, proposal.judul, proposal.latar_belakang, proposal.maksud_tujuan, proposal.address AS alamat, proposal_dana.amount AS nilai, proposal_type.name AS type, proposal.current_stat AS level_tahap, flow.name AS tahapan, YEAR(proposal.time_entry) AS tahun");
		$builder->join('flow', 'proposal.current_stat = flow.id', 'left');
		$builder->join('proposal_dana', 'proposal_dana.proposal_id = proposal.id');
		$builder->join('skpd', 'skpd.id = proposal.skpd_id');
		$builder->join('proposal_type', 'proposal_type.id = proposal.type_id');
		$builder->where("proposal_dana.sequence", '1');
		$builder->where("YEAR(proposal.time_entry)", "YEAR(CURRENT_DATE)", false);
		$builder->orderBy('proposal.current_stat');
		$results = $builder->get()->getResult();

		return $this->response->setJSON($results);
	}
	public function getOrganisasi()
    {
		//get post
        $request = $this->request->getPost(); 

        $builder = $this->db->table('organisasi a');
        $builder->select('a.id, a.name, a.legal, a.address, a.phone');
        $builder->orderBy('a.name', 'ASC');

        // Menentukan apakah ada kata kunci pencarian
        if (isset($request['keyword']) && !empty($request['keyword'])) {
            $builder->like('a.name', $request['keyword']);
        }

        $query = $builder->get();
        $data = $query->getResult();

        return $this->response->setJSON($data);
    }
}