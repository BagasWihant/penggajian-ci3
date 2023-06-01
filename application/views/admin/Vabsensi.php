<!-- agar kalo nambah link ke dalam jabatan langsung tulis href apa -->
<base href="<?= base_url("admin/absensi/") ?>">
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <div class="form-inline">
        <div class="form-group mb-2 mr-2">
            <select name="bulan" id="bulan" class="form-control">
                <option value="">Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
        <div class="form-group mb-2 mr-2">
            <select name="tahun" id="tahun" class="form-control">
                <option value="">Tahun</option>
                <?php for($i = 2023;$i < date('Y')+3; $i++) {?>
                <option value="<?=$i;?>"><?= $i; ?></option>

                <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary mb-2" id="tampilData">Tampilkan</button>
        <div class="ml-auto">
            <button class="btn btn-success">Import Excel</button>
            <a class="btn btn-warning" href="./pageinput">Input Absen</a>
        </div>
    </div>


    <table class="table table-striped" id="dataAbsensi" style="width: 100%;">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th width='9%'>Hadir</th>
                <th width='9%'>Sakit</th>
                <th width='9%'>Alpa</th>
            </tr>
        </thead>

    </table>


</div>
<script>
    $(function () {

        var requestData = {"bulan":$('#bulan').val(), "tahun":$('#tahun').val()}
        var table = $('#dataAbsensi').DataTable({
            ajax:{
                url: './getDataAbsen',
                "data": function(){
                    return requestData;
                }
            } 
            
        })

        $('#tampilData').on('click',function(){
            requestData = {"bulan":$('#bulan').val(), "tahun":$('#tahun').val()};
            table.ajax.url('./getDataAbsen').load()
        })
    })
</script>