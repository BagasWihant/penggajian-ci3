<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Jabatan</th>
                <th>Tgl Masuk</th>
            </tr>
        </thead>
        
        <? foreach ($pegawai as $d) {
            echo '<tr><td>'.$d->nik;
            echo '</td><td>'.$d->nama_pegawai;
            echo '</td><td>'.$d->jenis_kelamin;
            echo '</td><td>'.$d->jabatan;
            echo '</td><td>'.$d->tgl_masuk.'</td></tr>';
        }?>
    </table>


</div>
<!-- /.container-fluid -->