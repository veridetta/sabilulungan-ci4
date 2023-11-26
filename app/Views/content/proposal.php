<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper clearfix">
        <aside class="sidebar">
            <div class="form-search-wrapper">
                <form class="form-search form-search-small clearfix" action="<?php echo site_url('proposal') ?>" method="post">
                    <input type="text" name="keyword" placeholder="Cari Proposal">
                    <button name="search" class="btn-ir" type="submit">Search</button>
                </form>
            </div>
            <div class="widget-side">
            <h2>Kategori hibah bansos</h2>
            <ul class="category-list list-nostyle">
                <?php
                $Qkategori = $db->query("SELECT * FROM skpd ORDER BY id ASC");

                foreach($Qkategori->getResult() as $kategori){
                    echo '<li><a href="'.site_url('proposal/'.$kategori->id).'">'.$kategori->name.'</a></li>';
                }
                ?>            
            </ul>
        </div>
        <!-- widget-side -->
        <div class="widget-side">
            <h2>Status hibah bansos</h2>
            <ul class="category-list list-nostyle">
                <li><a href="<?php echo site_url('proposal/0/1'); ?>">Pemeriksaan Kelengkapan oleh Bagian TU</a></li>
                <li><a href="<?php echo site_url('proposal/0/2'); ?>">Pemeriksaan oleh Walikota</a></li>
                <li><a href="<?php echo site_url('proposal/0/3'); ?>">Klasifikasi sesuai SKPD oleh Tim Pertimbangan</a></li>
                <li><a href="<?php echo site_url('proposal/0/4'); ?>">Rekomendasi Dana oleh SKPD</a></li>
                <li><a href="<?php echo site_url('proposal/0/5'); ?>">Verifikasi Proposal oleh Tim Pertimbangan</a></li>
                <li><a href="<?php echo site_url('proposal/0/6'); ?>">Verifikasi Proposal oleh TAPD</a></li>
                <li><a href="<?php echo site_url('proposal/0/7'); ?>">Proyek Berjalan</a></li>
            </ul>
        </div>
        <!-- widget-side -->
        <div class="widget-side nav-filter">
            <h2>Urut Berdasarkan</h2>
            <ul class="category-list list-nostyle">
                <li><a href="<?php echo site_url('proposal/0/0/1'); ?>">Terbaru</a></li>
                <li><a href="<?php echo site_url('proposal/0/0/2'); ?>">Terbesar</a></li>
            </ul>
        </div>
        <!-- widget-side -->
        <div class="widget-side nav-filter">
            <h2>Tahun</h2>
            <ul class="category-list list-nostyle">
                <?php
                
                $Qtahun = $db->query("SELECT YEAR(`time_entry`) AS tahun FROM `proposal` GROUP BY YEAR(`time_entry`) ORDER BY YEAR(`time_entry`) ASC");

                foreach($Qtahun->getResult() as $tahun){
                    echo '<li><a href="'.site_url('proposal/0/0/0/'.$tahun->tahun).'">'.$tahun->tahun.'</a></li>';
                }
                ?>
            </ul>
        </div>
            <!-- widget-side -->
        </aside>
        <!-- sidebar -->
        <div class="primary">
            <ul class="nav-project list-nostyle clearfix">
                <li class="active">
                    <a class="btn" href="<?php echo site_url('proposal') ?>">Semua</a>
                </li>
                <?php
                if(isset($_SESSION['sabilulungan'])){
                    if($_SESSION['sabilulungan']['role']==6 || $_SESSION['sabilulungan']['role']==7) 
                        echo '<li>
                            <a class="btn" href="'.site_url('proposal/0/0/0/0/'.$_SESSION['sabilulungan']['uid']).'">Proposal Saya</a>
                        </li>';
                    }
                ?>
            </ul>
            <ul class="project-list-wrapper list-nostyle clearfix">
                <?php
                $limit = 26;
                $p = $p ? $p : 1;
                $position = ($p -1) * $limit;
                $db->_protect_identifiers=false;

                $where = ''; $order = 'ORDER BY a.id DESC';
                if($t != 0) $where = 'WHERE a.skpd_id='.$t;
                elseif($tp != 0) $where = 'WHERE a.current_stat='.$tp;
                elseif($d != 0){
                    if($d==1) $order = 'ORDER BY a.id DESC';
                    elseif($d==2) $order = 'ORDER BY mohon DESC';
                }
                elseif($dx != 0) $where = 'WHERE YEAR(a.time_entry)='.$dx;
                elseif($id != 0) $where = 'WHERE a.user_id='.$id;
                elseif(isset($_POST['search'])){
                    $keyword = $_POST['keyword'];
                    $where = "WHERE a.judul LIKE '%$keyword%'";
                }

                $Qlist = $db->query("SELECT a.id, a.name AS oleh, a.user, a.judul, a.latar_belakang, a.current_stat, a.time_entry, b.name, b.role_id, c.name AS skpd, SUM(d.amount) AS mohon, e.name AS tahap
                                        FROM proposal a
                                        LEFT JOIN user b ON b.id=a.user_id
                                        LEFT JOIN skpd c ON c.id=a.skpd_id
                                        LEFT JOIN proposal_dana d ON d.proposal_id=a.id
                                        LEFT JOIN flow e ON e.id=a.current_stat
                                        $where
                                        GROUP BY a.id $order LIMIT $position,$limit")->getResult();

                if(count($Qlist)){
                    $i = 0; $role = array(5, 7, 8);
                    foreach($Qlist as $list){
                        $Qimage = $db->query("SELECT `path` FROM proposal_photo WHERE `proposal_id`='$list->id' ORDER BY sequence ASC LIMIT 1"); $image = $Qimage->getResult();

                        $Qproses = $db->query("SELECT `action` FROM proposal_approval WHERE `proposal_id`='$list->id' ORDER BY flow_id ASC"); $proses = $Qproses->getResult();

                        $Qnilai = $db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$list->id' AND checklist_id='28'"); $nilai = $Qnilai->getResult();

                        $konten = strip_tags($list->latar_belakang); $konten = substr($konten, 0, 150); $length = strlen($konten);

                        echo '<li class="clearfix" id="'.$i.'">
                                <div class="project-list-image">';
                                    if(isset($image[0]->path)) echo '<img src="'.base_url('media/proposal_foto/'.$image[0]->path).'">';
                                echo '</div>
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
                                    <h3><a href="'.site_url('detail/'.$list->id).'">'.$list->judul.'</a></h3>
                                    <p class="author"><span class="label">Tanggal Masuk Proposal:</span> '.date('M d, Y', strtotime($list->time_entry)).'</p>
                                    <p class="author"><span class="label">Oleh:</span> ';
                                    if(isset($list->user)) echo $list->user;
                                    elseif(in_array($list->role_id, $role)) echo $list->oleh;
                                    else echo $list->name;
                                    echo '</p>
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
                                    <p class="author"><span class="label">Nilai yang Diajukan:</span> Rp. '.number_format($list->mohon,0,",",".").',-</p>
                                    <p class="status"><span class="label">Nilai yang Disetujui:</span> '; if(isset($nilai[0]->value)) echo 'Rp. '.number_format($nilai[0]->value,0,",",".").',-'; else echo '-'; echo '</p>
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
                                        $where
                                        GROUP BY a.id $order")->getResult();

            $num_page = ceil(count($Qpaging) / $limit);
            if(count($Qpaging) > $limit){
                if($t != 0) $this->ifunction->paging($p, site_url('proposal').'/'.$t.'/0/0/0/0/', $num_page, count($Qpaging), 'href', false);
                elseif($tp != 0) $this->ifunction->paging($p, site_url('proposal').'/0/'.$tp.'/0/0/0/', $num_page, count($Qpaging), 'href', false);
                elseif($d != 0){
                    if($d==1) $this->ifunction->paging($p, site_url('proposal').'/0/0/'.$d.'/0/0/', $num_page, count($Qpaging), 'href', false);
                    elseif($d==2) $this->ifunction->paging($p, site_url('proposal').'/0/0/'.$d.'/0/0/', $num_page, count($Qpaging), 'href', false);
                }
                elseif($dx != 0) $this->ifunction->paging($p, site_url('proposal').'/0/0/0/'.$dx.'/0/', $num_page, count($Qpaging), 'href', false);
                elseif($id != 0) $this->ifunction->paging($p, site_url('proposal').'/0/0/0/0/'.$id.'/', $num_page, count($Qpaging), 'href', false);
                // elseif(isset($_POST['search'])){
                //     $keyword = $_POST['keyword'];
                //     $where = "WHERE a.judul LIKE '%$keyword%'";
                // }
                else $this->ifunction->paging($p, site_url('proposal').'/0/0/0/0/0/', $num_page, count($Qpaging), 'href', false);
            }
            ?>
        </div>
        <!-- primary -->
    </div>
    <!-- wrapper -->
</div>
<!-- content-main -->
<?= $this->endSection(); ?>