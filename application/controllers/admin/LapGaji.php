<?php

class LapGaji extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Laporan Gaji';

        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/VlapGaji', $data);
        $this->load->view('template/foot');
    }


    public function printGaji()
    {
        $res = '
        <table class="table table-striped" id="dataAbsensi" style="width: 100%;">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th width="9%">Hadir</th>
                    <th width="9%">Sakit</th>
                    <th width="9%">Alpa</th>
                </tr>
            </thead>

        <tbody>';
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');
        $newData = array();
        $data = $this->GajiModel->cariData('bulan', $thn . $bln, 'data_kehadiran')->result();
        // $data = $this->GajiModel->getData('data_kehadiran')->result();
        $no = 0;
        foreach ($data as $key) {
            $no++;
            $fix = array($no, $key->nik, $key->nama_pegawai, $key->jabatan, $key->hadir, $key->sakit, $key->alfa);
            array_push($newData, $fix);
            $res .= "<tr>
            <td>$no</td>
            <td>$key->nik</td>
            <td>$key->nama_pegawai</td>
            <td>$key->jabatan</td>
            <td width='9%'>$key->hadir</td>
            <td width='9%'>$key->sakit</td>
            <td width='9%'>$key->alfa</td>
        </tr>";
        }
        $res .= "</tbody></table>";
        $data['isi'] = $res;
        
        $path = FCPATH;
        $filename= "/tmp/mpdf/".strtotime(date('YmdHis'));
        $output = $path.$filename.".pdf";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        foreach (glob(FCPATH."tmp/mpdf/*.*") as $file) {
            unlink($file);
        }
        $print = $this->load->view('admin/PrintlapGaji', $data, TRUE);
        $mpdf = new \Mpdf\Mpdf(['tempDir' => $path]);

        $mpdf->WriteHTML($print);
        $mpdf->Output($output);
        
		$response = array('success' => true, 'url' => "$filename");
		header('Content-type: application/json');
		echo json_encode($response);

    }

    public function tabelLapGaji()
    {
        $res = '
        <table class="table table-striped" id="dataAbsensi" style="width: 100%;">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th width="9%">Hadir</th>
                    <th width="9%">Sakit</th>
                    <th width="9%">Alpa</th>
                </tr>
            </thead>

        <tbody>';
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');
        $newData = array();
        $data = $this->GajiModel->cariData('bulan', $thn . $bln, 'data_kehadiran')->result();
        // $data = $this->GajiModel->getData('data_kehadiran')->result();
        $no = 0;
        foreach ($data as $key) {
            $no++;
            $fix = array($no, $key->nik, $key->nama_pegawai, $key->jabatan, $key->hadir, $key->sakit, $key->alfa);
            array_push($newData, $fix);
            $res .= "<tr>
            <td>$no</td>
            <td>$key->nik</td>
            <td>$key->nama_pegawai</td>
            <td>$key->jabatan</td>
            <td width='9%'>$key->hadir</td>
            <td width='9%'>$key->sakit</td>
            <td width='9%'>$key->alfa</td>
        </tr>";
        }
        $res .= "</tbody></table>";
        echo $res;
    }
}
