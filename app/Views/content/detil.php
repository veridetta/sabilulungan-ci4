<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<?php
switch($tp){

case 'proposal':

$Qdetail = $db->query("SELECT a.name, a.address, a.judul, a.latar_belakang, a.maksud_tujuan, a.time_entry, SUM(b.amount) AS mohon FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); 
$detail = $Qdetail->getResult();

$Qtime = $db->query("SELECT time_entry FROM proposal_approval WHERE proposal_id='$dx' AND flow_id BETWEEN 1 AND 7"); 
$time = $Qtime->getResult();
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
            <h1 class="page-title page-title-border">Detail Proposal Hibah Bansos</h1>
            <!-- <p class="label">Nama (Individu atau Organisasi)</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Alamat</p>
            <p><?php echo $detail[0]->address ?></p>
            <p class="label">Judul Kegiatan</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Latar Belakang</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Maksud dan Tujuan</p>
            <p><?php echo $detail[0]->maksud_tujuan ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->mohon,0,",",".").',-' ?></p> -->
            <p class="label">Tanggal Proposal Masuk</p>
            <p><?php echo date('M d, Y', strtotime($detail[0]->time_entry)) ?></p>
            <p class="label">Tanggal Pemeriksaan TU</p>
            <p><?php if(isset($time[0]->time_entry)) echo date('M d, Y', strtotime($time[0]->time_entry)); else echo '-'; ?></p>
            <p class="label">Tanggal Pemeriksaan Walikota</p>
            <p><?php if(isset($time[1]->time_entry)) echo date('M d, Y', strtotime($time[1]->time_entry)); else echo '-'; ?></p>
            <p class="label">Tanggal Pemeriksaan Tim Pertimbangan</p>
            <p><?php if(isset($time[2]->time_entry)) echo date('M d, Y', strtotime($time[2]->time_entry)); else echo '-'; ?></p>
            <p class="label">Tanggal Pemeriksaan SKPD</p>
            <p><?php if(isset($time[3]->time_entry)) echo date('M d, Y', strtotime($time[3]->time_entry)); else echo '-'; ?></p>
            <p class="label">Tanggal Verifikasi Tim Pertimbangan</p>
            <p><?php if(isset($time[4]->time_entry)) echo date('M d, Y', strtotime($time[4]->time_entry)); else echo '-'; ?></p>
            <p class="label">Tanggal Pemeriksaan TAPD</p>
            <p><?php if(isset($time[5]->time_entry)) echo date('M d, Y', strtotime($time[5]->time_entry)); else echo '-'; ?></p>
            <p class="label">Tanggal Penyetujuan Walikota</p>
            <p><?php if(isset($time[6]->time_entry)) echo date('M d, Y', strtotime($time[6]->time_entry)); else echo '-'; ?></p>

            <div class="control-actions">
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'edit':

$Qdetail = $db->query("SELECT a.name, a.address, a.judul, a.latar_belakang, a.maksud_tujuan, a.time_entry, SUM(b.amount) AS mohon FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); 
$detail = $Qdetail->getResult();

$Qtime = $db->query("SELECT time_entry FROM proposal_approval WHERE proposal_id='$dx' AND flow_id BETWEEN 1 AND 7"); 
$time = $Qtime->getResult();
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

        <form action="<?php echo site_url('process/admin/detail/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Detail Proposal Hibah Bansos</h1>
            <p class="label">Tanggal Proposal Masuk</p>
            <p><input id="datepicker-tgl" type="text" name="tanggal" value="<?php if(isset($detail[0]->time_entry)) echo date('Y-m-d', strtotime($detail[0]->time_entry)); ?>"></p>
            <p class="label">Tanggal Pemeriksaan TU</p>
            <p><input id="datepicker-tgl1" type="text" name="tanggal1" value="<?php if(isset($time[0]->time_entry)) echo date('Y-m-d', strtotime($time[0]->time_entry)); ?>"></p>
            <p class="label">Tanggal Pemeriksaan Walikota</p>
            <p><input id="datepicker-tgl2" type="text" name="tanggal2" value="<?php if(isset($time[1]->time_entry)) echo date('Y-m-d', strtotime($time[1]->time_entry)); ?>"></p>
            <p class="label">Tanggal Pemeriksaan Tim Pertimbangan</p>
            <p><input id="datepicker-tgl3" type="text" name="tanggal3" value="<?php if(isset($time[2]->time_entry)) echo date('Y-m-d', strtotime($time[2]->time_entry)); ?>"></p>
            <p class="label">Tanggal Pemeriksaan SKPD</p>
            <p><input id="datepicker-tgl4" type="text" name="tanggal4" value="<?php if(isset($time[3]->time_entry)) echo date('Y-m-d', strtotime($time[3]->time_entry)); ?>"></p>
            <p class="label">Tanggal Verifikasi Tim Pertimbangan</p>
            <p><input id="datepicker-tgl5" type="text" name="tanggal5" value="<?php if(isset($time[4]->time_entry)) echo date('Y-m-d', strtotime($time[4]->time_entry)); ?>"></p>
            <p class="label">Tanggal Pemeriksaan TAPD</p>
            <p><input id="datepicker-tgl6" type="text" name="tanggal6" value="<?php if(isset($time[5]->time_entry)) echo date('Y-m-d', strtotime($time[5]->time_entry)); ?>"></p>
            <p class="label">Tanggal Penyetujuan Walikota</p>
            <p><input id="datepicker-tgl7" type="text" name="tanggal7" value="<?php if(isset($time[6]->time_entry)) echo date('Y-m-d', strtotime($time[6]->time_entry)); ?>"></p>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />
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