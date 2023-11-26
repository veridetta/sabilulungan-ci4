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
                    echo '<li><a href="'.site_url('proposal/0/'.$kategori->id).'">'.$kategori->name.'</a></li>';
                }
                ?>            
            </ul>
        </div>
        <!-- widget-side -->
        <div class="widget-side">
            <h2>Status hibah bansos</h2>
            <ul class="category-list list-nostyle">
                <li><a href="<?php echo site_url('proposal/0/0/1'); ?>">Pemeriksaan Kelengkapan oleh Bagian TU</a></li>
                <li><a href="<?php echo site_url('proposal/0/0/2'); ?>">Pemeriksaan oleh Walikota</a></li>
                <li><a href="<?php echo site_url('proposal/0/0/3'); ?>">Klasifikasi sesuai SKPD oleh Tim Pertimbangan</a></li>
                <li><a href="<?php echo site_url('proposal/0/0/4'); ?>">Rekomendasi Dana oleh SKPD</a></li>
                <li><a href="<?php echo site_url('proposal/0/0/5'); ?>">Verifikasi Proposal oleh Tim Pertimbangan</a></li>
                <li><a href="<?php echo site_url('proposal/0/0/6'); ?>">Verifikasi Proposal oleh TAPD</a></li>
                <li><a href="<?php echo site_url('proposal/0/0/7'); ?>">Proyek Berjalan</a></li>
            </ul>
        </div>
        <!-- widget-side -->
        <div class="widget-side nav-filter">
            <h2>Urut Berdasarkan</h2>
            <ul class="category-list list-nostyle">
                <li><a href="<?php echo site_url('proposal/0/0/0/1'); ?>">Terbaru</a></li>
                <li><a href="<?php echo site_url('proposal/0/0/0/2'); ?>">Terbesar</a></li>
            </ul>
        </div>
        <!-- widget-side -->
        <div class="widget-side nav-filter">
            <h2>Tahun</h2>
            <ul class="category-list list-nostyle">
                <?php
                $builder = $db->table('proposal');
                $Qtahun = $builder->select("YEAR(`time_entry`) AS tahun")->groupBy("YEAR(`time_entry`)")->orderBy("YEAR(`time_entry`)", "ASC")->get();

                foreach($Qtahun->getResult() as $tahun){
                    echo '<li><a href="'.site_url('proposal/0/0/0/0/'.$tahun->tahun).'">'.$tahun->tahun.'</a></li>';
                }
                ?>
            </ul>
        </div>
            <!-- widget-side -->
        </aside>
        <!-- sidebar -->
        <!-- sidebar -->
        <div class="primary">
            <ul class="nav-project list-nostyle clearfix">
                <li>
                    <a class="btn" href="<?php echo site_url('detail/'.$dx) ?>">Rinci</a>
                </li>
                <li>
                    <a class="btn" href="<?php echo site_url('galeri/'.$dx) ?>">Galeri</a>
                </li>
                <li class="active">
                    <a class="btn" href="#">LPJ</a>
                </li>
                
            </ul>
            <div class="project-detail-wrapper">
                <?php
                $Qjudul = $db->query("SELECT judul FROM proposal WHERE id='$dx'"); $judul = $Qjudul->getResult();

                $Qlpj = $db->query("SELECT `path`, type FROM proposal_lpj WHERE proposal_id='$dx' ORDER BY sequence ASC");
                ?>
                <h1 class="page-title"><?php echo $judul[0]->judul ?></h1>

                <div class="gallery-list-wrapper">
                    <ul class="gallery-list list-nostyle clearfix">
                        <?php
                        $j = 0;
                        foreach($Qlpj->getResult() as $lpj){
                            if($lpj->type==1) echo '
                                <li>
                                    <a class="gallery-popup" href="'.base_url('media/proposal_lpj/'.$lpj->path).'" rel="gallery">
                                       <img src="'.base_url('media/proposal_lpj/'.$lpj->path).'"><span></span>
                                    </a>
                                </li>';
                            elseif($lpj->type==2){
                                $thumb = explode('/', $lpj->path); $nail = explode('?', $thumb[4]); 

                                echo '
                                <li>
                                    <a class="gallery-popup fancybox.iframe" href="'.$lpj->path.'" rel="gallery">
                                        <img src="http://img.youtube.com/vi/'.$nail[0].'/0.jpg" style="width:259px;height:131px;" />
                                    </a>
                                </li>';
                            }

                            $j++;

                            if($j==3){
                                echo '</ul><ul class="gallery-list list-nostyle clearfix">';
                                $j = 0;
                            }
                        }                        
                        ?>                        
                    </ul>
                    <!-- gallery-list -->
                </div>
                <!-- gallery-list-wrapper -->
            </div>
            <!-- project-detail-wrapper -->

            <!-- primary -->
        </div>
        <!-- wrapper -->
    </div>
    <!-- content-main -->
</div>
<!-- main -->
<?= $this->endSection(); ?>