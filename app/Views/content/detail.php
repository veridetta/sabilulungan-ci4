<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div id="fb-root"></div>
    <style type="text/css">
        .fb_hidden {
            position: absolute;
            top: -10000px;
            z-index: 10001
        }

        .fb_invisible {
            display: none
        }

        .fb_reset {
            background: none;
            border: 0;
            border-spacing: 0;
            color: #000;
            cursor: auto;
            direction: ltr;
            font-family: "lucida grande", tahoma, verdana, arial, sans-serif;
            font-size: 11px;
            font-style: normal;
            font-variant: normal;
            font-weight: normal;
            letter-spacing: normal;
            line-height: 1;
            margin: 0;
            overflow: visible;
            padding: 0;
            text-align: left;
            text-decoration: none;
            text-indent: 0;
            text-shadow: none;
            text-transform: none;
            visibility: visible;
            white-space: normal;
            word-spacing: normal
        }

        .fb_reset > div {
            overflow: hidden
        }

        .fb_link img {
            border: none
        }

        .fb_dialog {
            background: rgba(82, 82, 82, .7);
            position: absolute;
            top: -10000px;
            z-index: 10001
        }

        .fb_dialog_advanced {
            padding: 10px;
            -moz-border-radius: 8px;
            -webkit-border-radius: 8px;
            border-radius: 8px
        }

        .fb_dialog_content {
            background: #fff;
            color: #333
        }

        .fb_dialog_close_icon {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 0 transparent;
            _background-image: url(../../../static.ak.fbcdn.net/rsrc.php/v2/yL/r/s816eWC-2sl.gif);
            cursor: pointer;
            display: block;
            height: 15px;
            position: absolute;
            right: 18px;
            top: 17px;
            width: 15px;
            top: 8 px\9;
            right: 7 px\9
        }

        .fb_dialog_mobile .fb_dialog_close_icon {
            top: 5px;
            left: 5px;
            right: auto
        }

        .fb_dialog_padding {
            background-color: transparent;
            position: absolute;
            width: 1px;
            z-index: -1
        }

        .fb_dialog_close_icon:hover {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -15px transparent;
            _background-image: url(../../../static.ak.fbcdn.net/rsrc.php/v2/yL/r/s816eWC-2sl.gif)
        }

        .fb_dialog_close_icon:active {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -30px transparent;
            _background-image: url(../../../static.ak.fbcdn.net/rsrc.php/v2/yL/r/s816eWC-2sl.gif)
        }

        .fb_dialog_loader {
            background-color: #f2f2f2;
            border: 1px solid #606060;
            font-size: 24px;
            padding: 20px
        }

        .fb_dialog_top_left,
        .fb_dialog_top_right,
        .fb_dialog_bottom_left,
        .fb_dialog_bottom_right {
            height: 10px;
            width: 10px;
            overflow: hidden;
            position: absolute
        }

        .fb_dialog_top_left {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 0;
            left: -10px;
            top: -10px
        }

        .fb_dialog_top_right {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 -10px;
            right: -10px;
            top: -10px
        }

        .fb_dialog_bottom_left {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 -20px;
            bottom: -10px;
            left: -10px
        }

        .fb_dialog_bottom_right {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 -30px;
            right: -10px;
            bottom: -10px
        }

        .fb_dialog_vert_left,
        .fb_dialog_vert_right,
        .fb_dialog_horiz_top,
        .fb_dialog_horiz_bottom {
            position: absolute;
            background: #525252;
            filter: alpha(opacity=70);
            opacity: .7
        }

        .fb_dialog_vert_left,
        .fb_dialog_vert_right {
            width: 10px;
            height: 100%
        }

        .fb_dialog_vert_left {
            margin-left: -10px
        }

        .fb_dialog_vert_right {
            right: 0;
            margin-right: -10px
        }

        .fb_dialog_horiz_top,
        .fb_dialog_horiz_bottom {
            width: 100%;
            height: 10px
        }

        .fb_dialog_horiz_top {
            margin-top: -10px
        }

        .fb_dialog_horiz_bottom {
            bottom: 0;
            margin-bottom: -10px
        }

        .fb_dialog_iframe {
            line-height: 0
        }

        .fb_dialog_content .dialog_title {
            background: #6d84b4;
            border: 1px solid #3b5998;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            margin: 0
        }

        .fb_dialog_content .dialog_title > span {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/yd/r/Cou7n-nqK52.gif) no-repeat 5px 50%;
            float: left;
            padding: 5px 0 7px 26px
        }

        body.fb_hidden {
            -webkit-transform: none;
            height: 100%;
            margin: 0;
            overflow: visible;
            position: absolute;
            top: -10000px;
            left: 0;
            width: 100%
        }

        .fb_dialog.fb_dialog_mobile.loading {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/ya/r/3rhSv5V8j3o.gif) white no-repeat 50% 50%;
            min-height: 100%;
            min-width: 100%;
            overflow: hidden;
            position: absolute;
            top: 0;
            z-index: 10001
        }

        .fb_dialog.fb_dialog_mobile.loading.centered {
            max-height: 590px;
            min-height: 590px;
            max-width: 500px;
            min-width: 500px
        }

        #fb-root #fb_dialog_ipad_overlay {
            background: rgba(0, 0, 0, .45);
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            min-height: 100%;
            z-index: 10000
        }

        #fb-root #fb_dialog_ipad_overlay.hidden {
            display: none
        }

        .fb_dialog.fb_dialog_mobile.loading iframe {
            visibility: hidden
        }

        .fb_dialog_content .dialog_header {
            -webkit-box-shadow: white 0 1px 1px -1px inset;
            background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#738ABA), to(#2C4987));
            border-bottom: 1px solid;
            border-color: #1d4088;
            color: #fff;
            font: 14px Helvetica, sans-serif;
            font-weight: bold;
            text-overflow: ellipsis;
            text-shadow: rgba(0, 30, 84, .296875) 0 -1px 0;
            vertical-align: middle;
            white-space: nowrap
        }

        .fb_dialog_content .dialog_header table {
            -webkit-font-smoothing: subpixel-antialiased;
            height: 43px;
            width: 100%
        }

        .fb_dialog_content .dialog_header td.header_left {
            font-size: 12px;
            padding-left: 5px;
            vertical-align: middle;
            width: 60px
        }

        .fb_dialog_content .dialog_header td.header_right {
            font-size: 12px;
            padding-right: 5px;
            vertical-align: middle;
            width: 60px
        }

        .fb_dialog_content .touchable_button {
            background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#4966A6), color-stop(0.5, #355492), to(#2A4887));
            border: 1px solid #29447e;
            -webkit-background-clip: padding-box;
            -webkit-border-radius: 3px;
            -webkit-box-shadow: rgba(0, 0, 0, .117188) 0 1px 1px inset, rgba(255, 255, 255, .167969) 0 1px 0;
            display: inline-block;
            margin-top: 3px;
            max-width: 85px;
            line-height: 18px;
            padding: 4px 12px;
            position: relative
        }

        .fb_dialog_content .dialog_header .touchable_button input {
            border: none;
            background: none;
            color: #fff;
            font: 12px Helvetica, sans-serif;
            font-weight: bold;
            margin: 2px -12px;
            padding: 2px 6px 3px 6px;
            text-shadow: rgba(0, 30, 84, .296875) 0 -1px 0
        }

        .fb_dialog_content .dialog_header .header_center {
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            line-height: 18px;
            text-align: center;
            vertical-align: middle
        }

        .fb_dialog_content .dialog_content {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/y9/r/jKEcVPZFk-2.gif) no-repeat 50% 50%;
            border: 1px solid #555;
            border-bottom: 0;
            border-top: 0;
            height: 150px
        }

        .fb_dialog_content .dialog_footer {
            background: #f2f2f2;
            border: 1px solid #555;
            border-top-color: #ccc;
            height: 40px
        }

        #fb_dialog_loader_close {
            float: left
        }

        .fb_dialog.fb_dialog_mobile .fb_dialog_close_button {
            text-shadow: rgba(0, 30, 84, .296875) 0 -1px 0
        }

        .fb_dialog.fb_dialog_mobile .fb_dialog_close_icon {
            visibility: hidden
        }

        .fb_iframe_widget {
            display: inline-block;
            position: relative
        }

        .fb_iframe_widget span {
            display: inline-block;
            position: relative;
            text-align: justify
        }

        .fb_iframe_widget iframe {
            position: absolute
        }

        .fb_iframe_widget_lift {
            z-index: 1
        }

        .fb_hide_iframes iframe {
            position: relative;
            left: -10000px
        }

        .fb_iframe_widget_loader {
            position: relative;
            display: inline-block
        }

        .fb_iframe_widget_fluid {
            display: inline
        }

        .fb_iframe_widget_fluid span {
            width: 100%
        }

        .fb_iframe_widget_loader iframe {
            min-height: 32px;
            z-index: 2;
            zoom: 1
        }

        .fb_iframe_widget_loader .FB_Loader {
            background: url(../../../static.ak.fbcdn.net/rsrc.php/v2/y9/r/jKEcVPZFk-2.gif) no-repeat;
            height: 32px;
            width: 32px;
            margin-left: -16px;
            position: absolute;
            left: 50%;
            z-index: 4
        }

        .fb_connect_bar_container div,
        .fb_connect_bar_container span,
        .fb_connect_bar_container a,
        .fb_connect_bar_container img,
        .fb_connect_bar_container strong {
            background: none;
            border-spacing: 0;
            border: 0;
            direction: ltr;
            font-style: normal;
            font-variant: normal;
            letter-spacing: normal;
            line-height: 1;
            margin: 0;
            overflow: visible;
            padding: 0;
            text-align: left;
            text-decoration: none;
            text-indent: 0;
            text-shadow: none;
            text-transform: none;
            visibility: visible;
            white-space: normal;
            word-spacing: normal;
            vertical-align: baseline
        }

        .fb_connect_bar_container {
            position: fixed;
            left: 0 !important;
            right: 0 !important;
            height: 42px !important;
            padding: 0 25px !important;
            margin: 0 !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #333 !important;
            background: #3b5998 !important;
            z-index: 99999999 !important;
            overflow: hidden !important
        }

        .fb_connect_bar_container_ie6 {
            position: absolute;
            top: expression(document.compatMode=="CSS1Compat"? document.documentElement.scrollTop+"px":body.scrollTop+"px")
        }

        .fb_connect_bar {
            position: relative;
            margin: auto;
            height: 100%;
            width: 100%;
            padding: 6px 0 0 0 !important;
            background: none;
            color: #fff !important;
            font-family: "lucida grande", tahoma, verdana, arial, sans-serif !important;
            font-size: 13px !important;
            font-style: normal !important;
            font-variant: normal !important;
            font-weight: normal !important;
            letter-spacing: normal !important;
            line-height: 1 !important;
            text-decoration: none !important;
            text-indent: 0 !important;
            text-shadow: none !important;
            text-transform: none !important;
            white-space: normal !important;
            word-spacing: normal !important
        }

        .fb_connect_bar a:hover {
            color: #fff
        }

        .fb_connect_bar .fb_profile img {
            height: 30px;
            width: 30px;
            vertical-align: middle;
            margin: 0 6px 5px 0
        }

        .fb_connect_bar div a,
        .fb_connect_bar span,
        .fb_connect_bar span a {
            color: #bac6da;
            font-size: 11px;
            text-decoration: none
        }

        .fb_connect_bar .fb_buttons {
            float: right;
            margin-top: 7px
        }

        .fb_edge_widget_with_comment {
            position: relative;
            *z-index: 1000
        }

        .fb_edge_widget_with_comment span.fb_edge_comment_widget {
            position: absolute
        }

        .fb_edge_widget_with_comment span.fb_send_button_form_widget {
            z-index: 1
        }

        .fb_edge_widget_with_comment span.fb_send_button_form_widget .FB_Loader {
            left: 0;
            top: 1px;
            margin-top: 6px;
            margin-left: 0;
            background-position: 50% 50%;
            background-color: #fff;
            height: 150px;
            width: 394px;
            border: 1px #666 solid;
            border-bottom: 2px solid #283e6c;
            z-index: 1
        }

        .fb_edge_widget_with_comment span.fb_send_button_form_widget.dark .FB_Loader {
            background-color: #000;
            border-bottom: 2px solid #ccc
        }

        .fb_edge_widget_with_comment span.fb_send_button_form_widget.siderender
        .FB_Loader {
            margin-top: 0
        }

        .fbpluginrecommendationsbarleft,
        .fbpluginrecommendationsbarright {
            position: fixed !important;
            bottom: 0;
            z-index: 999
        }

        .fbpluginrecommendationsbarleft {
            left: 10px
        }

        .fbpluginrecommendationsbarright {
            right: 10px
        }
    </style>
    <script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "<?php echo base_url('static/js/connect.facebook.net/en_US/all.js#xfbml=1') ?>";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


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
            <div class="primary">
                <ul class="nav-project list-nostyle clearfix">
                    <li class="active">
                        <a class="btn" href="#">Rinci</a>
                    </li>
                    <li>
                        <a class="btn" href="<?php echo site_url('galeri/'.$dx) ?>">Galeri</a>
                    </li>
                    <li>
                        <a class="btn" href="<?php echo site_url('laporan/'.$dx) ?>">LPJ</a>
                    </li>
                </ul>
                <?php
                $Qlist = $db->query("SELECT a.id, a.judul, a.name, a.address, a.latar_belakang, a.maksud_tujuan, a.file, a.nphd, a.tanggal_lpj, a.time_entry, b.name AS tahap
                                        FROM proposal a
                                        LEFT JOIN flow b ON b.id=a.current_stat
                                        WHERE a.id='$dx'"); $list = $Qlist->getResult();

                $Qtu = $db->query("SELECT value FROM proposal_checklist WHERE checklist_id='13' AND proposal_id='$dx'"); $tu = $Qtu->getResult();

                $Qimage = $db->query("SELECT `path` FROM proposal_photo WHERE `proposal_id`='$dx' ORDER BY sequence ASC LIMIT 1"); $image = $Qimage->getResult();

                //$Qtahap = $db->query("SELECT `flow_id` FROM proposal_approval WHERE `proposal_id`='$dx' ORDER BY flow_id DESC LIMIT 1"); $tahap = $Qtahap->getResult();
                ?>
                <div class="project-detail-wrapper">
                    <h1 class="page-title"><?php echo $list[0]->judul ?></h1>

                    <div class="project-detail-description clearfix">
                        <div class="project-detail-left">
                            <div class="project-detail-image">                                
                                <img src="<?php echo base_url('media/proposal_foto/'.$image[0]->path) ?>">     
                            </div>
                            <div class="social-buttons">
                                <div class="fb-share-button" data-href="http://sabilulungan.bandung.go.id/proposal/1/detail"
                                     data-width="100" data-type="button_count"></div>
                                <a href="https://twitter.com/share" class="twitter-share-button"
                                   data-text="Inilah proposal program masyarakat yang mendapat dana bantuan dari pemerintah. Karena berani transparansi itu juara!!">Tweet</a>
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
                        <div class="project-detail-right">
                            <p><span class="label">Nama (Individu atau Organisasi): </span><?php echo $list[0]->name ?>
                            </p>

                            <p><span class="label">Alamat: </span><?php echo $list[0]->address ?></p>

                            <p>
                                <span class="label">Latar Belakang:</span> <br>
                                <?php echo $list[0]->latar_belakang ?></p>

                            <p>
                                <span class="label">Maksud dan Tujuan:</span> <br>
                                <?php echo $list[0]->maksud_tujuan ?> 
                            </p>

                            <p><span class="label">Tanggal Masuk Proposal:</span> <br>
                                 <?php if(isset($list[0]->time_entry)) echo date('M d, Y', strtotime($list[0]->time_entry)); else echo '-'; ?>
                            </p>

                            <a class="btn-proposal btn-ir" href="<?php echo base_url('media/proposal/'.$list[0]->file) ?>" target="_blank" style="display:inline-block">Proposal Proyek</a>
                            <?php if(isset($list[0]->nphd)){ ?>
                            <a class="btn-nphd btn-ir" href="<?php echo base_url('media/nphd/'.$list[0]->nphd) ?>" target="_blank"  style="display:inline-block">NPHD</a>
                            <?php } ?>
                            <p>
                                Tahap: <?php
                                        if(isset($list[0]->tahap)) echo $list[0]->tahap; else echo 'Proyek Terdaftar';

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
                                        ?>                              
                            </p>
                            
                             <p><span class="label">Keterangan TU:</span> <br>
                                 <?php if(isset($tu[0]->value)) echo $tu[0]->value; else echo '-'; ?>
                             </p>
                            
                            <p><span class="label">Tanggal Masuk LPJ:</span> <br>
                                 <?php if(isset($list[0]->tanggal_lpj)) echo date('M d, Y', strtotime($list[0]->tanggal_lpj)); else echo '-'; ?>
                            </p>
                            
                        </div>

                    </div>

                    <h2>Rencana Penggunaan Dana</h2>
                    <table class="table-data table-global">
                        <thead>
                        <tr>
                            <th>Dana</th>
                            <th>Proposal</th>
                            <th>Disetujui</th>
                        </tr>
                        </thead>                        
                        <tbody>
                            <?php
                            $Qdana = $db->query("SELECT description, amount, correction FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

                            $Qmohon = $db->query("SELECT SUM(amount) AS mohon, SUM(correction) AS setuju FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->getResult();

                            $Qnilai = $db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $nilai = $Qnilai->getResult();

                            foreach($Qdana->getResult() as $dana){
                                echo '<tr>
                                        <td>'.$dana->description.'</td>
                                        <td>Rp. '.number_format($dana->amount,0,",",".").',-</td>
                                        <td>Rp. '.number_format($dana->correction,0,",",".").',-</td>
                                    </tr>';
                            }
                            ?>                        
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <th><?php echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-'; ?></th>
                            <th><?php echo 'Rp. '.number_format($mohon[0]->setuju,0,",",".").',-'; ?></th>
                        </tr>
                        <!-- <tr>
                            <th>Nilai yang Disetujui</th>
                            <th><?php if(isset($nilai[0]->value)) echo 'Rp. '.number_format($nilai[0]->value,0,",",".").',-'; else echo '-'; ?></th>
                            <th><?php if(isset($nilai[0]->value)) echo 'Rp. '.number_format($nilai[0]->value,0,",",".").',-'; else echo '-'; ?></th>
                        </tr> -->
                        </tfoot>
                    </table>
                    <div class="comments">
                        <h2>Komentar</h2>

                        <div id="disqus_thread"></div>
                        <script type="text/javascript">
                            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                            var disqus_shortname = 'sabilulungan'; // required: replace example with your forum shortname

                            /* * * DON'T EDIT BELOW THIS LINE * * */
                            (function () {
                                var dsq = document.createElement('script');
                                dsq.type = 'text/javascript';
                                dsq.async = true;
                                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments
                            powered by Disqus.</a></noscript>
                        <a href="http://disqus.com/" class="dsq-brlink">comments powered by <span
                                class="logo-disqus">Disqus</span></a>
                    </div>
                    <!-- comments -->
                </div>
                <!-- project-detail-wrapper -->
            </div>
            <!-- primary -->
        </div>
        <!-- wrapper -->
    </div>
    <!-- content-main -->
<?= $this->endSection(); ?>