<?php
class Pegawai extends CI_Controller
{
    public function index(){
        $data['title'] = 'Data Pegawai';
        $data['pegawai'] = $this->GajiModel->getData('data_pegawai')->result();

        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/Vpegawai', $data);
        $this->load->view('template/foot');
    }

    public function add(){
        $this->rulesAdd();
        if ($this->form_validation->run() == false) {
            $this->index();
            redirect('/admin/pegawai');
        } else {
            $nama = $this->input->post('nama');
            $jabatan = $this->input->post('jabatan');
            $jk = $this->input->post('jk');
            $tgl = $this->input->post('tgl');
            $nik1 = str_replace('-', '', $tgl);
            $urut = $this->GajiModel->jmlData('nik', $nik1, 'data_pegawai');
            $nik = $nik1 . sprintf('%03d', $urut);

            $data = array(
                'jabatan' => $jabatan,
                'nama_pegawai' => $nama,
                'jenis_kelamin' => $jk,
                'tgl_masuk' => $tgl,
                'nik' => $nik
            );

            $this->GajiModel->insertData('data_pegawai', $data);
            echo json_encode(array('pesan'=> 'Data berhasil ditambahkan','success'=>true));
            
        }
    }
    // FORM VALIDASI ADD
    public function rulesAdd(){
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tgl', 'Tanggal Masuk', 'required');
    }

    public function update(){
        $this->rulesUpdate();
        if($this->form_validation->run() == false){
            echo json_encode(array('success'=> false));
        }else{
            $nama = $this->input->post('nama');
            $jabatan = $this->input->post('jabatan');
            $id = $this->input->post('id');
            
            $data = array(
                'jabatan'=>$jabatan,
                'nama_pegawai'=>$nama
            );
            $where = array('id'=>$id);
            $this->GajiModel->updateData('data_pegawai',$data,$where);
            echo json_encode(array('pesan'=> 'Data berhasil ditambahkan','success'=>true));

        }
    }

    public function rulesUpdate(){
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'regex_match[/^\d+$/]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('id', 'ID', 'required');
    }

    // kirim data
    public function getAllData()
    {
        
        $newData['data'] = array();
        $data = $this->GajiModel->getData('data_pegawai')->result();
        foreach ($data as $key) {
            $jk = strtolower($key->jenis_kelamin) == 'l' ? 'Laki-laki' : 'Perempuan';
            $jabatan = $this->GajiModel->cariData('id',$key->jabatan,'data_jabatan');
            $jabatanNama = $jabatan != null ? $jabatan->nama : '';
            $jabatanID = $jabatan != null ? $jabatan->id : '';
            $fix = array($key->id, $key->nik, $key->nama_pegawai, $jk, $jabatanNama, $key->tgl_masuk,$jabatanID);
            array_push($newData['data'], $fix);
        }
        echo json_encode($newData);
    }

    public function deleteData()
    {
        $data = $this->input->post('data');
        if (count($data) > 0) {
            foreach ($data as $value) {
                $id = $value[0];
                $nik = $value[1];
                $nama = $value[2];
                $where = array('id' => $id, 'nik' => $nik, 'nama_pegawai' => $nama);
                $this->GajiModel->deleteData('data_pegawai', $where);

            }
            echo json_encode(array('pesan'=> 'Data berhasil dihapus','success'=>true));
        }
    }
}
