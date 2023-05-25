<?php
class Pegawai extends CI_Controller {
    public function index(){
        $data['title'] = 'Data Pegawai';
        $data['pegawai'] = $this->GajiModel->getData('data_pegawai')->result();
        $this->load->view('template/head',$data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/Vpegawai',$data);
        $this->load->view('template/foot');
    }
    
}