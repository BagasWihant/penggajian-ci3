<?php

class Jabatan extends CI_Controller{
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
            $this->session->set_flashdata('pesan','Data berhasil ditambahkan');
            redirect('/admin/jabatan');
        }
        
    }
    public function rulesAdd()
    {
        $this->form_validation->set_rules('jabatan','Jabatan','required');
        $this->form_validation->set_rules('uang_trans','Uang Transport','required');
        $this->form_validation->set_rules('uang_makan','Uang Makan','required');
        $this->form_validation->set_rules('gaji','Gaji','required');
    }
}