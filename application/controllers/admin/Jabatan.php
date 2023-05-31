<?php

class Jabatan extends CI_Controller{
    // function __construct()
    // {
    //     parent::__construct();
    //     $this->load->model('GajiModel');
    // }
    public function index()
    {
        $data['title'] = 'Data Jabatan';
        $data['jabatan'] = $this->GajiModel->getData('data_jabatan')->result();
        $this->load->view('template/head',$data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/Vjabatan',$data);
        $this->load->view('template/foot');
    }

    public function add()
    {
        $this->rulesAdd();
        if($this->form_validation->run() == false){
            $this->index();
            redirect('/admin/jabatan');

        }else{
            $jabatan = $this->input->post('jabatan');
            $uang_trans = $this->input->post('uang_trans');
            $uang_makan = $this->input->post('uang_makan');
            $gaji = $this->input->post('gaji');

            $data = array(
                'nama' => $jabatan,
                'tunj_makan' => str_replace('.','',$uang_makan),
                'tunj_transport' => str_replace('.','',$uang_trans),
                'gaji' => str_replace('.','',$gaji)
            );

            $this->GajiModel->insertData('data_jabatan',$data);
            echo json_encode(array('success'=>true));
            
        }
        
    }

    
    // FORM VALIDASI
    public function rulesAdd()
    {
        $this->form_validation->set_rules('jabatan','Jabatan','required');
        $this->form_validation->set_rules('uang_trans','Uang Transport','required');
        $this->form_validation->set_rules('uang_makan','Uang Makan','required');
        $this->form_validation->set_rules('gaji','Gaji','required');
    }    
    
    // kirim data
    public function getAllData()
    {   
        $newData['data'] = array();
        // $this->db->select('nama,gaji,tunj_transport,tunj_makan');
        $data = $this->GajiModel->getData('data_jabatan')->result();
        foreach ($data as $key ) {
            $total = $key->tunj_makan + $key->gaji + $key->tunj_transport;
            $fix = array($key->id,$key->nama,$key->tunj_transport,$key->tunj_makan,$key->gaji,$total);
            array_push($newData['data'],$fix);
        }
        echo json_encode($newData);
    }

    public function getAllDataFull()
    {   
        $newData['data'] = array();
        // $this->db->select('nama,gaji,tunj_transport,tunj_makan');
        $data = $this->GajiModel->getData('data_jabatan')->result();
        foreach ($data as $key ) {
            $fix['nama'] = $key->nama;
            $fix['id'] = $key->id;
            $fix['gaji'] = $key->gaji;
            $fix['tunj_transport'] = $key->tunj_transport;
            $fix['tunj_makan'] = $key->tunj_makan;
            $fix['total'] = $key->tunj_makan + $fix['gaji'] + $fix['tunj_transport'];
            array_push($newData['data'],$fix);
        }
        echo json_encode($newData);
    }

    public function updateDataJabatan()
    {        
        
        $uang_trans = $this->input->post('uang_trans');
        $uang_makan = $this->input->post('uang_makan');
        $gaji = $this->input->post('gaji');
        $uang_transOld = $this->input->post('transOld');
        $uang_makanOld = $this->input->post('makanOld');
        $gajiOld = $this->input->post('gajiOld');
        $jabatanOld = $this->input->post('jabatanOld');
        
        $data = array(
            'tunj_makan' => str_replace('.','',$uang_makan),
            'tunj_transport' => str_replace('.','',$uang_trans),
            'gaji' => str_replace('.','',$gaji)
        );
        $where = array(
            'nama' => $jabatanOld,
            'tunj_makan' => str_replace('.','',$uang_makanOld),
            'tunj_transport' => str_replace('.','',$uang_transOld),
            'gaji' => str_replace('.','',$gajiOld)
        );



        $this->GajiModel->updateData('data_jabatan',$data,$where);
           echo json_encode(array('success'=>true));
    }
}