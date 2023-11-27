<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

session();

class Kesbangpol extends Controller {

	protected $db;
    protected $ifunction;
    protected $session;
    protected $helpers = ['html', 'url'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['html', 'url']);
        $this->ifunction = new \App\Models\Ifunction();
        $this->session = \Config\Services::session();
    }
    public function ajaxList()
    {
        $request = Services::request();
        $datatable = new UserDatatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->address;
                $row[] = $list->phone;
                $row[] = $list->legal;
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    public function organisasi($p=0,$q=""){
        //get $post keyword
        $request = Services::request();
        $keyword = $request->getPost('keyword');
        return view('content/kesbangpol/organisasi',['db'=>$this->db,'ifunction'=>$this->ifunction,'p'=>$p,'q'=>$keyword]);
    }
    public function add_organisasi(){
        return view('content/kesbangpol/add_organisasi',['db'=>$this->db,'ifunction'=>$this->ifunction]);
    }

    public function proses_organisasi(){
        $request = Services::request();
        $data = [
            'name' => $request->getPost('name'),
            'address' => $request->getPost('address'),
            'phone' => $request->getPost('phone'),
            'legal' => $request->getPost('status'),
            'user_id'=> $this->session->get('sabilulungan')['uid'],
        ];
        $this->db->table('organisasi')->insert($data);
        $this->session->setFlashdata('notify', ['message' => 'Data berhasil disimpan', 'type' => 'success']);
        return redirect()->to(base_url('organisasi'));
    }

    public function edit_organisasi($id){
        $data = $this->db->table('organisasi')->where('id',$id)->get()->getRowArray();
        return view('content/kesbangpol/edit_organisasi',['db'=>$this->db,'ifunction'=>$this->ifunction,'data'=>$data]);
    }

    public function proses_edit_organisasi(){
        $request = Services::request();
        $data = [
            'name' => $request->getPost('name'),
            'address' => $request->getPost('address'),
            'phone' => $request->getPost('phone'),
            'legal' => $request->getPost('status'),
            'user_id'=> $this->session->get('sabilulungan')['uid'],
        ];
        $this->db->table('organisasi')->where('id',$request->getPost('id'))->update($data);
        $this->session->setFlashdata('notify', ['message' => 'Data berhasil disimpan', 'type' => 'success']);
        return redirect()->to(base_url('organisasi'));
    }

    public function delete_organisasi($id){
        $this->db->table('organisasi')->where('id',$id)->delete();
        $this->session->setFlashdata('notify', ['message' => 'Data berhasil dihapus', 'type' => 'success']);
        return redirect()->to(base_url('organisasi'));
    }
    
}