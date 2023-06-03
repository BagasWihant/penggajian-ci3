<!-- agar kalo nambah link ke dalam jabatan langsung tulis href apa -->
<base href="<?= base_url("admin/absensi/") ?>">
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <p class="h3 mb-0 text-gray-800"><?= $title; ?> </p>
    </div>
    <a class="btn-sm btn-primary btn" href="./"><i class="fas fa-back"></i>Kembali</a>
    <div class="form-inline mt-2">
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
                <?php for ($i = 2023; $i < date('Y') + 3; $i++) { ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>

                <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary mb-2" id="tampilData">Tampilkan</button>
    </div>
    <div id="textIndikator">Bulan <span id="textBln"></span> Tahun <span id="textThn"></span></div>
    <form id="formAbsen">
        <button class="btn btn-success mb-2" id="simpanData" type="submit">Simpan</button>
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
        <form>

</div>
<script>
    $(function() {
        $('#textIndikator').hide()
        var requestData = {
            "bulan": $('#bulan').val(),
            "tahun": $('#tahun').val(),
            "bulanText": $('#bulan option:selected').text()
        }
        var tempData = '';
        var table = $('#dataAbsensi').DataTable({
            dom: 'tlp',
            ajax: {
                serverSide: true,
                url: './getDataInputAbsen',
                "data": function() {
                    return requestData;
                },
                "dataSrc": function(e) {
                    if (e.bulan !== 'Bulan') {
                        $('#textIndikator').show()
                        $('#textBln').html('')
                        $('#textThn').html('')
                        $('#textBln').html(e.bulan)
                        $('#textThn').html(e.tahun)
                    }
                    tempData = Object.assign({},e.data);
                    return e.data;
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: 4,
                    data: null,
                    defaultContent: '<input type="number" id="hadir[]" name="hadir[]" value="0" style="width:100%;">',
                },
                {
                    orderable: false,
                    targets: 5,
                    data: null,
                    defaultContent: '<input type="number" id="sakit[]" name="sakit[]" value="0" style="width:100%;">',
                },
                {
                    orderable: false,
                    targets: 6,
                    data: null,
                    defaultContent: '<input type="number" id="alpa[]" name="alpa[]" value="0" style="width:100%;">',
                }
            ],

        })

        $('#tampilData').on('click', function() {
            requestData = {
                "bulan": $('#bulan').val(),
                "tahun": $('#tahun').val(),
                "bulanText": $('#bulan option:selected').text()
            };
            table.ajax.url('./getDataInputAbsen').load()
        })

        $('#formAbsen').on('submit', function(e) {
            e.preventDefault()
            hadir = table.$('input').serializeArray();
            $.post('./addAbsensi', hadir, function(params) {
                params = JSON.parse(params)
                if(params.success){
                    table.ajax.reload();

                }
            })
        })
    })
</script>