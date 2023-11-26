<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php
switch($tp){

case 'periksa':

$Qdetail = $db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->getResult();

$Qket = $db->query("SELECT value AS keterangan FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id='13'"); $ket = $Qket->getResult();

$Qket1 = $db->query("SELECT value AS keterangan FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id='14'"); $ket1 = $Qket1->getResult();
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

        <form action="<?php echo site_url('process/skpd/periksa/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi Pertimbangan</h1>
            <p class="label">Nama (Individu atau Organisasi)</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Keterangan dari TU</p>
            <p><?php if(isset($ket[0]->keterangan)) echo $ket[0]->keterangan; else echo '-'; ?></p>
            <p class="label">Keterangan dari Walikota</p>
            <p><?php if(isset($ket1[0]->keterangan)) echo $ket1[0]->keterangan; else echo '-'; ?></p>
            <!-- <p class="label">Keterangan dari Tim Pertimbangan</p>
            <p>OK</p> -->
            <h2></h2>
            <div class="col-wrapper clearfix">
                <h3 style="color:#ec7404">Pemberian Rekomendasi Dana</h3>
                <div class="control-group">
                    <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="15">
                        Ya
                    </label>
                   <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="16">
                        Tidak
                    </label>
                </div>
                <div class="control-group">
                <h3 style="color:#ec7404">Besar Rekomendasi Dana</h3>
                    <div class="controls">
                        <input type="text" placeholder="Rp" name="besar">
                    </div>
                </div>
            </div>
            <ul class="category-list list-nostyle">
                <?php
                $Qlist = $db->query("SELECT id, name FROM checklist WHERE id BETWEEN 18 AND 24 ORDER BY id ASC");

                foreach($Qlist->getResult() as $list){
                    echo '<li>
                            <label class="checkbox">
                                <input type="checkbox" name="syarat[]" value="'.$list->id.'">
                                '.$list->name.'
                            </label>
                        <li>';
                }
                ?>
            </ul>
            <h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan"></textarea>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Disposisi ke Tim Pertimbangan" />
                <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
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

$Qket = $db->query("SELECT value AS keterangan FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id='13'"); $ket = $Qket->getResult();

$Qket1 = $db->query("SELECT value AS keterangan FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id='14'"); $ket1 = $Qket1->getResult();

$Qedit = $db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id IN (15,16)"); $edit = $Qedit->getResult();

$Qedit1 = $db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id IN (17,25)"); $edit1 = $Qedit1->getResult();

$Qedit2 = $db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id BETWEEN 18 AND 24");?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <!-- <h1 class="page-title page-title-border">Detail Pemeriksaan Proposal Hibah Bansos Masuk</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/skpd/edit/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi Pertimbangan</h1>
            <p class="label">Nama (Individu atau Organisasi)</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Keterangan dari TU</p>
            <p><?php if(isset($ket[0]->keterangan)) echo $ket[0]->keterangan; else echo '-'; ?></p>
            <p class="label">Keterangan dari Walikota</p>
            <p><?php if(isset($ket1[0]->keterangan)) echo $ket1[0]->keterangan; else echo '-'; ?></p>
            <!-- <p class="label">Keterangan dari Tim Pertimbangan</p>
            <p>OK</p> -->
            <h2></h2>
            <div class="col-wrapper clearfix">
                <h3 style="color:#ec7404">Pemberian Rekomendasi Dana</h3>
                <div class="control-group">
                    <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="15" <?php if($edit[0]->checklist_id==15) echo " checked"; ?>>
                        Ya
                    </label>
                   <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="16" <?php if($edit[0]->checklist_id==16) echo " checked"; ?>>
                        Tidak
                    </label>
                </div>
                <div class="control-group">
                <h3 style="color:#ec7404">Besar Rekomendasi Dana</h3>
                    <div class="controls">
                        <input type="text" placeholder="Rp" name="besar" value="<?php if(isset($edit1[0]->value)) echo $edit1[0]->value; ?>">
                    </div>
                </div>
            </div>
            <ul class="category-list list-nostyle">
                <?php
                $Qlist = $db->query("SELECT id, name FROM checklist WHERE id BETWEEN 18 AND 24 ORDER BY id ASC");

                foreach($Qlist->getResult() as $list){
                    echo '<li>
                            <label class="checkbox">
                                <input type="checkbox" name="syarat[]" value="'.$list->id.'"';
                                foreach($Qedit2->getResult() as $edit2) if($edit2->checklist_id==$list->id) echo ' checked';
                                echo '>'.$list->name.'
                            </label>
                        <li>';
                }
                ?>
            </ul>
            <h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan"><?php if(isset($edit1[1]->value)) echo $edit1[1]->value; ?></textarea>

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