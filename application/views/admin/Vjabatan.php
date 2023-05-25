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
        <!-- Modal -->
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
                        <form action="add" method="post">
                            <b>Jabatan </b><input class="form-control" type="text" name="jabatan" placeholder="Jabatan">
                            <b>Uang Transport</b><input class="form-control" type="text" name="uang_trans" placeholder="Uang Transport" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">
                            <b>Uang Makan </b><input class="form-control" type="text" name="uang_makan" placeholder="Uang Makan" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">
                            <b>Gaji Pokok </b><input class="form-control" type="text" name="gaji" placeholder="Gaji Pokok" onkeydown="return numbersonly(this,event);" onkeyup="javascript:tandaPemisahtitik(this)">
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


    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Jabatan</th>
                <th>Uang Transport</th>
                <th>Uang Makan</th>
                <th>Gaji</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <? foreach ($jabatan as $d) {
            echo '<tr><td>' . $d->nama;
            echo '</td><td>' . number_format($d->tunj_transport, 0, ',', '.');
            echo '</td><td>' . number_format($d->tunj_makan, 0, ',', '.');
            echo '</td><td>' . number_format($d->gaji, 0, ',', '.');
            echo '</td><td>' . number_format($d->tunj_transport + $d->tunj_makan + $d->gaji, 0, ',', '.') . '</td>';
            echo '<td>
            <button class="btn btn-danger btn-sm" onclick="deleteData(' . $d->id . ')"><i class="fas fa-trash-alt"></i></button>
            <button class="btn btn-info btn-sm"><i class="fas fa-edit"></i></button>
            </td></tr>';
        } ?>
    </table>


</div>
<script>
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