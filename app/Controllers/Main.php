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
		$totalproposalstep1 = $this->db->table('proposal')
					->where('YEAR(time_entry)', date('Y'))
					->where('(current_stat = 1 OR current_stat IS NULL)')
					->countAllResults();
				
		$totalproposalstep2 = $this->db->table('proposal')					
					->where('YEAR(time_entry)', date('Y'))
					->where('current_stat', 2)
					->countAllResults();
		$totalproposalstep3 = $this->db->table('proposal')
					->where('YEAR(time_entry)', date('Y'))
					->where('current_stat', 3)
					->countAllResults();
		$totalproposalstep4 = $this->db->table('proposal')
					->where('YEAR(time_entry)', date('Y'))
					->where('current_stat', 4)
					->countAllResults();
		$totalproposalstep5 = $this->db->table('proposal')
					->where('YEAR(time_entry)', date('Y'))
					->where('current_stat', 5)
					->countAllResults();
		$totalproposalstep6 = $this->db->table('proposal')
					->where('YEAR(time_entry)', date('Y'))
					->where('current_stat', 6)
					->countAllResults();
		$totalproposalstep7 = $this->db->table('proposal')
					->where('YEAR(time_entry)', date('Y'))
					->where('current_stat', 7)
					->countAllResults();
		$skpd = $this->db->table('skpd')
					->select('skpd.name, skpd.id')
					->get()
					->getResult();
		$colors = array(
						"#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e",
						"#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
						"#f39c12", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12",
						"#d35400", "#c0392b", "#bdc3c7", "#7f8c8d", "#d35400",
						"#8e44ad", "#3498db", "#e74c3c", "#2ecc71", "#1abc9c",
						"#f1c40f", "#e67e22", "#3498db", "#e74c3c", "#2ecc71",
						"#16a085", "#c0392b", "#8e44ad", "#3498db", "#e74c3c",
						"#2ecc71", "#f1c40f", "#e67e22", "#3498db", "#e74c3c",
						"#2ecc71", "#16a085", "#c0392b", "#8e44ad", "#3498db",
						"#e74c3c", "#2ecc71", "#f1c40f", "#e67e22"
					);
					
			$skpds = $this->db->table('skpd')
				->select('skpd.name, skpd.id')
				->get()
				->getResult();
			
			$resultArray = [
				'labels' => [],
				'datasets' => [
					[
						'data' => [],
						'backgroundColor' => [],
					]
				]
			];
			$totals = [];
			foreach ($skpds as $key => $row) {
				$totalProposalSkpd = $this->db->table('proposal')
					->where('proposal.skpd_id', $row->id)
					->where('YEAR(proposal.time_entry)', date('Y'))
					->countAllResults();
				// Jika datanya 0, lewati iterasi
				if ($totalProposalSkpd == 0) {
					continue;
				}
			
				$colorIndex = $key % count($colors);
				$totals[$row->id] = $totalProposalSkpd;
				$resultArray['labels'][] = $row->name;
				$resultArray['datasets'][0]['data'][] = $totalProposalSkpd;
				$resultArray['datasets'][0]['backgroundColor'][] = $colors[$colorIndex];
			}
			// Urutkan array total proposal secara descending
			arsort($totals);
			// Ambil SKPD dengan total proposal paling besar
			if(count($totals)){
				$selectedSkpd = array_keys($totals)[0];
				// Hitung 10% dari total proposal paling besar
				$persen = $selectedSkpd * 0.1;
			}else{
				$persen = 0;
			}
			$flows = $this->db->table('flow')
			->select('flow.name, flow.id')
			->get()
			->getResult();
		
		$resultArrayFlow = [
			'labels' => [],
			'datasets' => [
				[
					'data' => [],
					'backgroundColor' => [],
				]
			]
		];
		$totalsFlow = [];
		$index =0;
		foreach ($flows as $key => $row) {
			if ($row->id == 1) {
				$totalProposalFlow = $this->db->table('proposal')
				->join('proposal_approval', 'proposal.id = proposal_approval.proposal_id')
				->where('(current_stat = '.$row->id.' OR current_stat IS NULL)')
				->where('YEAR(proposal.time_entry)', date('Y'))
				->countAllResults();
			}else{
				$totalProposalFlow = $this->db->table('proposal')
				->join('proposal_approval', 'proposal.id = proposal_approval.proposal_id')
				->where('proposal.current_stat', $row->id)
				->where('YEAR(proposal.time_entry)', date('Y'))
				->countAllResults();
			}
			
		
			// Jika datanya 0, lewati iterasi
			if ($totalProposalFlow == 0) {
				continue;
			}
		
			$colorIndex = $key % count($colors);
			$totalsFlow[$row->id] = $totalProposalFlow;
			$resultArrayFlow['labels'][] = $row->name;
			$resultArrayFlow['datasets'][0]['data'][] = $totalProposalFlow;
			$resultArrayFlow['datasets'][0]['backgroundColor'][] = $colors[$index];
			$index++;
		}
		
		// Urutkan array total proposal secara descending
		arsort($totalsFlow);
		
		// Ambil Flow dengan total proposal paling besar
		if (count($totalsFlow)) {
			$selectedFlow = array_keys($totalsFlow)[0];
			// Hitung 10% dari total proposal paling besar
			$persenFlow = $selectedFlow * 0.1;
		} else {
			$persenFlow = 0;
		}
		
		return view('content/dashboard',['db' => $this->db, 'ifunction' => $this->ifunction, 'totalProposal' => $totalProposal, 'proposalData' => $proposalData, 'proposalDataTahunIni' => $proposalDataTahunIni, 'totalproposalstep1' => $totalproposalstep1, 'totalproposalstep2' => $totalproposalstep2, 'totalproposalstep3' => $totalproposalstep3, 'totalproposalstep4' => $totalproposalstep4, 'totalproposalstep5' => $totalproposalstep5, 'totalproposalstep6' => $totalproposalstep6, 'totalproposalstep7' => $totalproposalstep7, 'skpd' => $skpd, 'colors' => $colors, 'resultArray' => $resultArray, 'persen' => $persen, 'resultArrayFlow' => $resultArrayFlow, 'persenFlow' => $persenFlow]);	 
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