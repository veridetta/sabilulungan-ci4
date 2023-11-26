<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<?php 

$Qedit = $db->query("SELECT content FROM cms WHERE `page_id`='home' ORDER BY sequence ASC"); $edit = $Qedit->getResult();
?>

<div role="main" class="content-main">
    <!-- <div class="alert-bar-success alert-bar">
        <p>Welcome back, World!</p>
    </div> -->
    <section class="section-primary section" style="background: url(<?php echo base_url('media/cms/'.$edit[0]->content) ?>) no-repeat 50% 0;">
        <div class="wrapper clearfix">
            <div class="tagline-intro">
                <h1>BANSOS UNTUK SEMUA</h1>
                <p>
                    <span>Mari wujudkan ide kreatif bersama dengan cara terbuka!</span>
                </p>
                <a class="btn-white btn" href="<?php echo site_url('proposal') ?>">Lihat proposal hibah bansos yang masuk &raquo;</a>
            </div>
            <!-- <div class="register-panel-wrapper">
                <div class="signin-options clearfix">
                    <a class="btn-facebook-connect btn-ir btn" href="#">Sign in with Facebook</a>
                    <p class="link-signin">Already member? <a href="#">Sign in</a></p>
                </div>
                <div class="register-panel-form-wrapper">
                    <h2>New in sabilulungan?</h2>
                    <form class="form-register-panel form-global" action="">
                        <div class="control-group clearfix">
                            <label class="control-label" for="username">Username</label>
                            <div class="controls">
                                <input id="username" type="text">
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                                <input id="password" type="password">
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label" for="password">Password confirmation</label>
                            <div class="controls">
                                <input id="password" type="password">
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label" for="email">E-mail</label>
                            <div class="controls">
                                <input id="email" type="text">
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label" for="name">Nama (individu atau organisasi)</label>
                            <div class="controls">
                                <input id="name" type="text">
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label" for="address">Alamat</label>
                            <div class="controls">
                                <textarea id="address"></textarea>
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label" for="tel">Telepon</label>
                            <div class="controls">
                                <input id="tel" type="text">
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label" for="identity">Nomor KTP</label>
                            <div class="controls">
                                <input id="identity" type="text">
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label" for="contact">Contact Person</label>
                            <div class="controls">
                                <input id="contact" type="text">
                            </div>
                        </div>
                        <div class="control-actions clearfix">
                            <button class="btn-submit btn-red btn" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div> -->
            <!-- register-panel-wrapper -->
        </div>
        <!-- wrapper -->
    </section>
    <!-- section -->
    <section class="section-secondary section" style="background: url(<?php echo base_url('media/cms/'.$edit[1]->content) ?>) no-repeat 50% 0;">
        <div class="tagline">
            <p>Penyaluran dana yang terbuka mewujudkan pembangunan Kota Bandung bersama.</p>
        </div>
        <div class="project-steps">
            <div class="wrapper">
                <h2>Tahapan</h2>
                <ul class="project-steps-list list-nostyle clearfix">
                    <li class="ico-register">Daftar hibah bansos</li>
                    <li class="divider"></li>
                    <li class="ico-select">Proses seleksi</li>
                    <li class="divider"></li>
                    <li class="ico-approve">Hibah bansos disetujui</li>
                    <li class="divider"></li>
                    <li class="ico-progress">Hibah bansos berjalan</li>
                    <li class="divider"></li>
                    <li class="ico-sent">Mengirimkan laporan</li>
                </ul>
            </div>
        </div>
        <!-- project-steps -->
    </section>
    <!-- section -->
    <section class="section-tertiary section">
        <div class="wrapper">
            <ul class="featured-category-tab-nav list-nostyle clearfix">
                <li class="active">
                    <a href="#featured-category-tab-1">Terbaru</a>
                </li>
                <li>
                    <a href="#featured-category-tab-2">Terbesar</a>
                </li>
            </ul>
            <!-- <select name="skpd" style="float:right;margin-top:-55px">
                <option value="0">-- Tahun</option>                        
                <?php
                $builder = $db->table('proposal');
                $Qtahun = $builder->select("YEAR(`time_entry`) AS tahun")->groupBy("YEAR(`time_entry`)")->orderBy("YEAR(`time_entry`)", "ASC")->get();

                foreach($Qtahun->getResult() as $tahun){
                    // echo '<li><a href="'.site_url('proposal/0/0/0/0/'.$tahun->tahun).'">'.$tahun->tahun.'</a></li>';
                    echo '<option value="'.$tahun->tahun.'">'.$tahun->tahun.'</option>';
                }
                ?>
            </select> -->
            <!-- featured-category-tab-nav -->
            <div id="featured-category-tab-1" class="featured-category-tab-panel clearfix">
                <div class="featured-category-intro">
                    <h2>SEMUA BISA DIWUJUDKAN!</h2>
                    <p>Tapi tidak semua dapat tersalurkan. Sabilulungan, semua ide kreatif diharapkan dapat diwujudkan dengan jalan keterbukaan via teknologi. Sehingga semua bisa dapat merealisasikan kesempatan yang sama secara adil tanpa penyelewengan.</p>
                </div>
                <div class="featured-category-list-wrapper">
                    <ul class="project-list-wrapper list-nostyle clearfix">
                        <?php
                        $Qlist = $db->query("SELECT a.id, a.name AS oleh, a.judul, a.time_entry, b.name, b.role_id, c.name AS skpd, SUM(d.amount) AS mohon
                                                FROM proposal a
                                                LEFT JOIN user b ON b.id=a.user_id
                                                LEFT JOIN skpd c ON c.id=a.skpd_id
                                                LEFT JOIN proposal_dana d ON d.proposal_id=a.id
                                                GROUP BY a.id
                                                ORDER BY a.id DESC LIMIT 4")->getResult();

                        if(count($Qlist)){
                            $i = 0; $role = array(5, 7, 8);
                            foreach($Qlist as $list){
                                $Qimage = $db->query("SELECT `path` FROM proposal_photo WHERE `proposal_id`='$list->id' ORDER BY sequence ASC LIMIT 1"); $image = $Qimage->getResult();

                                $Qproses = $db->query("SELECT `action` FROM proposal_approval WHERE `proposal_id`='$list->id' ORDER BY flow_id ASC"); $proses = $Qproses->getResult();

                                $Qtahap = $db->query("SELECT `flow_id` FROM proposal_approval WHERE `proposal_id`='$list->id' ORDER BY flow_id DESC LIMIT 1"); $tahap = $Qtahap->getResult();

                                $Qnilai = $db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$list->id' AND checklist_id='28'"); $nilai = $Qnilai->getResult();

                                echo '<li class="clearfix">
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
                                            <h3><a href="'.site_url('detail/'.$list->id).'">'.$list->judul.'</a></h3>
                                            <p class="author"><span class="label">Tanggal Kegiatan:</span> '.date('M d, Y', strtotime($list->time_entry)).'</p>
                                            <p class="author"><span class="label">Oleh:</span> '; if(in_array($list->role_id, $role)) echo $list->oleh; else echo $list->name; echo '</p>
                                            <p class="status"><span class="label">Tahapan:</span> ';
                                            if(isset($tahap[0]->flow_id)){
                                                switch ($tahap[0]->flow_id) {
                                                    case '1': echo 'Proses Seleksi'; break;
                                                    case '2': echo 'Proses Seleksi'; break;
                                                    case '3': echo 'Proses Seleksi'; break;
                                                    case '4': echo 'Proses Seleksi'; break;
                                                    case '5': echo 'Proyek Disetujui'; break;
                                                    case '6': echo 'Proyek Disetujui'; break;
                                                    case '7': echo 'Proyek Berjalan'; break;
                                                }
                                            }else echo 'Proyek Terdaftar';
                                            echo '</p>
                                            <p class="category"><span class="label">Kategori:</span> '; if($list->skpd) echo $list->skpd; else echo '-'; echo '</p>
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
                </div>
                <!-- featured-category-list-wrapper -->
            </div>
            <!-- featured-category-tab-panel -->
            <div id="featured-category-tab-2" class="featured-category-tab-panel clearfix">
                <div class="featured-category-intro">
                    <h2>SEMUA BISA DIWUJUDKAN!</h2>
                    <p>Tapi tidak semua dapat tersalurkan. Sabilulungan, semua ide kreatif diharapkan dapat diwujudkan dengan jalan keterbukaan via teknologi. Sehingga semua bisa dapat merealisasikan kesempatan yang sama secara adil tanpa penyelewengan.</p>
                </div>
                <div class="featured-category-list-wrapper">
                    <ul class="project-list-wrapper list-nostyle clearfix">
                        <?php
                        $Qlist = $db->query("SELECT a.id, a.name AS oleh, a.judul, a.time_entry, b.name, b.role_id, c.name AS skpd, SUM(d.amount) AS mohon
                                                FROM proposal a
                                                LEFT JOIN user b ON b.id=a.user_id
                                                LEFT JOIN skpd c ON c.id=a.skpd_id
                                                LEFT JOIN proposal_dana d ON d.proposal_id=a.id
                                                GROUP BY a.id
                                                ORDER BY mohon DESC LIMIT 4")->getResult();

                        if(count($Qlist)){
                            $i = 0; $role = array(5, 7, 8);
                            foreach($Qlist as $list){
                                $Qimage = $db->query("SELECT `path` FROM proposal_photo WHERE `proposal_id`='$list->id' ORDER BY sequence ASC LIMIT 1"); $image = $Qimage->getResult();

                                $Qproses = $db->query("SELECT `action` FROM proposal_approval WHERE `proposal_id`='$list->id' ORDER BY flow_id ASC"); $proses = $Qproses->getResult();

                                $Qtahap = $db->query("SELECT `flow_id` FROM proposal_approval WHERE `proposal_id`='$list->id' ORDER BY flow_id DESC LIMIT 1"); $tahap = $Qtahap->getResult();

                                $Qnilai = $db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$list->id' AND checklist_id='28'"); $nilai = $Qnilai->getResult();

                                echo '<li class="clearfix">
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
                                            <h3><a href="'.site_url('detail/'.$list->id).'">'.$list->judul.'</a></h3>
                                            <p class="author"><span class="label">Tanggal Kegiatan:</span> '.date('M d, Y', strtotime($list->time_entry)).'</p>
                                            <p class="author"><span class="label">Oleh:</span> '; if(in_array($list->role_id, $role)) echo $list->oleh; else echo $list->name; echo '</p>
                                            <p class="status"><span class="label">Tahapan:</span> ';
                                            if(isset($tahap[0]->flow_id)){
                                                switch ($tahap[0]->flow_id) {
                                                    case '1': echo 'Proses Seleksi'; break;
                                                    case '2': echo 'Proses Seleksi'; break;
                                                    case '3': echo 'Proses Seleksi'; break;
                                                    case '4': echo 'Proses Seleksi'; break;
                                                    case '5': echo 'Proyek Disetujui'; break;
                                                    case '6': echo 'Proyek Disetujui'; break;
                                                    case '7': echo 'Proyek Berjalan'; break;
                                                }
                                            }else echo 'Proyek Terdaftar';
                                            echo '</p>
                                            <p class="category"><span class="label">Kategori:</span> '; if($list->skpd) echo $list->skpd; else echo '-'; echo '</p>
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
                </div>
                <!-- featured-category-list-wrapper -->
            </div>
            <!-- featured-category-tab-panel -->
        </div>
    </section>
    <!-- section -->
    <section class="quotes section">
        <div class="wrapper">
            <h2>MARI KITA AWASI DAN PANTAU PROGRAM BELANJA HIBAH DAN BANSOS UNTUK BANDUNG JUARA YANG BERSIH DAN TRANSPARAN</h2>
            <p>Transparansi program bansos dan hibah ini mengajak semua untuk menumbuhkan kebersamaan guna kepentingan bersama masa depan Kota Bandung.</p>
            <div class="social-buttons">
                <div class="fb-share-button fb_iframe_widget" data-href="http://sabilulungan.suitmedia.com/" data-width="100" data-type="button_count" fb-xfbml-state="rendered" fb-iframe-plugin-query="app_id=&amp;href=http%3A%2F%2Fsabilulungan.suitmedia.com%2F&amp;locale=en_US&amp;sdk=joey&amp;type=button_count&amp;width=100"><span style="vertical-align: bottom; width: 84px; height: 20px;"><iframe name="f3b1ce2e1" width="100px" height="1000px" frameborder="0" allowtransparency="true" scrolling="no" title="fb:share_button Facebook Social Plugin" src="http://www.facebook.com/plugins/share_button.php?app_id=&amp;channel=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter.php%3Fversion%3D28%23cb%3Df395e250e8%26domain%3Dsabilulungan.suitmedia.com%26origin%3Dhttp%253A%252F%252Fsabilulungan.suitmedia.com%252Ff82ad854c%26relation%3Dparent.parent&amp;href=http%3A%2F%2Fsabilulungan.suitmedia.com%2F&amp;locale=en_US&amp;sdk=joey&amp;type=button_count&amp;width=100" style="border: none; visibility: visible; width: 84px; height: 20px;" class=""></iframe></span></div>
                <iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" src="http://platform.twitter.com/widgets/tweet_button.1386967771.html#_=1387351650097&amp;count=horizontal&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=http%3A%2F%2Fsabilulungan.suitmedia.com%2F&amp;size=m&amp;text=Sabilulungan%2C%20proses%20perwujudan%20proposal%20kegiatan%20sosial%20yang%20transparan%20untuk%20masyarakat%20dari%20PemKot%20Bandung.&amp;url=http%3A%2F%2Fsabilulungan.suitmedia.com%2F" class="twitter-share-button twitter-tweet-button twitter-count-horizontal" title="Twitter Tweet Button" data-twttr-rendered="true" style="width: 107px; height: 20px;vertical-align: middle;"></iframe>
                <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + '://platform.twitter.com/widgets.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, 'script', 'twitter-wjs');</script>
            </div>
        </div>
    </section>
</div>
<!-- content-main -->
<?= $this->endSection(); ?>