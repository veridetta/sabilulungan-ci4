<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php
switch($tp){

case 'list':
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper clearfix">        
        <div class="primary">
            <ul class="project-list-wrapper list-nostyle clearfix">
                <?php
                $limit = 26;
                $p = $p ? $p : 1;
                $position = ($p -1) * $limit;
                $db->_protect_identifiers=false;

                $id = $_SESSION['sabilulungan']['uid'];
                $Qlist = $db->query("SELECT a.id, a.user, a.judul, a.latar_belakang, a.current_stat, b.name, c.name AS skpd, SUM(d.amount) AS mohon, e.name AS tahap
                                        FROM proposal a
                                        LEFT JOIN user b ON b.id=a.user_id
                                        LEFT JOIN skpd c ON c.id=a.skpd_id
                                        LEFT JOIN proposal_dana d ON d.proposal_id=a.id
                                        LEFT JOIN flow e ON e.id=a.current_stat
                                        WHERE a.user_id='$id'
                                        GROUP BY a.id ORDER BY a.id DESC LIMIT $position,$limit")->getResult();

                if(count($Qlist)){
                    $i = 0;
                    foreach($Qlist as $list){
                        $Qimage = $db->query("SELECT `path` FROM proposal_photo WHERE `proposal_id`='$list->id' ORDER BY sequence ASC LIMIT 1"); $image = $Qimage->getResult();

                        $Qproses = $db->query("SELECT `action` FROM proposal_approval WHERE `proposal_id`='$list->id' ORDER BY flow_id ASC"); $proses = $Qproses->getResult();

                        //$Qtahap = $db->query("SELECT `flow_id` FROM proposal_approval WHERE `proposal_id`='$list->id' ORDER BY flow_id DESC LIMIT 1"); $tahap = $Qtahap->getResult();

                        $konten = strip_tags($list->latar_belakang); $konten = substr($konten, 0, 150); $length = strlen($konten);

                        echo '<li class="clearfix" id="'.$i.'">
                                <div class="project-list-image">
                                    <img src="'.base_url('media/proposal_foto/'.$image[0]->path).'">
                                </div>
                                <div class="project-list-text">
                                    <ul class="project-list-progress list-nostyle clearfix">
                                        <li class="step-1 '; if(isset($proses[0])==1) echo 'done'; elseif(isset($proses[0])==2) echo 'failed'; echo '">1</li>
                                        <li class="step-2 '; if(isset($proses[1])==1) echo 'done'; elseif(isset($proses[1])==2) echo 'failed'; echo '">2</li>
                                        <li class="step-3 '; if(isset($proses[2])==1) echo 'done'; elseif(isset($proses[2])==2) echo 'failed'; echo '">3</li>
                                        <li class="step-4 '; if(isset($proses[3])==1) echo 'done'; elseif(isset($proses[3])==2) echo 'failed'; echo '">4</li>
                                        <li class="step-5 '; if(isset($proses[4])==1) echo 'done'; elseif(isset($proses[4])==2) echo 'failed'; echo '">5</li>
                                        <li class="step-6 '; if(isset($proses[5])==1) echo 'done'; elseif(isset($proses[5])==2) echo 'failed'; echo '">6</li>
                                        <li class="step-7 '; if(isset($proses[6])==1) echo 'done'; elseif(isset($proses[6])==2) echo 'failed'; echo '">7</li>
                                    </ul>
                                    <h3><a href="'.site_url('lpj/add/'.$list->id).'">'.$list->judul.'</a></h3>
                                    <p class="author"><span class="label">Oleh:</span> '; if(isset($list->user)) echo $list->user; else echo $list->name; echo '</p>
                                    <p class="status"><span class="label">Tahapan:</span> ';
                                    if(isset($list->tahap)) echo $list->tahap; else echo 'Proyek Terdaftar';
                                    // if(isset($tahap[0]->flow_id)){
                                    //     switch ($tahap[0]->flow_id) {
                                    //         case '1': echo 'Proses Seleksi'; break;
                                    //         case '2': echo 'Proses Seleksi'; break;
                                    //         case '3': echo 'Proses Seleksi'; break;
                                    //         case '4': echo 'Proses Seleksi'; break;
                                    //         case '5': echo 'Proyek Disetujui'; break;
                                    //         case '6': echo 'Proyek Disetujui'; break;
                                    //         case '7': echo 'Proyek Berjalan'; break;
                                    //     }
                                    // }else echo 'Proyek Terdaftar';
                                    echo '</p>
                                    <p class="category"><span class="label">Kategori:</span> '; if($list->skpd) echo $list->skpd; else echo '-'; echo '</p>
                                    <p>'.$konten; if($length >= 150) echo '...'; echo '</p>
                                    <p class="price">Rp. '.number_format($list->mohon,0,",",".").',-</p>
                                </div>
                            </li>'; 

                        $i++;

                        if($i==2){
                            echo '</ul><ul class="project-list-wrapper list-nostyle clearfix">';
                            $i = 0;
                        }
                    }                    
                }
                ?>
            </ul>
            <!-- project-list-wrapper -->
            <?php
            $Qpaging = $db->query("SELECT a.id, a.user, a.judul, a.latar_belakang, a.current_stat, b.name, c.name AS skpd, SUM(d.amount) AS mohon, e.name AS tahap
                                        FROM proposal a
                                        LEFT JOIN user b ON b.id=a.user_id
                                        LEFT JOIN skpd c ON c.id=a.skpd_id
                                        LEFT JOIN proposal_dana d ON d.proposal_id=a.id
                                        LEFT JOIN flow e ON e.id=a.current_stat
                                        WHERE a.user_id='$id'
                                        GROUP BY a.id ORDER BY a.id DESC")->getResult(); 

            $num_page = ceil(count($Qpaging) / $limit);
            if(count($Qpaging) > $limit){
                $this->ifunction->paging($p, site_url('lpj').'/list/'.$id.'/', $num_page, count($Qpaging), 'href', false);
            }
            ?>
        </div>
        <!-- primary -->
    </div>
    <!-- wrapper -->
</div>
<!-- content-main -->

<?php
break;

case 'add':

$Qdetail = $db->query("SELECT a.name, a.address, a.judul, a.latar_belakang, a.maksud_tujuan, a.time_entry, SUM(b.amount) AS mohon FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); 
$detail = $Qdetail->getResult();
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">
        <h1 class="page-title page-title-border">Laporan Pertanggung Jawaban</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?> 
        <p class="label">Nama (Individu atau Organisasi)</p>
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
        <p><?php echo 'Rp. '.number_format($detail[0]->mohon,0,",",".").',-' ?></p>

        <form class="form-global" method="post" action="<?php echo site_url('process/lpj/add/'.$dx) ?>" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Laporan Pertanggung Jawaban (Gambar)</label>
                    <div class="controls file">
                        <input type="file" name="foto[]">
                        <input type="text" name="deskripsi[]" accept="image/*" placeholder="Deskripsi">
                    </div>
                    <a class="lpj" href="#">Tambah Laporan</a>
                </div>
                <div class="control-actions clearfix">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <button class="btn-red btn-plain btn" type="submit">Tambah</button>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->

<?php
break;

}
?>
<?= $this->endSection(); ?>