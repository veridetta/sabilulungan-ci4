<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php
switch($tp){

case 'nphd':

$Qdana = $db->query("SELECT description, amount FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

$Qmohon = $db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->getResult();

$Qbesar = $db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $besar = $Qbesar->getResult();
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
        <h1 class="page-title page-title-border">NPHD</h1>
        <form class="form-global" method="post" action="<?php echo site_url('process/admin/nphd/'.$dx) ?>" onsubmit="return check(<?php if(isset($besar[0]->value)) echo $besar[0]->value; else echo '0'; ?>)" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Upload NPHD</label>
                    <div class="controls file">
                        <input type="file" name="nphd" accept="application/pdf" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Foto</label>
                    <div class="controls file">
                        <input type="file" name="foto[]" required>
                    </div>
                    <a class="link" href="#">Tambah Foto</a>
                </div>                
                <p class="label">Nominal dari TAPD</p>
                <p><?php if(isset($besar[0]->value)) echo 'Rp. '.number_format($besar[0]->value,0,",",".").',-'; else echo '-'; ?></p>

                <div class="control-group">
                    <label class="control-label" for="">Koreksi Rincian Dana</label>
                    <div class="controls file">
                        <table class="table-global">                            
                            <thead><tr><th>Deskripsi</th><th>Jumlah</th><th>Koreksi</th></tr></thead>
                            <tbody>
                            <?php
                            foreach($Qdana->getResult() as $dana){
                                echo '<tr>
                                        <td>'.$dana->description.'</td>
                                        <td>Rp. '.number_format($dana->amount,0,",",".").',-</td>
                                        <td><input type="number" name="koreksi[]" onkeyup=\'sum()\'></td>
                                    </tr>';
                            }                            
                            ?>
                            </tbody>
                            <tfoot>
                                <?php
                                echo '<tr>
                                        <th>Total</th>
                                        <th>Rp. '.number_format($mohon[0]->mohon,0,",",".").',-</th>
                                        <th><input type="number" name="total" id="total" disabled></th>
                                    </tr>';
                                ?>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Submit" />
                    <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                    <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'lpj':
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
        <h1 class="page-title page-title-border">Laporan Pertanggung Jawaban (LPJ)</h1>
        <form class="form-global" method="post" action="<?php echo site_url('process/admin/lpj/'.$dx) ?>" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Tanggal</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Gambar</label>
                    <div class="controls file">
                        <input type="file" name="foto[]">
                    </div>
                    <a class="link" href="#">Tambah Gambar</a>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Video</label>
                    <div class="controls file">
                        <input type="text" name="video[]" placeholder="Youtube URL">
                    </div>
                    <a class="video" href="#">Tambah Video</a>
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Submit" />
                    <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                    <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'edit':

$Qdana = $db->query("SELECT description, amount, correction FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

$Qmohon = $db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->getResult();

$Qbesar = $db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $besar = $Qbesar->getResult();

$Qedit = $db->query("SELECT nphd FROM proposal WHERE id='$dx'"); $edit = $Qedit->getResult();
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
        <h1 class="page-title page-title-border">NPHD</h1>
        <form class="form-global" method="post" action="<?php echo site_url('process/admin/edit/'.$dx) ?>" onsubmit="return check(<?php if(isset($besar[0]->value)) echo $besar[0]->value; else echo '0'; ?>)" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Upload NPHD</label>
                    <div class="controls file">
                        <input type="file" name="nphd" accept="application/pdf">
                        <a class="info" target="_blank" href="<?php echo base_url('media/nphd/'.$edit[0]->nphd) ?>">Lihat NPHD</a>
                        <input type="hidden" name="old_nphd" value="<?php echo $edit[0]->nphd ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Foto</label>
                    <?php                    
                    $Qfoto = $db->query("SELECT `path`, sequence FROM proposal_photo WHERE proposal_id='$dx' AND is_nphd='1' ORDER BY sequence ASC");

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
                <p class="label">Nominal dari TAPD</p>
                <p><?php if(isset($besar[0]->value)) echo 'Rp. '.number_format($besar[0]->value,0,",",".").',-'; else echo '-'; ?></p>

                <div class="control-group">
                    <label class="control-label" for="">Koreksi Rincian Dana</label>
                    <div class="controls file">
                        <table class="table-global">                            
                            <thead><tr><th>Deskripsi</th><th>Jumlah</th><th>Koreksi</th></tr></thead>
                            <tbody>
                            <?php
                            foreach($Qdana->getResult() as $dana){
                                echo '<tr>
                                        <td>'.$dana->description.'</td>
                                        <td>Rp. '.number_format($dana->amount,0,",",".").',-</td>
                                        <td><input type="number" value="'.$dana->correction.'" name="koreksi[]" onkeyup=\'sum()\'></td>
                                    </tr>';
                            }                            
                            ?>
                            </tbody>
                            <tfoot>
                                <?php
                                echo '<tr>
                                        <th>Total</th>
                                        <th>Rp. '.number_format($mohon[0]->mohon,0,",",".").',-</th>
                                        <th><input type="number" value="'.$besar[0]->value.'" name="total" id="total" disabled></th>
                                    </tr>';
                                ?>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />
                    <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                    <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'view':
$Qedit = $db->query("SELECT tanggal_lpj FROM proposal WHERE id='$dx'"); $edit = $Qedit->getResult();
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
        <h1 class="page-title page-title-border">Laporan Pertanggung Jawaban (LPJ)</h1>
        <form class="form-global" method="post" action="<?php echo site_url('process/admin/view/'.$dx) ?>" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Tanggal</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" value="<?php echo $edit[0]->tanggal_lpj ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Gambar</label>
                    <?php                    
                    $Qfoto = $db->query("SELECT `path`, sequence FROM proposal_lpj WHERE proposal_id='$dx' AND type='1' ORDER BY sequence ASC");

                    foreach($Qfoto->getResult() as $foto){
                        echo '<div class="controls file">
                                <label class="control-label" style="font-weight:normal"><input type="checkbox" name="del_foto[]" value="'.$foto->sequence.'"> Hapus</label>
                                <input type="file" name="foto[]">
                                <a class="info" target="_blank" href="'.base_url('media/proposal_lpj/'.$foto->path).'">Lihat Gambar</a>
                                <input type="hidden" name="old_foto[]" value="'.$foto->path.'">
                            </div>';
                    }
                    ?>
                    <a class="link" href="#">Tambah Gambar</a>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Video</label>
                    <?php                    
                    $Qfoto = $db->query("SELECT `path`, sequence FROM proposal_lpj WHERE proposal_id='$dx' AND type='2' ORDER BY sequence ASC");

                    foreach($Qfoto->getResult() as $foto){
                        echo '<div class="controls file">
                                <label class="control-label" style="font-weight:normal"><input type="checkbox" name="del_video[]" value="'.$foto->sequence.'"> Hapus</label>
                                <input type="text" name="video[]" value="'.$foto->path.'" placeholder="Youtube URL">
                                <input type="hidden" name="old_video[]" value="'.$foto->path.'">
                            </div>';
                    }
                    ?>
                    <a class="video" href="#">Tambah Video</a>
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />
                    <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                    <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

}
?>
<?= $this->endSection(); ?>