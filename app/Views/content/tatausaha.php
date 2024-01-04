<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<?php
switch($tp){

case 'periksa':
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <!-- <h1 class="page-title page-title-border">Detail Pemeriksaan Proposal Hibah Bansos Masuk</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/tatausaha/periksa/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Detail Pengecekan Dokumen</h1>
            <!-- Tautan untuk membuka modal -->
            <p><a href="#" id="lihatDataOrganisasi">Lihat data organisasi legal disini.</a></p>

            <!-- Modal -->
            <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h1 class="page-title">Organisasi Legal</h1>
                <div class="form-search-wrapper">
                <input type="text" id="pencarian" name="keyword" value="" placeholder="Cari Organisasi">

                </div>
                <table class="table-global">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telp</th>
                            <th>Status</th>
                            <?php if($_SESSION['sabilulungan']['role']== 10) { ?>
                                <th width="100">Aksi</th>
                            <?php } ?>
                        </tr>
                    </thead>
                        <tbody id="organisasiTableBody">
                            <!-- Data tabel akan diperbarui menggunakan AJAX -->
                        </tbody>
                </table>
  
                <a href="#" onclick="closeModal()">Tutup Modal</a>
            </div>
            </div>

            <script>
                function openModal() {
                    var modal = document.getElementById('myModal');
                    modal.style.display = 'block';
                    fetchData();
                }

                function closeModal() {
                    var modal = document.getElementById('myModal');
                    modal.style.display = 'none';
                }

                function fetchData() {
        var pencarianValue = document.getElementById('pencarian').value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);
                updateTable(data);
            }
        };
        xhr.open('POST', '<?= base_url('get_organisasi'); ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('keyword=' + encodeURIComponent(pencarianValue));
    }

                function updateTable(data) {
                    var tableBody = document.getElementById('organisasiTableBody');
                    tableBody.innerHTML = ''; // Kosongkan isi tbody

                    for (var i = 0; i < data.length; i++) {
                        var row = tableBody.insertRow(i);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);

                        cell1.innerHTML = i + 1;
                        cell2.innerHTML = data[i].name;
                        cell3.innerHTML = data[i].address;
                        cell4.innerHTML = data[i].phone;
                        cell5.innerHTML = '<a href="#" class="status" data-id="' + data[i].id + '">' + (data[i].legal == 1 ? 'Aktif' : 'Tidak Aktif') + '</a>';

                    // Menambah event listener ke elemen status
                    cell5.querySelector('.status').addEventListener('click', function (event) {
                        var statusElement = event.target;
                        var id = statusElement.getAttribute('data-id');
                        toggleStatus(id); // Memanggil fungsi untuk mengubah status
                    });
                            }
                }

                document.getElementById('lihatDataOrganisasi').addEventListener('click', function (event) {
                    event.preventDefault();
                    openModal();
                });
                document.getElementById('pencarian').addEventListener('input', function () {
        fetchData();
    });

    document.getElementById('pencarian').addEventListener('keypress', function (event) {
        // Jika tombol Enter ditekan, maka panggil fetchData()
        if (event.key === 'Enter') {
            fetchData();
        }
    });
    function toggleStatus(id) {
        // Simpan checkbox pertama dalam variabel
        var checkbox = document.querySelector('input[name="persyaratan[]"]');
        
        // Kirim permintaan AJAX atau lakukan tindakan lain yang diperlukan
        // Setelah berhasil, ubah properti checked dari checkbox pertama
        checkbox.checked = !checkbox.checked;

        // Anda dapat menutup modal atau melakukan tindakan lainnya yang sesuai
        closeModal();
    }
            </script>


            <ul class="category-list list-nostyle">
                <li>
                    <h3 style="color:#ec7404">Kategori</h3>
                </li>
                <li>
                    <select name="kategori">
                    <option value="0">-- Silahkan Pilih</option>
                    <?php
                    
                    $Qkategori = $db->table('proposal_type')->select("id, name")->orderBy('id', 'ASC')->get();

                    foreach($Qkategori->getResult() as $kategori){
                        echo '<option value="'.$kategori->id.'">'.$kategori->name.'</option>';
                    }
                    ?>
                    </select>
                </li>
                <?php
                $Qlist1 = $db->table('checklist')->select("id, name")->where('role_id', 5)->orderBy('sequence', 'ASC')->limit(4)->get();

                foreach($Qlist1->getResult() as $list1){
                    echo '<li>
                            <label class="checkbox">
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
                }
                ?>
            </ul>

            <h1 class="page-title page-title-border">Persyaratan Administrasi</h1>
            <ul class="category-list list-nostyle">
                <?php
                $Qlist2 = $db->table('checklist')->select("id, name")->where('role_id', 5)->orderBy('sequence', 'ASC')->limit(8,4)->get();

                foreach($Qlist2->getResult() as $list2){
                    echo '<li>
                            <label class="checkbox">
                                <input type="checkbox" name="persyaratan[]" value="'.$list2->id.'">
                                '.$list2->name.'
                            </label>
                        </li>';
                }
                ?>
            </ul>

            <p>Pengecualian poin 1, 3, 5, 6 untuk proposal yang berkaitan dengan tempat peribadatan, pondok pesantren dan kelompok swadaya masyarakat yang bersifat non-formal dan pengelolaannya berupa partisipasi swadaya masyarakat.</p>

            <h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan"></textarea>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Lanjut ke Pemeriksaan oleh Walikota" />
                <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" />
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'edit':

$Qedit = $db->query("SELECT type_id FROM proposal WHERE `id`='$dx'"); $edit = $Qedit->getResult();

$Qedit1 = $db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id BETWEEN 1 AND 13");
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <!-- <h1 class="page-title page-title-border">Detail Pemeriksaan Proposal Hibah Bansos Masuk</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/tatausaha/edit/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Detail Pengecekan Dokumen</h1>
            <ul class="category-list list-nostyle">
                <li>
                    <h3 style="color:#ec7404">Kategori</h3>
                </li>
                <li>
                    <select name="kategori">
                    <option value="0">-- Silahkan Pilih</option>
                    <?php
                    
                    $Qkategori = $db->table('proposal_type')->select("id, name")->orderBy('id', 'ASC')->get();

                    foreach($Qkategori->getResult() as $kategori){
                        echo '<option value="'.$kategori->id.'"'; if($kategori->id==$edit[0]->type_id) echo ' selected'; echo '>'.$kategori->name.'</option>';
                    }
                    ?>
                    </select>
                </li>
                <?php
                $Qlist1 = $db->table('checklist')->select("id, name")->where('role_id', 5)->orderBy('sequence', 'ASC')->limit(4)->get();

                foreach($Qlist1->getResult() as $list1){
                    echo '<li>
                            <label class="checkbox">
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'"';
                                foreach($Qedit1->getResult() as $edit1) if($edit1->checklist_id==$list1->id) echo ' checked';
                                echo '>'.$list1->name.'
                            </label>
                        </li>';                    
                }
                ?>
            </ul>

            <h1 class="page-title page-title-border">Persyaratan Administrasi</h1>
            <ul class="category-list list-nostyle">
                <?php
                $Qlist2 = $db->table('checklist')->select("id, name")->where('role_id', 5)->orderBy('sequence', 'ASC')->limit(8,4)->get();

                foreach($Qlist2->getResult() as $list2){
                    echo '<li>
                            <label class="checkbox">
                                <input type="checkbox" name="persyaratan[]" value="'.$list2->id.'"';
                                foreach($Qedit1->getResult() as $edit1) if($edit1->checklist_id==$list2->id) echo ' checked';
                                echo '>'.$list2->name.'
                            </label>
                        </li>';
                }
                ?>
            </ul>

            <!-- <p>Pengecualian poin 1, 3, 5, 6 untuk proposal yang berkaitan dengan tempat peribadatan, pondok pesantren dan kelompok swadaya masyarakat yang bersifat non-formal dan pengelolaannya berupa partisipasi swadaya masyarakat.</p> -->

            <h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan"><?php foreach($Qedit1->getResult() as $edit1) if($edit1->value != NULL) echo $edit1->value ?></textarea>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />
                <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

}
?>
<?= $this->endSection(); ?>