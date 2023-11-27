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
            <p><a href="<?= base_url('organisasi');?>" target="_blank">Lihat data organisasi legal disini.</a></p>
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