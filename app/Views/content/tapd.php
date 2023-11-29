<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php
switch($tp){

case 'verifikasi':

$Qdetail = $db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$p'"); $detail = $Qdetail->getResult();

$Qket = $db->query("SELECT value AS rekomendasi FROM proposal_checklist WHERE checklist_id=26 AND proposal_id='$p'"); $ket = $Qket->getResult();
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

        <form action="<?php echo site_url('process/tapd/verifikasi/'.$p) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi Pertimbangan</h1>
            <p class="label">Nama (Individu atau Organisasi)</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Nominal yang Direkomendasikan Tim Pertimbangan</p>
            <p><?php echo 'Rp. '.number_format($ket[0]->rekomendasi,0,",",".").',-' ?></p>
            <div class="control-group">
                <label class="control-label" for=""><p class="label">Nominal yang Direkomendasikan TAPD</p></label>
                <div class="controls">
                    <input type="text" placeholder="Rp" name="rekomendasi">
                </div>
            </div>           
            <div class="control-group">
                <label class="control-label" for=""><p class="label">Keterangan</p></label>
                <div class="controls">
                    <textarea rows="5" name="keterangan"></textarea>
                </div>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Verifikasi" />
                <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'generate':

$Qdetail = $db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal, c.value AS keterangan FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id JOIN proposal_checklist c ON c.proposal_id=a.id WHERE a.id='$dx' AND c.checklist_id=13"); $detail = $Qdetail->getResult();
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper">
        <form action="<?php echo site_url('tapd/generate') ?>" method="post" class="form-check form-global">
        <h1 class="page-title page-title-border">Rekapitulasi DNC PBH</h1>
        <div class="form-global">
            <div class="control-group">
                <label class="control-label control-label-inline" for="">Kategori: </label>
                <select name="kategori">
                <!-- <option value="0">-- Silahkan Pilih</option> -->
                <?php
                $Qkategori = $db->table('proposal_type')->select("id, name")->orderBy('id', 'ASC')->get();

                foreach($Qkategori->getResult() as $kategori){
                    echo '<option value="'.$kategori->id.'">'.$kategori->name.'</option>';
                }
                ?>
                </select>
            </div>
            <div class="date-search clearfix">
                <p class="label">Periode Proposal</p>
                <div class="control-group">
                    <label class="control-label control-label-inline" for="">Dari: </label>
                    <input id="datepicker-from" type="text" name="dari" value="<?php echo date('Y'); ?>">
                </div>
                <div class="control-group">
                    <label class="control-label control-label-inline" for="">Sampai: </label>
                    <input id="datepicker-to" type="text" name="sampai" value="<?php echo date('Y'); ?>">
                </div>
                <div class="control-group">
                    <label class="control-label control-label-inline" for="">SKPD: </label>
                    <select name="skpd">
                        <option value="all">Semua SKPD</option>
                        <?php
                        $Qskpd = $db->query("SELECT * FROM skpd ORDER BY id ASC");

                        foreach($Qskpd->getResult() as $skpd){
                            echo '<option value="'.$skpd->id.'">'.$skpd->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="control-actions">
                    <input name="rekap" class="btn-red btn-plain btn" type="submit" value="Rekap DNC PBH">
                </div>
            </div>
        </form>

            <?php   
            $limit = 15;
            $p = $p ? $p : 1;
            $position = ($p -1) * $limit;
            $db->_protect_identifiers=false;
            ?>

            <table class="table-global">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Nama Lengkap Calon Penerima</th>
                        <th rowspan="2">Alamat Lengkap</th>
                        <th rowspan="2">Rencana Penggunaan</th>
                        <th class="has-sub" colspan="3">Besaran Belanja Hibah (Rp)</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>Permohonan</th>
                        <th>Hasil Evaluasi</th>
                        <th>Pertimbangan TAPD</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($_POST['rekap'])){
                        $kategori = $_POST['kategori'];
                        $dari = $_POST['dari'];
                        $sampai = $_POST['sampai'];
                        $skpd = $_POST['skpd'];

                        $where = '';

                        //kategori
                        if($kategori && !$dari && !$sampai && !$skpd){
                            if($kategori=='all') $where .= "";
                            else $where .= "WHERE type_id = $kategori";
                        }elseif($kategori && $dari && !$sampai && !$skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari'";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari'";
                        }elseif($kategori && !$dari && $sampai && !$skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai'";
                        }elseif($kategori && !$dari && !$sampai && $skpd){
                            if($kategori=='all' AND $skpd=='all') $where .= "";
                            elseif($kategori!='all' AND $skpd=='all') $where .= "WHERE type_id = $kategori";
                            elseif($kategori=='all' AND $skpd!='all') $where .= "WHERE skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND skpd_id = $skpd";
                        }                        

                        //dari
                        elseif(!$kategori && $dari && !$sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari'";
                        elseif(!$kategori && $dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                        elseif(!$kategori && $dari && !$sampai && $skpd){
                            if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari'";
                            else $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                        }

                        //sampai
                        elseif(!$kategori && !$dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                        elseif(!$kategori && !$dari && $sampai && $skpd){
                            if($skpd=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                            else $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                        }

                        //skpd
                        elseif(!$kategori && !$dari && !$sampai && $skpd){
                            if($skpd=='all') $where .= "";
                            else $where .= "WHERE skpd_id = $skpd";
                        }

                        //mixed
                        elseif($kategori && $dari && $sampai && !$skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                        }elseif(!$kategori && $dari && $sampai && $skpd){
                            if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                            else $where .= "WHERE skpd_id = $skpd AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                        }elseif($kategori && $dari && !$sampai && $skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                        }elseif($kategori && !$dari && $sampai && $skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                        }elseif($kategori && $dari && $sampai && $skpd){
                            if($kategori=='all' && $skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                            elseif($kategori!='all' && $skpd=='all') $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                            elseif($kategori=='all' && $skpd!='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                        }

                        $Qlist = $db->query("SELECT id, name, address, maksud_tujuan FROM proposal $where ORDER BY id DESC LIMIT $position,$limit");
                    }else $Qlist = $db->table('proposal')->select("id, name, address, maksud_tujuan")->orderBy('id', 'DESC')->limit($limit, $position);
                    if(count($Qlist->get()->getResultArray())){
                        $i = 1;
                        foreach($Qlist->get()->getResult() as $list){
                            $Qmohon = $db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$list->id'"); $mohon = $Qmohon->getResult(); 

                            $Qbesar = $db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$list->id' AND checklist_id IN (26,28,29)"); $besar = $Qbesar->getResult(); 

                            echo '<tr>
                                    <td>'.$i.'</td>
                                    <td>'.$list->name.'</td>
                                    <td>'.$list->address.'</td>
                                    <td>'.$list->maksud_tujuan.'</td>
                                    <td>'; if(isset($mohon[0]->mohon)) echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-'; else echo '-'; echo '</td>
                                    <td>'; if(isset($besar[0]->value)) echo 'Rp. '.number_format($besar[0]->value,0,",",".").',-'; else echo '-'; echo '</td>
                                    <td>'; if(isset($besar[1]->value)) echo 'Rp. '.number_format($besar[1]->value,0,",",".").',-'; else echo '-'; echo '</td>
                                    <td>'; if(isset($besar[2]->value)) echo $besar[2]->value; else echo '-'; echo '</td>
                                </tr>';
                            $i++;
                        }
                    }else echo '<tr><td colspan="8">No data.</td></tr>';
                    ?>
                </tbody>
            </table>

            <?php
            if(isset($_POST['rekap'])){
                $kategori = $_POST['kategori'];
                $dari = $_POST['dari'];
                $sampai = $_POST['sampai'];
                $skpd = $_POST['skpd'];

                $where = '';

                //kategori
                if($kategori && !$dari && !$sampai && !$skpd){
                    if($kategori=='all') $where .= "";
                    else $where .= "WHERE type_id = $kategori";
                }elseif($kategori && $dari && !$sampai && !$skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari'";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari'";
                }elseif($kategori && !$dari && $sampai && !$skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai'";
                }elseif($kategori && !$dari && !$sampai && $skpd){
                    if($kategori=='all' AND $skpd=='all') $where .= "";
                    elseif($kategori!='all' AND $skpd=='all') $where .= "WHERE type_id = $kategori";
                    elseif($kategori=='all' AND $skpd!='all') $where .= "WHERE skpd_id = $skpd";
                    else $where .= "WHERE type_id = $kategori AND skpd_id = $skpd";
                }                        

                //dari
                elseif(!$kategori && $dari && !$sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari'";
                elseif(!$kategori && $dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                elseif(!$kategori && $dari && !$sampai && $skpd){
                    if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari'";
                    else $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                }

                //sampai
                elseif(!$kategori && !$dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                elseif(!$kategori && !$dari && $sampai && $skpd){
                    if($skpd=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                    else $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                }

                //skpd
                elseif(!$kategori && !$dari && !$sampai && $skpd){
                    if($skpd=='all') $where .= "";
                    else $where .= "WHERE skpd_id = $skpd";
                }

                //mixed
                elseif($kategori && $dari && $sampai && !$skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                }elseif(!$kategori && $dari && $sampai && $skpd){
                    if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                    else $where .= "WHERE skpd_id = $skpd AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                }elseif($kategori && $dari && !$sampai && $skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                }elseif($kategori && !$dari && $sampai && $skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                }elseif($kategori && $dari && $sampai && $skpd){
                    if($kategori=='all' && $skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                    elseif($kategori!='all' && $skpd=='all') $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                    elseif($kategori=='all' && $skpd!='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                }

                $Qpaging = $db->query("SELECT id, name, address, maksud_tujuan FROM proposal $where")->getResult();
            }else $Qpaging = $db->table('proposal')->select("id, name, address, maksud_tujuan")->orderBy('id', 'DESC')->get()->getResult();

            $num_page = ceil(count($Qpaging) / $limit);
            if(count($Qpaging) > $limit){
                $this->ifunction->paging($p, site_url('tapd').'/generate/', $num_page, count($Qpaging), 'href', false);
            }
            ?>
            <!-- table-global -->
            <div class="control-actions">
                <!-- <input name="lanjut" class="btn-red btn-plain btn" type="submit" value="Cetak DNC PBH"> -->
                <?php
                if(isset($_POST['rekap'])) echo '<a target="_blank" href="'.base_url('generate_dnc/'.$_POST['kategori'].'/'.$_POST['dari'].'/'.$_POST['sampai'].'/'.$_POST['skpd']).'" class="btn-red btn-plain btn" style="display:inline">Cetak DNC PBH</a>';
                else echo '<a target="_blank" href="'.base_url('generate_dnc/').'" class="btn-red btn-plain btn" style="display:inline">Cetak DNC PBH</a>';
                ?>
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </div>
    </div>
    <!-- wrapper -->
</div>
<!-- content-main -->

<?php
break;

case 'edit':

$Qdetail = $db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$p'"); $detail = $Qdetail->getResult();

$Qket = $db->query("SELECT value AS rekomendasi FROM proposal_checklist WHERE checklist_id=26 AND proposal_id='$p'"); $ket = $Qket->getResult();

$Qedit = $db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$p' AND checklist_id IN (28,29)"); $edit = $Qedit->getResult();
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

        <form action="<?php echo site_url('process/tapd/edit/'.$p) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi Pertimbangan</h1>
            <p class="label">Nama (Individu atau Organisasi)</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Nominal yang Direkomendasikan Tim Pertimbangan</p>
            <p><?php echo 'Rp. '.number_format($ket[0]->rekomendasi,0,",",".").',-' ?></p>
            <div class="control-group">
                <label class="control-label" for=""><p class="label">Nominal yang Direkomendasikan TAPD</p></label>
                <div class="controls">
                    <input type="text" placeholder="Rp" name="rekomendasi" value="<?php if(isset($edit[0]->value)) echo $edit[0]->value ?>">
                </div>
            </div>           
            <div class="control-group">
                <label class="control-label" for=""><p class="label">Keterangan</p></label>
                <div class="controls">
                    <textarea rows="5" name="keterangan"><?php if(isset($edit[1]->value)) echo $edit[1]->value ?></textarea>
                </div>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />
                <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

}
?>
<?= $this->endSection(); ?>