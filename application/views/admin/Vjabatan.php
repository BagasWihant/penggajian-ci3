<!-- agar kalo nambah link ke dalam jabatan langsung tulis href apa -->
<base href="<?= base_url("admin/jabatan/") ?>">
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
        <button class="btn btn-danger btn" id="hapusData">
            <i class="fas fa-trash"></i>
            Hapus
        </button>
        <!-- Modal ADD -->
        <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formAdd" method="post">
                            <b>Jabatan </b><input class="form-control" type="text" name="jabatan" id="jabatan" placeholder="Jabatan">
                            <b>Uang Transport</b><input class="form-control" type="text" name="uang_trans" id="uang_trans" placeholder="Uang Transport" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">
                            <b>Uang Makan </b><input class="form-control" type="text" name="uang_makan" id="uang_makan" placeholder="Uang Makan" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">
                            <b>Gaji Pokok </b><input class="form-control" type="text" name="gaji" id="gaji" placeholder="Gaji Pokok" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id='simpanData'class="btn btn-primary"><i class="far fa-save"></i> Simpan </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <input type="hidden" id='idu'>
                            <b>Uang Transport</b><input class="form-control" type="text" name="uang_trans2" id="uang_trans2" placeholder="Uang Transport" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">
                            <b>Uang Makan </b><input class="form-control" type="text" name="uang_makan2" id="uang_makan2" placeholder="Uang Makan" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">
                            <b>Gaji Pokok </b><input class="form-control" type="text" name="gaji2" id="gaji2" placeholder="Gaji Pokok" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id='updateData' class="btn btn-primary"><i class="far fa-save"></i> Update </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <table class="table table-striped" id="dataJabatan" style="width: 100%;">
        <thead class="table-dark">
            <tr>
                <th></th>
                <th>Jabatan</th>
                <th>Uang Transport</th>
                <th>Uang Makan</th>
                <th>Gaji</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>

    </table>


</div>
<script>
    $(function() {
        var table = $('#dataJabatan').DataTable({
            columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    data: null,
                    defaultContent: ''
                },
                {
                    targets: -1,
                    data: null,
                    defaultContent: '<button id="btnEdit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>',
                },
                {
                    targets: [2],
                    render: function(data, type, row, meta) {
                        return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
                    }
                },
                {
                    targets: [3],
                    render: function(data, type, row, meta) {
                        return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
                    }
                },
                {
                    targets: [4],
                    render: function(data, type, row, meta) {
                        return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
                    }
                },
                {
                    targets: [5],
                    render: function(data, type, row, meta) {
                        return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
                    }
                },
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            ajax: './getAllData',

        })

        $('#dataJabatan tbody').on('click', 'button', function() {

            let data = table.row($(this).parents('tr')).data();

            let jabatan = data[1];
            let trans = data[2];
            let makan = data[3];
            let gaji = data[4];
            let id = data[0];
            $('#updateModal').modal('show');
            $('#uang_trans2').val(tandaPemisahTitik(trans));
            $('#uang_makan2').val(tandaPemisahTitik(makan));
            $('#gaji2').val(tandaPemisahTitik(gaji));
            $('#idu').val(id);
        });

        $('#simpanData').on("click", function(e) {
            e.preventDefault();
            var jabatanA = $('#jabatan').val();
            var uangTransA = $('#uang_trans').val();
            var uangMakanA = $('#uang_makan').val();
            var gajiA = $('#gaji').val();

            $('#formAdd').find("input,textarea,select").val('')
            $('#tambahModal').modal('hide')
            $.post('add', {
                jabatan: jabatanA,
                uang_trans: uangTransA,
                uang_makan: uangMakanA,
                gaji: gajiA
            }, function(res) {
                res = JSON.parse(res)
                if (res.success) {
                    table.ajax.reload(null, false);
                }
            });
        })

        $('#updateData').on("click", function(e) {
            e.preventDefault();
            var uang_trans2 = $('#uang_trans2').val();
            var uang_makan2 = $('#uang_makan2').val();
            var gaji2 = $('#gaji2').val();
            var id = $('#idu').val();

            $('#formUpdate').find("input,textarea,select").val('')
            $('#updateModal').modal('hide')
            $.post('updateDataJabatan', {
                uang_makan: uang_makan2,
                uang_trans: uang_trans2,
                gaji:gaji2,
                id: id,
            }, function(res) {
                res = JSON.parse(res)
                if (res.success) {
                    table.ajax.reload(null, false);
                }
            });
        })

        
        $('#hapusData').click(function() {
            let data = table.rows('.selected').data().toArray()
            let jml = data.length
            if (jml > 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Menghapus " + jml + " pegawai?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('deleteData', {
                            data: data
                        }, function(res) {
                            res = JSON.parse(res)
                            if (res.success) {
                                table.ajax.reload();
                            }
                        });
                    }
                })
            }
        });

    });

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