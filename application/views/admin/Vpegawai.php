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
        <button class="btn btn-danger btn" id="hapusData">
            <i class="fas fa-trash"></i>
            Hapus
        </button>
        <!-- Modal ADD -->
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
                        <form action="" method="post" id="formAdd">
                            <b>Nama Pegawai</b><input class="form-control" type="text" id="nama" name="nama" placeholder="Nama Pegawai">
                            <b>Jenis Kelamin</b><select class="form-control" name="jk" id="jk" placeholder="Jenis Kelamin">
                                <option value="">Jenis Kelamin</option>
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                            <b>Jabatan </b><select class="form-control" id="jabatan" name="jabatan">
                                <option value="">Jabatan</option>

                            </select>
                            <b>Tanggal Masuk</b><input class="form-control" type="date" id="tgl" id='tgl_masuk' placeholder="Tanggal Masuk" onclick="opendate();">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id='simpanData' class="btn btn-primary"><i class="far fa-save"></i> Simpan </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="formUpdate">
                            <b>Nama Pegawai</b><input class="form-control" type="text" id="nama2" name="nama2" placeholder="Nama Pegawai">
                            <input  type="hidden" id="idj">
                            
                            <b>Jabatan </b><select class="form-control" id="jabatan2" name="jabatan2"">
                                <option value="">Jabatan</option>

                            </select>
                   </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id='updateData' class="btn btn-success"><i class="far fa-save"></i> Update </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <table class="table table-striped" id="tabelPegawai" style="width: 100%;">
        <thead class="table-dark">
            <tr>
                <th></th>
                <th>NIK</th>
                <th>Nama Pegawai</th>
                <th>Jenis Kelamin</th>
                <th>Jabatan</th>
                <th>Tgl. Masuk</th>
                <th>aksi</th>
            </tr>
        </thead>

    </table>


</div>
<script>
    $(function() {
        loadJabatan('jabatan2')

        var table = $('#tabelPegawai').DataTable({
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
            }],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            ajax: './getAllData',
        })

        $('#simpanData').on("click", function(e) {
            e.preventDefault();
            var namaAdd = $('#nama').val();
            var jkAdd = $('#jk').val();
            var jabatanAdd = $('#jabatan').val();
            var tglAdd = $('#tgl').val();

            $('#formAdd').find("input,textarea,select").val('')
            $('#tambahModal').modal('hide')
            $.post('add', {
                nama: namaAdd,
                jk: jkAdd,
                jabatan: jabatanAdd,
                tgl: tglAdd
            }, function(res) {
                res = JSON.parse(res)
                if (res.success) {
                    table.ajax.reload(null, false);
                }
            });
        })

        $('#updateData').on("click", function(e) {
            e.preventDefault();
            var namaUp = $('#nama2').val();
            var id = $('#idj').val();
            var jabatanUp = $('#jabatan2').val();

            $('#formUpdate').find("input,textarea,select").val('')
            $('#updateModal').modal('hide')
            $.post('update', {
                nama: namaUp,
                jabatan: jabatanUp,
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

        $('#tabelPegawai tbody').on('click', 'button', function()  {

            let data = table.row($(this).parents('tr')).data();
            $('#updateModal').modal('show')
            let nama = data[2];
            let jabatan = data[6];
            console.log(jabatan);
            let id = data[0];
            $('#nama2').val(nama);
            $('#jabatan2').val(jabatan);
            $('#idj').val(id);
        });
        
       
    });


    function loadJabatan(id) {
        if ($('#'+id).find("option").length >=0) {
            $('#'+id).empty().append('<option>Jabatan</option>')
            $.ajax({
                url: '../jabatan/getAllDataFull',
                dataType: 'json',
                type: 'post',
                success: function(res) {
                    data = res.data
                    if (data != '') {
                        for (i in data) {
                            $('#'+id).append('<option value="' + data[i].id + '">' + data[i].nama + '</option>');
                            $('#jabatan').append('<option value="' + data[i].id + '">' + data[i].nama + '</option>');
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