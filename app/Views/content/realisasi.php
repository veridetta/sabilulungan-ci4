<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>


<div role="main" class="content-main" style="margin:120px 0 50px">
<div class="wrapper clearfix">

<?php
switch($tp){

case 'index':
?>
           
    <ul class="nav-project list-nostyle clearfix">
        <li class="active">
            <a class="btn" href="<?php echo site_url('realisasi/add_laporan'); ?>">+ Tambah</a>
        </li>
    </ul>

    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <h1 class="page-title">Laporan</h1>

        <?php   
        $limit = 15;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $db->_protect_identifiers=false;
        ?>

        <table class="table-global">
            <thead>
                <tr>
                    <th width="10">No.</th>
                    <th>Tahun</th>
                    <th>Anggaran (Rp)</th>
                    <th>Realisasi (Rp)</th>
                    <th>Realisasi (%)</th>
                    <th width="100">Jumlah Penerima yang Mencairkan</th>
                    <th width="100">Jumlah Penerima yang Menyampaikan Laporan</th>
                    <th width="100">Nilai yang Dilaporkan</th>                    
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $db->query("SELECT * FROM laporan ORDER BY tahun DESC LIMIT $position,$limit")->getResult();

                if(count($Qlist)){
                    $i = ($p*15)-14;
                    foreach($Qlist as $list){
                        echo '<tr>
                                <td style="text-align: center;">'.$i.'</td>
                                <td>'.$list->tahun.'</td>
                                <td>'.$list->anggaran.'</td>
                                <td>'.$list->realisasi_rp.'</td>
                                <td>'.$list->realisasi_persen.'</td>
                                <td>'.$list->penerima_cair.'</td>
                                <td>'.$list->penerima_lapor.'</td>
                                <td>'.$list->nilai_lapor.'</td>
                                <td style="text-align: center;"><a href="'.site_url('realisasi/edit_laporan/'.$list->laporan_id).'">Edit</a> | <a href="'.base_url('process/realisasi/delete_laporan/'.$list->laporan_id).'" onclick="return confirm(\'Apakah Anda yakin akan menghapus Laporan ini ?\');">Hapus</a></td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $db->query("SELECT laporan_id FROM laporan")->getResult();

        $num_page = ceil(count($Qpaging) / $limit);
        if(count($Qpaging) > $limit){
            $ifunction->paging($p, site_url('realisasi').'/'.$tp.'/', $num_page, count($Qpaging), 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->

<?php
break;

case 'add_laporan':
?>

<div class="project-detail-wrapper">
    <?php
    if(isset($_SESSION['notify'])){
        echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
        unset($_SESSION['notify']);
    }            
    ?>

    <form action="<?php echo site_url('process/realisasi/add_laporan') ?>" method="post" enctype="multipart/form-data" class="form-check form-global">
        <h1 class="page-title">Tambah Laporan</h1>

        <div class="col-wrapper clearfix">
            <div class="control-group">
                <label class="control-label" for="">Tahun</label>
                <div class="controls">
                    <input id="datepicker-from" type="text" name="tahun" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Anggaran</label>
                <div class="controls">
                    <input type="number" name="anggaran" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Realisasi (Rp)</label>
                <div class="controls">
                    <input type="number" name="realisasi_rp" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Realisasi (%)</label>
                <div class="controls">
                    <input type="number" step="0.01" name="realisasi_persen" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Jumlah Penerima yang Mencairkan</label>
                <div class="controls">
                    <input type="number" name="penerima_cair" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Jumlah Penerima yang Menyampaikan Laporan</label>
                <div class="controls">
                    <input type="number" name="penerima_lapor" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Nilai yang Dilaporkan</label>
                <div class="controls">
                    <input type="number" name="nilai_lapor" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Upload Laporan (PDF)</label>
                <div class="controls file">
                    <input type="file" name="laporan" accept="application/pdf" required>
                </div>
            </div>
        </div>

        <div class="control-actions">
            <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Tambah" />
            <a href="<?php echo site_url('realisasi') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
        </div>
    </form>             
</div>
<!-- project-detail-wrapper -->

<?php
break;

case 'edit_laporan':

$Qedit = $db->query("SELECT * FROM laporan WHERE `laporan_id`='$p'"); $edit = $Qedit->getResult();
?>

<div class="project-detail-wrapper">
    <?php
    if(isset($_SESSION['notify'])){
        echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
        unset($_SESSION['notify']);
    }            
    ?>

    <form action="<?php echo site_url('process/realisasi/edit_laporan/'.$p) ?>" method="post" enctype="multipart/form-data" class="form-check form-global">
        <h1 class="page-title">Edit Laporan</h1>

        <div class="col-wrapper clearfix">
            <div class="control-group">
                <label class="control-label" for="">Tahun</label>
                <div class="controls">
                    <input id="datepicker-from" type="text" name="tahun" value="<?php echo $edit[0]->tahun ?>" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Anggaran</label>
                <div class="controls">
                    <input type="number" name="anggaran" value="<?php echo $edit[0]->anggaran ?>" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Realisasi (Rp)</label>
                <div class="controls">
                    <input type="number" name="realisasi_rp" value="<?php echo $edit[0]->realisasi_rp ?>" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Realisasi (%)</label>
                <div class="controls">
                    <input type="number" step="0.01" name="realisasi_persen" value="<?php echo $edit[0]->realisasi_persen ?>" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Jumlah Penerima yang Mencairkan</label>
                <div class="controls">
                    <input type="number" name="penerima_cair" value="<?php echo $edit[0]->penerima_cair ?>" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Jumlah Penerima yang Menyampaikan Laporan</label>
                <div class="controls">
                    <input type="number" name="penerima_lapor" value="<?php echo $edit[0]->penerima_lapor ?>" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Nilai yang Dilaporkan</label>
                <div class="controls">
                    <input type="number" name="nilai_lapor" value="<?php echo $edit[0]->nilai_lapor ?>" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="">Upload Laporan (PDF)</label>
                <div class="controls file">
                    <input type="file" name="laporan" accept="application/pdf">
                    <a class="info" target="_blank" href="<?php echo base_url('media/laporan/'.$edit[0]->file) ?>">Lihat Laporan</a>
                    <input type="hidden" name="old_laporan" value="<?php echo $edit[0]->file ?>">
                </div>
            </div>
        </div>

        <div class="control-actions">
            <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
            <a href="<?php echo site_url('realisasi') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
        </div>
    </form>             
</div>
<!-- project-detail-wrapper -->

<?php
break;

}
?>

</div>
<!-- wrapper -->
</div>
<!-- content-main -->
<?= $this->endSection(); ?>