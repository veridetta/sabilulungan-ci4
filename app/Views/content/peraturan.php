<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="about-page wrapper">
        <h1 class="page-title page-title-border">Peraturan</h1>
        <div class="col-wrapper clearfix">
        

            <style type="text/css">
            .list li{
                text-transform: uppercase; 
            }
            </style>

            <ul class="list">
                <?php
                $Qlist = $db->query("SELECT title, content FROM cms WHERE page_id='peraturan' ORDER BY sequence ASC");

                foreach($Qlist->getResult() as $list){
                    echo '<li><a target="_blank" href="'.base_url('media/peraturan/'.$list->content).'">'.$list->title.'</a></li>';
                }
                ?>
                <!-- ------
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/01.02 SOP_Bendaharan Hibah dan Bantuan Sosial (Repaired).pdf'); ?>">SOP Bendaharan Hibah dan Bantuan Sosial (Repaired)</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/01.03 SK_PPK-PPKD_2016.doc'); ?>">SK PPK-PPKD 2016</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/1. PERMENDAGRI 32 TAHUN 2011.pdf'); ?>">PERMENDAGRI 32 TAHUN 2011</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/1. PERMENDAGRI 39 TAHUN 2012 PERUBAHAN ATAS PERATURAN MENTERI DALAM NEGERI NOMOR 32 TAHUN 2011 TENTANG PEDOMAN PEMBERIAN HIBAH DAN BANTUAN SOSIAL YANG BERSUMBER DARI ANGGARAN PENDAPATAN DAN BELANJA DAERAH.pdf'); ?>">PERMENDAGRI 39 TAHUN 2012 PERUBAHAN ATAS PERATURAN MENTERI DALAM NEGERI NOMOR 32 TAHUN 2011 TENTANG PEDOMAN PEMBERIAN HIBAH DAN BANTUAN SOSIAL YANG BERSUMBER DARI ANGGARAN PENDAPATAN DAN BELANJA DAERAH</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/2. PERWAL NO 891 TAHUN 2011 TENTANG HIBAH BANSOS .pdf'); ?>">PERWAL NO 891 TAHUN 2011 TENTANG HIBAH BANSOS</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/3. PERWAL NO 836 THN 2012 PERUBAHAN I PERWAL 891-2011 HIBAH BANSOS_doc.pdf'); ?>">PERWAL NO 836 THN 2012 PERUBAHAN I PERWAL 891-2011 HIBAH BANSOS</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/4. PERWAL NO 777 THN 2013 PERUBAHAN II PERWAL 891-2011 HIBAH BANSOS.pdf'); ?>">PERWAL NO 777 THN 2013 PERUBAHAN II PERWAL 891-2011 HIBAH BANSOS</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/5. a. PERWAL NO. 825 THN 2013 PERUBAHAN III PERWAL 891-2011 HIBAH BANSOS-evdok.pdf'); ?>">PERWAL NO. 825 THN 2013 PERUBAHAN III PERWAL 891-2011 HIBAH BANSOS-evdok</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/5. b. PERWAL NO. 825 THN 2013 PERUBAHAN III PERWAL 891-2011 HIBAH BANSOS LAMPIRAN.pdf'); ?>">PERWAL NO. 825 THN 2013 PERUBAHAN III PERWAL 891-2011 HIBAH BANSOS LAMPIRAN</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/6. PERWAL NO 1205 THN 2013 PERUBAHAN IV PERWAL 891-2011 HIBAH BANSOS.pdf'); ?>">PERWAL NO 1205 THN 2013 PERUBAHAN IV PERWAL 891-2011 HIBAH BANSOS</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/7. PERWAL NO. 309 THN 2014 PERUBAHAN V PERWAL 891-2011 HIBAH BANSOS.pdf'); ?>">PERWAL NO. 309 THN 2014 PERUBAHAN V PERWAL 891-2011 HIBAH BANSOS</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/8. PERWAL NO. 691 THN 2014 PERUBAHAN V PERWAL 891-2011 HIBAH BANSOS.pdf'); ?>">PERWAL NO. 691 THN 2014 PERUBAHAN V PERWAL 891-2011 HIBAH BANSOS</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/Hibah Bansos Online.docx'); ?>">Hibah Bansos Online</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/Peraturan_Walikota_Nomor_816_Tahun_2015.pdf'); ?>">Peraturan Walikota Nomor 816 Tahun 2015</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/SURAT EDARAN LPJ 2015.docx'); ?>">SURAT EDARAN LPJ 2015</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/Surat Edaran Menteri Dalam Negeri Nomor 9004627SJ Tentang Penajaman Ketentuan Pasal 298 Ayat (5) Undang-Undang Nomor 23 Tahun 2014 Tentang Pemerintahan Daerah.pdf'); ?>">Surat Edaran Menteri Dalam Negeri Nomor 9004627SJ Tentang Penajaman Ketentuan Pasal 298 Ayat (5) Undang-Undang Nomor 23 Tahun 2014 Tentang Pemerintahan Daerah</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/Surat Permberitahuan pemohon.docx'); ?>">Surat Permberitahuan Pemohon</a></li>
                <li><a target="_blank" href="<?php echo base_url('media/peraturan/Surat Permberitahuan SKPD Terkait.docx'); ?>">Surat Permberitahuan SKPD Terkait</a></li> -->
            </ul>
        </div>
    </div>
</div>
<!-- content-main -->
<?= $this->endSection(); ?>