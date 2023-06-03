<!-- agar kalo nambah link ke dalam jabatan langsung tulis href apa -->
<base href="<?= base_url("admin/slipGaji/") ?>">
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" id="title"><?= $title; ?></h1>
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
                <?php for ($i = 2023; $i < date('Y') + 3; $i++) { ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>

                <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary mb-2" id="tampilData">Tampilkan</button>
        <button class="btn btn-primary mb-2 mx-2" id="print">Print</button>
    </div>

    <div id="tabelData">

    </div>

    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Tambah Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="wPrint">
                        <div>
                            <iframe width="100%" height="550px" id="myFrame"></iframe>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    $(function() {
        let requestData;

        $('#tampilData').on('click', function() {
            requestData = {
                "bulan": $('#bulan').val(),
                "tahun": $('#tahun').val()
            }
            console.log(requestData);
            $.post('./tabelLapGaji', requestData, function(res) {
                $('#tabelData').html(res)
            })
        })
        $('#print').on('click', function() {
            $.post('./printGaji', requestData,function(res){
                console.log(res.url)
                console.log(window.location.pathname)
                if(res.success){
                    $('#pdfModal').modal('show')

                    $('#myFrame').attr('src', '../..'+res.url+'.pdf');
                }
            })
        })
    })
</script>