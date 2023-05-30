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

    public function add()
    {
        $this->rulesAdd();
        if($this->form_validation->run() == false){
            $this->index();
            redirect('/admin/pegawai');

        }else{
            $nama = $this->input->post('nama');
            $jabatan = $this->input->post('jabatan');
            $jk = $this->input->post('jk');
            $tgl = $this->input->post('tgl');
            $nik1 = str_replace('-','',$tgl);
            // echo $nik;
            $urut = $this->GajiModel->jmlData('nik',$nik1,'data_pegawai')->count_all_results();
            $nik = $nik1.sprintf('%03d',$urut);
            
            $data = array(
                'jabatan' => $jabatan,
                'nama_pegawai' => $nama,
                'jenis_kelamin' => $jk,
                'tgl_masuk' => $tgl,
                'nik' => $nik
            );

            $this->GajiModel->insertData('data_pegawai',$data);
            $this->session->set_flashdata('pesan','Data berhasil ditambahkan');
            redirect('/admin/pegawai');
        }
        
    }
    // FORM VALIDASI
    public function rulesAdd()
    {
        $this->form_validation->set_rules('jabatan','Jabatan','required');
        $this->form_validation->set_rules('nama','Nama','required');
        $this->form_validation->set_rules('jk','Jenis Kelamin','required');
        $this->form_validation->set_rules('tgl','Tanggal Masuk','required');
    }  

    // kirim data
    public function getAllData()
    {   
        $newData['data'] = array();
        // $this->db->select('nama,gaji,tunj_transport,tunj_makan');
        $data = $this->GajiModel->getData('data_pegawai')->result();
        foreach ($data as $key ) {
            $fix['nik'] = $key->nik;
            $fix['nama'] = $key->nama_pegawai;
            $fix['jk'] = strtolower($key->jenis_kelamin) == 'l' ? 'Laki-laki' : 'Perempuan';
            $fix['jab'] = $key->jabatan;
            $fix['tgl_masuk'] = $key->tgl_masuk;
            array_push($newData['data'],$fix);
        }
        echo json_encode($newData);
    }
    
}