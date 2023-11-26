
<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<?php
switch($tp){

case 'periksa':

$Qdetail = $db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->getResult();

$Qket = $db->query("SELECT value AS keterangan FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id=13"); $ket = $Qket->getResult();
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

        <form action="<?php echo site_url('process/pertimbangan/periksa/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi TU</h1>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Keterangan dari TU</p>
            <p><?php if(isset($ket[0]->keterangan)) echo $ket[0]->keterangan; else echo '-'; ?></p>
            <h2></h2>
            <div class="col-wrapper clearfix">
                <h3 style="color:#ec7404">Kategori Hibah Bansos</h3>
                <ul class="category-list col list-nostyle">
                    <?php
                    $Qskpd = $db->query("SELECT * FROM skpd ORDER BY id ASC LIMIT 11");

                    foreach($Qskpd->getResult() as $skpd){
                        echo '<li>
                                <label class="radio">
                                    <input type="radio" name="skpd" value="'.$skpd->id.'">
                                    '.$skpd->name.'
                                </label>
                            </li>';
                    }
                    ?>
                </ul>
                <ul class="category-list col list-nostyle">
                    <?php
                    $Qskpd = $db->query("SELECT * FROM skpd ORDER BY id ASC LIMIT 11,11");

                    foreach($Qskpd->getResult() as $skpd){
                        echo '<li>
                                <label class="radio">
                                    <input type="radio" name="skpd" value="'.$skpd->id.'">
                                    '.$skpd->name.'
                                </label>
                            </li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Disposisi ke SKPD" />
                <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'verifikasi':

$Qdetail = $db->query("SELECT a.name, a.judul, a.latar_belakang, a.type_id, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->getResult();

$Qcheck = $db->query("SELECT value FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id IN (17,26,27)"); 
$check = $Qcheck->getResult();
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

        <form action="<?php echo site_url('process/pertimbangan/verifikasi/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Berdasarkan Pertimbangan SKPD</h1>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Nominal dari SKPD</p>
            <p><?php if(isset($check[0]->value)) echo 'Rp. '.number_format($check[0]->value,0,",",".").',-'; else echo '-'; ?></p>
            <h2></h2>
            <div class="col-wrapper clearfix">
                <h3 style="color:#ec7404">Formulir Verifikasi</h3>
                <div class="control-group">
                    <label class="control-label" for="">Koreksi (Angka)</label>
                    <div class="controls">
                        <input type="text" name="koreksi" <?php if(isset($check[1]->value)) echo ' value="'.$check[1]->value.'" disabled'; ?>>
                    </div>
                </div>            
                <div class="control-group">
                    <label class="control-label" for="">Keterangan</label>
                    <div class="controls">
                        <textarea rows="5" name="keterangan" <?php if(isset($check[2]->value)) echo 'disabled'; ?>><?php if(isset($check[2]->value)) echo $check[2]->value; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input <?php if(isset($check[1]->value)) echo ' disabled'; ?> type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Verifikasi" />

                <?php
                //str_replace("'", "", $detail[0]->judul)
                $view = base_url('pdf/view/'.date('d M Y').' - '.rawurlencode($detail[0]->judul).'/'.$detail[0]->type_id.'/'.$dx);
                $export = base_url('pdf/export/'.date('d M Y').' - '.rawurlencode($detail[0]->judul).'/'.$detail[0]->type_id.'/'.$dx);                
                ?>

                <a target="_blank" <?php if(isset($check[1]->value)) echo ' href="'.$view.'"'; else echo ' onclick="alert(\'Silahkan Verifikasi Formulir Terlebih Dahulu.\');"'; ?> class="btn-orange btn-plain btn" style="display:inline">Preview Formulir</a>
                <a target="_blank" <?php if(isset($check[1]->value)) echo ' href="'.$export.'"'; else echo ' onclick="alert(\'Silahkan Verifikasi Formulir Terlebih Dahulu.\');"'; ?> class="btn-orange btn-plain btn" style="display:inline">Cetak Formulir</a>
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'edit':

$Qdetail = $db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->getResult();

$Qket = $db->query("SELECT value AS keterangan FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id=13"); $ket = $Qket->getResult();

$Qedit = $db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='31'"); $edit = $Qedit->getResult();
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

        <form action="<?php echo site_url('process/pertimbangan/edit/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi TU</h1>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Keterangan dari TU</p>
            <p><?php if(isset($ket[0]->keterangan)) echo $ket[0]->keterangan; else echo '-'; ?></p>
            <h2></h2>
            <div class="col-wrapper clearfix">
                <h3 style="color:#ec7404">Kategori Hibah Bansos</h3>
                <ul class="category-list col list-nostyle">
                    <?php
                    $Qskpd = $db->query("SELECT * FROM skpd ORDER BY id ASC LIMIT 11");

                    foreach($Qskpd->getResult() as $skpd){
                        echo '<li>
                                <label class="radio">
                                    <input type="radio" name="skpd" value="'.$skpd->id.'"'; if($edit[0]->value==$skpd->id) echo ' checked';
                                    echo '>'.$skpd->name.'
                                </label>
                            </li>';
                    }
                    ?>
                </ul>
                <ul class="category-list col list-nostyle">
                    <?php
                    $Qskpd = $db->query("SELECT * FROM skpd ORDER BY id ASC LIMIT 11,11");

                    foreach($Qskpd->getResult() as $skpd){
                        echo '<li>
                                <label class="radio">
                                    <input type="radio" name="skpd" value="'.$skpd->id.'"'; if($edit[0]->value==$skpd->id) echo ' checked';
                                    echo '>'.$skpd->name.'
                                </label>
                            </li>';
                    }
                    ?>
                </ul>
            </div>

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

case 'view':

$Qdetail = $db->query("SELECT a.name, a.judul, a.latar_belakang, a.type_id, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->getResult();

$Qcheck = $db->query("SELECT value FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id IN (17,26,27)"); 
$check = $Qcheck->getResult();
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

        <form action="<?php echo site_url('process/pertimbangan/view/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Berdasarkan Pertimbangan SKPD</h1>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Nominal dari SKPD</p>
            <p><?php if(isset($check[0]->value)) echo 'Rp. '.number_format($check[0]->value,0,",",".").',-'; else echo '-'; ?></p>
            <h2></h2>
            <div class="col-wrapper clearfix">
                <h3 style="color:#ec7404">Formulir Verifikasi</h3>
                <div class="control-group">
                    <label class="control-label" for="">Koreksi (Angka)</label>
                    <div class="controls">
                        <input type="text" name="koreksi" <?php if(isset($check[1]->value)) echo ' value="'.$check[1]->value.'"'; ?>>
                    </div>
                </div>            
                <div class="control-group">
                    <label class="control-label" for="">Keterangan</label>
                    <div class="controls">
                        <textarea rows="5" name="keterangan"><?php if(isset($check[2]->value)) echo $check[2]->value; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />

                <?php
                //str_replace("'", "", $detail[0]->judul)
                $view = base_url('process/pdf/view/'.date('d M Y').' - '.rawurlencode($detail[0]->judul).'/'.$detail[0]->type_id.'/'.$dx);
                $export = base_url('process/pdf/export/'.date('d M Y').' - '.rawurlencode($detail[0]->judul).'/'.$detail[0]->type_id.'/'.$dx);                
                ?>

                <!-- <a target="_blank" <?php if(isset($check[1]->value)) echo ' href="'.$view.'"'; else echo ' onclick="alert(\'Silahkan Verifikasi Formulir Terlebih Dahulu.\');"'; ?> class="btn-orange btn-plain btn" style="display:inline">Preview Formulir</a>
                <a target="_blank" <?php if(isset($check[1]->value)) echo ' href="'.$export.'"'; else echo ' onclick="alert(\'Silahkan Verifikasi Formulir Terlebih Dahulu.\');"'; ?> class="btn-orange btn-plain btn" style="display:inline">Cetak Formulir</a> -->
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