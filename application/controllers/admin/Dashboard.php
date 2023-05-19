<?php
class Dashboard extends CI_Controller {
    public function index(){
        $data['title'] = 'DASHBOARD';
        $this->load->view('template/head',$data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/dashboard',$data);
        $this->load->view('template/foot');
    }
    
}