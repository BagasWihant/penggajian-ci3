<?php

class Absensi extends CI_Controller{

    public function index(){
        $data['title'] = 'Absensi';

        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/Vabsensi', $data);
        $this->load->view('template/foot');
        
    }
    public function pageinput(){
        $data['title'] = 'Input Absensi';
    
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/VabsensiInput', $data);
        $this->load->view('template/foot');
        
    }

    public function addAbsensi(){
        $post = $this->input->post();
        foreach ($post['hadir'] as $data => $val) {            
            $simpan[] = array(
                'hadir' => $post['hadir'][$data],
                'sakit' => $post['sakit'][$data],
                'ijin' => $post['ijin'][$data],
                'alfa' => $post['alpa'][$data],
                'nik' => $post['nik'][$data],
                'bulan' => $post['bulan'][$data],
                'nama_pegawai' => $post['pegawai'][$data],
                'jenis_kelamin' => $post['jk'][$data],
                'jabatan' => $post['jb'][$data],
            );
        }
        if($this->GajiModel->insertBatch('data_kehadiran',$simpan)){
            echo json_encode(array('success'=>true));
        }else{
            echo json_encode(array('success'=>false));
        }
    }

    public function getDataAbsen(){
        $bln = $this->input->get('bulan');
        $thn = $this->input->get('tahun');
        $newData['data'] = array();
        $data = $this->GajiModel->cariData('bulan',$thn.$bln,'data_kehadiran')->result();
        // $data = $this->GajiModel->getData('data_kehadiran')->result();
        $no = 0;
        foreach ($data as $key ) {
            $no++;
            $fix = array($no,$key->nik,$key->nama_pegawai,$key->jabatan,$key->hadir,$key->sakit,$key->ijin,$key->alfa);
            array_push($newData['data'],$fix);
        }
        echo json_encode($newData);
    }

    public function getDataInputAbsen(){
        $bln = $this->input->get('bulan') == '' ? date('m') : $this->input->get('bulan');
        $blnText = $this->input->get('bulanText') == '' ? date('F') : $this->input->get('bulanText');
        $thn = $this->input->get('tahun') == '' ? date('Y') : $this->input->get('tahun');
        $gab = $thn.$bln; 
        $newData['data'] = array();
        $data = $this->db->query("SELECT * FROM data_pegawai k INNER join data_jabatan j on k.jabatan = j.id 
                WHERE not exists(select * from data_kehadiran kk where bulan ='$gab' and k.nik =kk.nik) AND DATE_FORMAT(k.tgl_masuk,'%Y%m') <= '$gab'")->result();
        // $data = $this->GajiModel->getData('data_kehadiran')->result();
        $no = 0;
        foreach ($data as $key ) {
            $no++;
            $fix = array($no.
            '<input name="bulan[]" type="hidden" value="'.$gab.'">
            <input name="nik[]" type="hidden" value="'.$key->nik.'">
            <input name="pegawai[]" type="hidden" value="'.$key->nama_pegawai.'">
            <input name="jk[]" type="hidden" value="'.$key->jenis_kelamin.'">
            <input name="jb[]" type="hidden" value="'.$key->jabatan.'">
            '
            ,$key->nik,$key->nama_pegawai,$key->nama);
            array_push($newData['data'],$fix);
        }
        $newData['bulan'] = $blnText;
        $newData['tahun'] = $thn;
        echo json_encode($newData);
    }
}
