<!-- agar kalo nambah link ke dalam jabatan langsung tulis href apa -->
<base href="<?= base_url("admin/pegawai/") ?>">
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <div class="mb-3">
        <button class="btn btn-success btn" data-toggle="modal" data-target="#tambahModal" data-backdrop="static" data-keyboard="false">
            <i class="fas fa-plus-circle"></i>
            Tambah
        </button>
        <!-- Modal -->
        <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="add" method="post">
                            <b>Nama Pegawai</b><input class="form-control" type="text" name="nama" placeholder="Nama Pegawai">
                            <b>Jenis Kelamin</b><select class="form-control" name="jk" placeholder="Jenis Kelamin">
                                <option value="">Jenis Kelamin</option>
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                            <b>Jabatan </b><select class="form-control" id="jabatan" name="jabatan" onclick="loadJabatan();">
                                <option value="">Jabatan</option>
                                
                                </select>
                            <b>Tanggal Masuk</b><input class="form-control" type="date" name="tgl" id='tgl_masuk' placeholder="Tanggal Masuk" onclick="opendate();">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <table class="table table-striped" id="tabelPegawai" style="width: 100%;">
        <thead class="table-dark">
            <tr>
                <th>NIK</th>
                <th>Nama Pegawai</th>
                <th>Jenis Kelamin</th>
                <th>Jabatan</th>
                <th>Tgl. Masuk</th>
            </tr>
        </thead>

    </table>


</div>
<script>
    $(function() {
        $('#tabelPegawai').DataTable({
            ajax: './getAllData',
            columns: [{
                    data: 'nik'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'jk'
                },
                {
                    data: 'jab'
                },
                {
                    data: 'tgl_masuk'
                }
            ]
        })
        var table = $('#dataJabatan').DataTable();
        $('#dataJabatan tbody').on('click', 'tr', (event) => {
            console.log(table.row(event.currentTarget).data());
            let jabatan = table.row(event.currentTarget).data().nama;
            let trans = table.row(event.currentTarget).data().tunj_transport;
            let makan = table.row(event.currentTarget).data().tunj_makan;
            let gaji = table.row(event.currentTarget).data().gaji;
            Swal.fire({
                title: 'Edit data ' + jabatan,
                confirmButtonText: 'Update',
                html: '<div style="text-align: left !important;">Uang Transport<input class="form-control" type="text" name="uang_transSwal" id="uang_transSwal" placeholder="Uang Transport" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)"> ' +
                    'Uang Makan <input class="form-control" type="text" name="uang_makanSwal" id="uang_makanSwal" placeholder="Uang Makan" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">' +
                    'Gaji Pokok<input class="form-control" type="text" name="gajiSwal" id="gajiSwal" placeholder="Gaji Pokok" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)"> </div>',
                focusConfirm: false,
                preConfirm: () => {
                    let transVal = document.getElementById('uang_transSwal').value
                    let makanVal = document.getElementById('uang_makanSwal').value
                    let gajiVal = document.getElementById('uang_makanSwal').value
                    return {
                        transVal: transVal,
                        makanVal: makanVal,
                        gajiVal: gajiVal
                    }
                }
            }).then((result) => {
                $.ajax({
                        method: "POST",
                        url: "./updateDataJabatan",
                        data: {
                            uang_trans: result.value.transVal,
                            uang_makan: result.value.makanVal,
                            gaji: result.value.gajiVal,
                            transOld: trans,
                            makanOld: makan,
                            gajiOld: gaji,
                            jabatanOld: jabatan
                        }
                    })
                    .done(function(msg) {
                        msg = JSON.parse(msg)
                        if (msg.success) {
                            Swal.fire(
                                'Berhasil',
                                'Data berhasil Diupdate',
                                'success'
                            )
                        }
                    });
            })
            $('#uang_transSwal').val(trans);
            $('#uang_makanSwal').val(makan);
            $('#gajiSwal').val(gaji);
        });
    });

    function opendate(){
        $('#tgl_masuk').datepicker('show');
    }
    function loadJabatan(){
        if($('#jabatan').find("option").length == 1) {
            $('#jabatan').empty().append('<option>Jabatan</option>')
            $.ajax({
                url:'../jabatan/getAllDataFull',
                dataType: 'json',
                type: 'post',
                success:function(res){
                    data = res.data
                    if(data != ''){
                        for(i in data){
                            $('#jabatan').append('<option value="'+data[i].id+'">'+data[i].nama+'</option>');
                        }
                    }
                }
            })
        }
    }

    function tandaPemisahTitik(b) {
        var _minus = false;
        if (b < 0) _minus = true;
        b = b.toString();
        b = b.replace(".", "");
        b = b.replace("-", "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "." + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        if (_minus) c = "-" + c;
        return c;
    }

    function numbersonly(ini, e) {
        if (e.keyCode >= 49) {
            if (e.keyCode <= 57) {
                a = ini.value.toString().replace(".", "");
                b = a.replace(/[^\d]/g, "");
                b = (b == "0") ? String.fromCharCode(e.keyCode) : b + String.fromCharCode(e.keyCode);
                ini.value = tandaPemisahTitik(b);
                return false;
            } else if (e.keyCode <= 105) {
                if (e.keyCode >= 96) {
                    //e.keycode = e.keycode - 47;
                    a = ini.value.toString().replace(".", "");
                    b = a.replace(/[^\d]/g, "");
                    b = (b == "0") ? String.fromCharCode(e.keyCode - 48) : b + String.fromCharCode(e.keyCode - 48);
                    ini.value = tandaPemisahTitik(b);
                    //alert(e.keycode);
                    return false;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else if (e.keyCode == 48) {
            a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode);
            b = a.replace(/[^\d]/g, "");
            if (parseFloat(b) != 0) {
                ini.value = tandaPemisahTitik(b);
                return false;
            } else {
                return false;
            }
        } else if (e.keyCode == 95) {
            a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode - 48);
            b = a.replace(/[^\d]/g, "");
            if (parseFloat(b) != 0) {
                ini.value = tandaPemisahTitik(b);
                return false;
            } else {
                return false;
            }
        } else if (e.keyCode == 8 || e.keycode == 46) {
            a = ini.value.replace(".", "");
            b = a.replace(/[^\d]/g, "");
            b = b.substr(0, b.length - 1);
            if (tandaPemisahTitik(b) != "") {
                ini.value = tandaPemisahTitik(b);
            } else {
                ini.value = "";
            }

            return false;
        } else if (e.keyCode == 9) {
            return true;
        } else if (e.keyCode == 17) {
            return true;
        } else {
            //alert (e.keyCode);
            return false;
        }

    }

    function deleteData(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Menghapus Jabatan ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })
    }
</script>
<!-- /.container-fluid -->