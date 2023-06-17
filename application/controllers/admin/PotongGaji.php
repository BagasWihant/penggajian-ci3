<?php

class PotongGaji extends CI_Controller{
	public function index(){
		$data['title'] = 'Potong Gaji';

        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/VpotongGaji', $data);
        $this->load->view('template/foot');
	}
	public function getAllData()
    {
        
        $newData['data'] = array();
        $data = $this->GajiModel->getData('potong_gaji')->result();
        foreach ($data as $key) {
            if($key->jenis == '1') $jenis = 'Sakit';
			elseif($key->jenis == '2') $jenis = 'Ijin';
			else $jenis = "Alfa";
			$fix = array($key->id, $jenis, $key->nominal,$key->jenis);

            array_push($newData['data'], $fix);
        }
        echo json_encode($newData);
    }

	public function add(){
		$jenis = $this->input->post('jenis');
		$nominal = $this->input->post('nominal');
		// cek
		$d = $this->GajiModel->cariData('jenis',$jenis,'potong_gaji')->result();
		if(!$d){
			$data = array(
				'nominal' => str_replace('.','',$nominal),
				'jenis' => $jenis,
			);
			
			$this->GajiModel->insertData('potong_gaji', $data);
			echo json_encode(array('pesan'=> 'Data berhasil ditambahkan','success'=>true));
		}else{
			echo json_encode(array('pesan'=> 'Data Sudah Ada','success'=>false));
		}
	}
	
	public function deleteData()
    {
        $data = $this->input->post('data');
        if (count($data) > 0) {
            foreach ($data as $value) {
                $id = $value[0];
                $where = array('id' => $id);
                $this->GajiModel->deleteData('potong_gaji', $where);

            }
            echo json_encode(array('pesan'=> 'Data berhasil dihapus','success'=>true));
        }
    }
	public function updatedata(){
        $nominal = $this->input->post('nominal');
        $id = $this->input->post('id');
        
        $data = array(
            'nominal' => str_replace('.','',$nominal),
        );
        $where = array(
            'id' => $id
        );

        $this->GajiModel->updateData('potong_gaji',$data,$where);
           echo json_encode(array('success'=>true,'pesan'=>'Berhasil diupdate'));

	}
}
