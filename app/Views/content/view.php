<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<?php 

$Qedit = $db->query("SELECT * FROM pengumuman WHERE `pengumuman_id`='$dx'"); $edit = $Qedit->getResult();

$time = strtotime($edit[0]->date_created);
switch (date('N', $time)){
    case '1': $day = 'Senin'; break;
    case '2': $day = 'Selasa'; break;
    case '3': $day = 'Rabu'; break;
    case '4': $day = 'Kamis'; break;
    case '5': $day = 'Jum\'at'; break;
    case '6': $day = "Sabtu"; break;
    case '7': $day = 'Minggu'; break;
}
?>

<style type="text/css">
span {
    color: #bbb;
    font-style: italic;
}
</style>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="about-page wrapper">
        <h1 class="page-title page-title-border"><?php echo $edit[0]->judul ?></h1>
        <div class="col-wrapper clearfix">
            <div class="col">
                <?php echo '<span>'.$day.', '.date('d', $time).'/'.date('m', $time).'/'.date('Y', $time).' '.date('H', $time).':'.date('i', $time).' WIB</span><br>'; ?>
                <?php echo $edit[0]->konten ?>
            </div>
        </div>
    </div>
    <!-- wrapper -->    
</div>
<!-- content-main -->
<?= $this->endSection(); ?>