<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<?php

switch($tp){

case 'edit':

$Qedit = $db->query("SELECT time_entry, name, address, judul, latar_belakang, maksud_tujuan, file FROM proposal WHERE id='$dx'"); $edit = $Qedit->getResult();
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">
        <h1 class="page-title page-title-border">Koreksi Hibah Bansos</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?> 
        <form class="form-global" method="post" action="<?php echo site_url('process/hibah/edit/'.$dx) ?>" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Tanggal Kegiatan</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" value="<?php echo date('Y-m-d', strtotime($edit[0]->time_entry)) ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nama (individu atau organisasi)</label>
                    <div class="controls">
                        <input type="text" name="name" value="<?php echo $edit[0]->name ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Alamat</label>
                    <div class="controls">
                        <textarea name="address" required><?php echo $edit[0]->address ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Judul Kegiatan</label>
                    <div class="controls">
                        <input type="text" name="judul" value="<?php echo $edit[0]->judul ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Latar Belakang</label>
                    <div class="controls">
                        <textarea name="latar" required><?php echo $edit[0]->latar_belakang ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Maksud dan Tujuan</label>
                    <div class="controls">
                        <textarea name="maksud" required><?php echo $edit[0]->maksud_tujuan ?></textarea>
                    </div>
                </div>
                <!-- <div class="control-group">
                    <label class="control-label" for="">Deskripsi Kegiatan</label>
                    <div class="controls">
                        <textarea name="kegiatan" required></textarea>
                    </div>
                </div> -->
                <div class="control-group">
                    <label class="control-label" for="">Proposal</label>
                    <div class="controls file">
                        <input type="file" name="proposal" accept="application/pdf">
                        <a class="info" target="_blank" href="<?php echo base_url('media/proposal/'.$edit[0]->file) ?>">Lihat Proposal</a>
                        <input type="hidden" name="old_proposal" value="<?php echo $edit[0]->file ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Dana</label>
                    <?php                    
                    $Qdana = $db->query("SELECT sequence, description, amount FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

                    foreach($Qdana->getResult() as $dana){
                        echo '<div class="controls file">
                                <label class="control-label" style="font-weight:normal"><input type="checkbox" name="del_dana[]" value="'.$dana->sequence.'"> Hapus</label>
                                <input type="text" name="deskripsi[]" value="'.$dana->description.'" placeholder="Deskripsi">
                                <input type="number" name="jumlah[]" value="'.$dana->amount.'" placeholder="Jumlah">
                                <input type="hidden" name="dana[]" value="'.$dana->amount.'">
                            </div>';
                    }
                    ?>
                    <a class="dana" href="#">Tambah Dana</a>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Foto</label>
                    <?php                    
                    $Qfoto = $db->query("SELECT `path`, sequence FROM proposal_photo WHERE proposal_id='$dx' AND is_nphd='0' ORDER BY sequence ASC");

                    foreach($Qfoto->getResult() as $foto){
                        echo '<div class="controls file">
                                <label class="control-label" style="font-weight:normal"><input type="checkbox" name="del_foto[]" value="'.$foto->sequence.'"> Hapus</label>
                                <input type="file" name="foto[]">
                                <a class="info" target="_blank" href="'.base_url('media/proposal_foto/'.$foto->path).'">Lihat Foto</a>
                                <input type="hidden" name="old_foto[]" value="'.$foto->path.'">
                            </div>';
                    }
                    ?>
                    <a class="link" href="#">Tambah Foto</a>
                </div>
                <div class="control-actions clearfix">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <button class="btn-red btn-plain btn" type="submit">Koreksi</button>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->

<?php
break;

default:
//batas waktu pendaftaran adalah bulan januari dan februari
$currentMonth = date('m');
$session = \Config\Services::session();
$year = date('Y');

$Qlist = $db->table('proposal')
    ->select('proposal.*, proposal_approval.time_entry')
    ->join('proposal_approval', 'proposal_approval.proposal_id = proposal.id')
    ->where('proposal.user_id', $session->get('sabilulungan')['uid'])
    ->where('proposal_approval.flow_id', 7)
    ->where('YEAR(proposal_approval.time_entry) <', $year)
    ->orWhere('YEAR(proposal_approval.time_entry)', $year - 2)
    ->get()
    ->getResult();

$isDaftar = $db->table('proposal')
    ->where('user_id', $session->get('sabilulungan')['uid'])
    ->where('YEAR(time_entry)', $year)
    ->get()
    ->getResult();
if($currentMonth > 2){
   ?>
    <div role="main" class="content-main" style="margin:120px 0 50px">
     <div class="register-page wrapper-half">
          <h1 class="page-title page-title-border">Pendaftaran Telah di Tutup.</h1>
          <div style="width:100%">Pendaftaran Hibah Bansos telah ditutup</div>
        <p>Periode pendaftaran adalah bulan Januari - Februari</p>
        <p>Terimakasih.</p>
     </div>
    </div>
   <?php
}else if($session->get('sabilulungan')['role']!=='5'){
    if(count($Qlist) > 0){
        ?>
        <div role="main" class="content-main" style="margin:120px 0 50px">
        <div class="register-page wrapper-half">
            <h1 class="page-title page-title-border">Saat ini anda tidak masuk dalam kategori penerima Hibah Bansos.</h1>
            <div style="width:100%">Anda telah menerima hibah bansos terakhir kali pada <?= $Qlist->time_entry;?></div>
            <p>Terimakasih.</p>
        </div>
        </div>
        <?php
    }else if(count($isDaftar) > 0){
    ?>
    <div role="main" class="content-main" style="margin:120px 0 50px">
        <div class="register-page wrapper-half">
            <h1 class="page-title page-title-border">Proposal anda sudah kami terima.</h1>
            <div style="width:100%">Terimakasih atas partisipasi anda.</div>
        </div>
        </div>
        <?php
    };?>
<?php
}else{
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">
        <h1 class="page-title page-title-border">Mendaftar Hibah Bansos</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?> 
        <form class="form-global" method="post" action="<?php echo site_url('process/hibah/daftar') ?>" enctype="multipart/form-data">
            <fieldset>
                <?php if($_SESSION['sabilulungan']['role']!=6){ ?>
                <div class="control-group">
                    <label class="control-label" for="">Tanggal Kegiatan</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" required>
                    </div>
                </div>
                <?php } ?>
                <div class="control-group">
                    <label class="control-label" for="">Nama (individu atau organisasi)</label>
                    <div class="controls">
                        <input type="text" name="name" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Alamat</label>
                    <div class="controls">
                        <textarea name="address" required></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Judul Kegiatan</label>
                    <div class="controls">
                        <input type="text" name="judul" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Latar Belakang</label>
                    <div class="controls">
                        <textarea name="latar" required></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Maksud dan Tujuan</label>
                    <div class="controls">
                        <textarea name="maksud" required></textarea>
                    </div>
                </div>
                <!-- <div class="control-group">
                    <label class="control-label" for="">Deskripsi Kegiatan</label>
                    <div class="controls">
                        <textarea name="kegiatan" required></textarea>
                    </div>
                </div> -->
                <div class="control-group">
                    <label class="control-label" for="">Proposal</label>
                    <div class="controls file">
                        <input type="file" name="proposal" accept="application/pdf" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Dana</label>
                    <div class="controls file">
                        <input type="text" name="deskripsi[]" placeholder="Deskripsi">
                        <input type="number" name="jumlah[]" placeholder="Jumlah">
                    </div>
                    <a class="dana" href="#">Tambah Dana</a>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Foto</label>
                    <div class="controls file">
                        <input type="file" accept="image/*" name="foto[]">
                    </div>
                    <a class="link" href="#">Tambah Foto</a>
                </div>
                <div class="control-actions clearfix">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <button class="btn-red btn-plain btn" type="submit">Daftar</button>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- wrapper-half -->
</div>
<?php
}
?>
<!-- content-main -->

<?php
break;

}
?>
<?= $this->endSection(); ?>