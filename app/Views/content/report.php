<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>


<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper">
        <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>
        <!-- Filter -->
        <form action="<?php echo site_url('report') ?>" method="post" class="form-check form-global">
        <div class="form-global">
            <div class="control-group">
                <label class="control-label control-label-inline" for="">Kategori: </label>
                <select name="kategori">
                <!-- <option value="0">-- Silahkan Pilih</option> -->
                <?php
                $builder = $db->table('proposal_type');
                $builder->select("id, name");
                $builder->orderBy('id', 'ASC');
                $Qkategori = $builder->get();

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
                    <input name="filter" class="btn-red btn-plain btn" type="submit" value="Filter">
                </div>
            </div>
        </div>
        </form>

        <!-- Search -->
        <div class="form-search-wrapper-alt">
            <form class="form-search form-search-large clearfix" action="<?php echo site_url('report') ?>" method="post">
                <input type="text" name="keyword" placeholder="Search Hibah Bansos">
                <button name="search" class="btn-ir" type="submit">Search</button>
            </form>
        </div>        

        <?php   
        $limit = 15;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $db->_protect_identifiers=false;
        ?>

        <table class="table-global">
        <?php
        if($_SESSION['sabilulungan']['role']==7 || $_SESSION['sabilulungan']['role']==9) echo '<thead>
            <tr>
                <th rowspan="2">Judul Kegiatan</th>
                <th colspan="3">Besaran Belanja Hibah (Rp)</th>
                <th colspan="9">Status</th>
                <th rowspan="2">Detail</th>
            </tr>
            <tr>
                <th>Permohonan</th>
                <th>Hasil Evaluasi</th>
                <th>Pertimbangan TAPD</th>
                <th>Pemeriksaan TU</th>
                <th>Pemeriksaan Bupati</th>
                <th>Pemeriksaan Tim Pertimbangan</th>
                <th>Pemeriksaan SKPD</th>
                <th>Verifikasi Tim Pertimbangan</th>
                <th>Verifikasi TAPD</th>
                <th>Penyetujuan Bupati</th>
                <th>NPHD</th>
                <th>LPJ</th>
            </tr>
        </thead>';
        else echo '<thead>
            <tr>
                <th rowspan="2">Judul Kegiatan</th>
                <th colspan="3">Besaran Belanja Hibah (Rp)</th>
                <th colspan="7">Status</th>
                <th rowspan="2">Detail</th>
            </tr>
            <tr>
                <th>Permohonan</th>
                <th>Hasil Evaluasi</th>
                <th>Pertimbangan TAPD</th>
                <th>Pemeriksaan TU</th>
                <th>Pemeriksaan Bupati</th>
                <th>Pemeriksaan Tim Pertimbangan</th>
                <th>Pemeriksaan SKPD</th>
                <th>Verifikasi Tim Pertimbangan</th>
                <th>Verifikasi TAPD</th>
                <th>Penyetujuan Bupati</th>
            </tr>
        </thead>';
        ?>        
        <tbody>
        <?php
        //Otomatis Approve Walikota
        $Qcheck = $db->query("SELECT a.id, b.time_entry FROM proposal a JOIN proposal_approval b ON b.proposal_id=a.id WHERE a.current_stat=1")->getResult(); 

        if(count($Qcheck)){
            foreach($Qcheck as $check){
                $date = date('Y-m-d', strtotime($check->time_entry));
                $new = strtotime('+2 day', strtotime($date)); $newdate = date('Y-m-d', $new);
                $today = date('Y-m-d');

                if($newdate < $today){
                    $db->update("proposal", array('current_stat' => 2), array('id' => $check->id));

                    $Qchecks = $db->table('proposal_approval')->select("user_id")->where('proposal_id', $check->id)->where('flow_id', 2)->get()->getResult();
                    if(count($Qchecks)) $db->update("proposal_approval", array('user_id' => $_SESSION['sabilulungan']['uid'], 'action' => 1), array('proposal_id' => $check->id, 'flow_id' => 2));
                    else $db->insert("proposal_approval", array('proposal_id' => $check->id, 'user_id' => $_SESSION['sabilulungan']['uid'], 'flow_id' => 2, 'action' => 1));

                    $db->insert("proposal_approval_history", array('proposal_id' => $check->id, 'user_id' => $_SESSION['sabilulungan']['uid'], 'flow_id' => 2, 'role_id' => $_SESSION['sabilulungan']['role'], 'action' => 1)); 
                }
            }
        }

        if(isset($_POST['search'])){
            //Query Search
            $walikota = array(1,6); $pertimbangan = array(2,4);
            $builder = $db->table('proposal');
            $builder->select("id, name, address, judul, current_stat, nphd, tanggal_lpj");
            $builder->like('judul', $_POST['keyword']);
            $builder->orderBy('id', 'DESC');
            $builder->limit($limit, $position);

            if($_SESSION['sabilulungan']['role'] == 5) {
                $builder->where('current_stat', null);
            } elseif($_SESSION['sabilulungan']['role'] == 1) {
                $builder->whereIn('current_stat', $walikota);
            } elseif($_SESSION['sabilulungan']['role'] == 4) {
                $builder->whereIn('current_stat', $pertimbangan);
            } elseif($_SESSION['sabilulungan']['role'] == 3) {
                $builder->where('current_stat', 3);
                $builder->where('skpd_id', $_SESSION['sabilulungan']['skpd']);
            } elseif($_SESSION['sabilulungan']['role'] == 2) {
                $builder->where('current_stat', 5);
            } elseif($_SESSION['sabilulungan']['role'] == 7 || $_SESSION['sabilulungan']['role'] == 9) {
                // No additional conditions
            }
            $Qlist = $builder->get()->getResult();
        }elseif(isset($_POST['filter'])){
            $kategori = $_POST['kategori'];
            $dari = $_POST['dari'];
            $sampai = $_POST['sampai'];
            $skpd = $_POST['skpd'];            

            $where = ''; $stat = 'current_stat!=8';

            $walikota = array(1,6); $pertimbangan = array(2,4); $sskpd = $_SESSION['sabilulungan']['skpd'];
            if($_SESSION['sabilulungan']['role']==5) $stat .= " AND current_stat=NULL";
            elseif($_SESSION['sabilulungan']['role']==1) $stat .= " AND current_stat IN ($walikota)";
            elseif($_SESSION['sabilulungan']['role']==4) $stat .= " AND current_stat IN ($pertimbangan)";
            elseif($_SESSION['sabilulungan']['role']==3) $stat .= " AND current_stat=3 AND skpd_id=$sskpd";
            elseif($_SESSION['sabilulungan']['role']==2) $stat .= " AND current_stat=5";

            //kategori
            if($kategori && !$dari && !$sampai && !$skpd){
                if($kategori=='all') $where .= "$stat";
                else $where .= "WHERE type_id = $kategori AND $stat";
            }elseif($kategori && $dari && !$sampai && !$skpd){
                if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND $stat";
                else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND $stat";
            }elseif($kategori && !$dari && $sampai && !$skpd){
                if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai' AND $stat";
            }elseif($kategori && !$dari && !$sampai && $skpd){
                if($kategori=='all' AND $skpd=='all') $where .= "$stat";
                elseif($kategori!='all' AND $skpd=='all') $where .= "WHERE type_id = $kategori AND $stat";
                elseif($kategori=='all' AND $skpd!='all') $where .= "WHERE skpd_id = $skpd AND $stat";
                else $where .= "WHERE type_id = $kategori AND skpd_id = $skpd AND $stat";
            }                        

            //dari
            elseif(!$kategori && $dari && !$sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari' AND $stat";
            elseif(!$kategori && $dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND $stat";
            elseif(!$kategori && $dari && !$sampai && $skpd){
                if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND $stat";
                else $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd AND $stat";
            }

            //sampai
            elseif(!$kategori && !$dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) <= '$sampai' AND $stat";
            elseif(!$kategori && !$dari && $sampai && $skpd){
                if($skpd=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd AND $stat";
            }

            //skpd
            elseif(!$kategori && !$dari && !$sampai && $skpd){
                if($skpd=='all') $where .= "$stat";
                else $where .= "WHERE skpd_id = $skpd AND $stat";
            }

            //mixed
            elseif($kategori && $dari && $sampai && !$skpd){
                if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND $stat";
            }elseif(!$kategori && $dari && $sampai && $skpd){
                if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND $stat";
                else $where .= "WHERE skpd_id = $skpd AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND $stat";
            }elseif($kategori && $dari && !$sampai && $skpd){
                if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd AND $stat";
                else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND skpd_id = $skpd AND $stat";
            }elseif($kategori && !$dari && $sampai && $skpd){
                if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd AND $stat";
                else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd AND $stat";
            }elseif($kategori && $dari && $sampai && $skpd){
                if($kategori=='all' && $skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND $stat";
                elseif($kategori!='all' && $skpd=='all') $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND $stat";
                elseif($kategori=='all' && $skpd!='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd AND $stat";
                else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd AND $stat";
            }

            $Qlist = $db->query("SELECT id, name, address, judul, current_stat, nphd, tanggal_lpj FROM proposal $where ORDER BY id DESC LIMIT $position,$limit")->getResult();           
        }else{
            //Query List
            $walikota = array(1,6); $pertimbangan = array(2,4);
            
            $builder = $db->table('proposal');
            $builder->select("id, name, address, judul, current_stat, nphd, tanggal_lpj");
            if (isset($_POST['keyword'])) {
                $builder->like('judul', $_POST['keyword']);
            }
            $builder->orderBy('id', 'DESC');
            $builder->limit($limit, $position);

            if($_SESSION['sabilulungan']['role'] == 5) {
                $builder->where('current_stat', null);
            } elseif($_SESSION['sabilulungan']['role'] == 1) {
                $builder->whereIn('current_stat', $walikota);
            } elseif($_SESSION['sabilulungan']['role'] == 4) {
                $builder->whereIn('current_stat', $pertimbangan);
            } elseif($_SESSION['sabilulungan']['role'] == 3) {
                $builder->where('current_stat', 3);
                $builder->where('skpd_id', $_SESSION['sabilulungan']['skpd']);
            } elseif($_SESSION['sabilulungan']['role'] == 2) {
                $builder->where('current_stat', 5);
            } elseif($_SESSION['sabilulungan']['role'] == 7 || $_SESSION['sabilulungan']['role'] == 9) {
                // No additional conditions
            }

            $Qlist = $builder->get()->getResult();
        }

        if(count($Qlist)){
            foreach($Qlist as $list){
                $Qmohon = $db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$list->id'"); 
                $mohon = $Qmohon->getResult();  

                $Qbesar = $db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$list->id' AND checklist_id IN (26,28)"); $besar = $Qbesar->getResult();

                echo '<tr>
                        <td>'; if($_SESSION['sabilulungan']['role']==9) echo '<a href="'.site_url('hibah/edit/'.$list->id).'">'.$list->judul.'</a>'; else echo '<a href="'.site_url('detail/'.$list->id).'">'.$list->judul.'</a>'; echo '</td>
                        <td>Rp. '.number_format($mohon[0]->mohon,0,",",".").',-</td>
                        <td>'; if(isset($besar[0]->value)) echo 'Rp. '.number_format($besar[0]->value,0,",",".").',-'; else echo '-'; echo '</td>
                        <td>'; if(isset($besar[1]->value)) echo 'Rp. '.number_format($besar[1]->value,0,",",".").',-'; else echo '-'; echo '</td>';

                        if($list->current_stat==0 && $_SESSION['sabilulungan']['role']==5 || $list->current_stat==0 && $_SESSION['sabilulungan']['role']==7 || $list->current_stat==0 && $_SESSION['sabilulungan']['role']==9){
                            $approvalExists = $db->table('proposal_approval')
                                        ->where('flow_id', $list->current_stat+1)
                                        ->where('action', 2)
                                        ->countAllResults();

                                    if($approvalExists) {
                                        echo '<td style="text-align:center; "><a class="link-red" style="color:red;" href="'.site_url('tatausaha/periksa/'.$list->id).'">DITOLAK</a></td>';
                                    } else {
                                        echo '<td style="text-align:center"><a href="'.site_url('tatausaha/periksa/'.$list->id).'">PROSES</a></td>';
                                    }
                            $status = !empty($approvalExists) ? 'PROSES DIHENTIKAN' : 'PROSES';

                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            if($_SESSION['sabilulungan']['role']==7 || $_SESSION['sabilulungan']['role']==9){
                                if($_SESSION['sabilulungan']['role']==9){
                                    echo '<td style="text-align:center">'; 
                                    
                                    if(isset($list->nphd)) echo '<a href="'.site_url('admin/edit/'.$list->id).'">EDIT</a>'; 
                                    
                                    else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';

                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a href="'.site_url('admin/view/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }else{
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }
                            }
                            if($_SESSION['sabilulungan']['role']==9) echo '<td style="text-align:center"><a href="'.site_url('detil/edit/'.$list->id).'">EDIT</a></td>';
                            else echo '<td style="text-align:center"><a href="'.site_url('detil/proposal/'.$list->id).'">LIHAT</a></td>';
                        }

                        elseif($list->current_stat==1 && $_SESSION['sabilulungan']['role']==1 || $list->current_stat==1 && $_SESSION['sabilulungan']['role']==7 || $list->current_stat==1 && $_SESSION['sabilulungan']['role']==9){
                            if($_SESSION['sabilulungan']['role']==9){
                                echo '<td style="text-align:center"><a href="'.site_url('tatausaha/edit/'.$list->id).'">EDIT</a></td>';
                            }else{
                                $Qstat = $db->query("SELECT action FROM proposal_approval WHERE `proposal_id`='$list->id'");

                                foreach($Qstat->getResult() as $stat){
                                    if($stat->action==1) $status = '<a style="color:#00923f;cursor:text">DISETUJUI</a>'; elseif($stat->action==2) $status = '<a style="color:#F00;cursor:text">DITOLAK</a>';

                                    echo '<td style="text-align:center">'.$status.'</td>';
                                }
                            }
                            $approvalExists = $db->table('proposal_approval')
                                        ->where('flow_id', $list->current_stat+1)
                                        ->where('action', 2)
                                        ->countAllResults();

                                    if($approvalExists) {
                                        echo '<td style="text-align:center; "><a class="link-red" style="color:red;" href="'.site_url('walikota/periksa/'.$list->id).'">DITOLAK</a></td>';
                                    } else {
                                        echo '<td style="text-align:center"><a href="'.site_url('walikota/periksa/'.$list->id).'">PROSES</a></td>';
                                    }
                            
                            $status = !empty($approvalExists) ? 'PROSES DIHENTIKAN' : 'PROSES';

                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            if($_SESSION['sabilulungan']['role']==7 || $_SESSION['sabilulungan']['role']==9){
                                if($_SESSION['sabilulungan']['role']==9){
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a href="'.site_url('admin/edit/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a href="'.site_url('admin/view/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }else{
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }
                            }
                            if($_SESSION['sabilulungan']['role']==9) echo '<td style="text-align:center"><a href="'.site_url('detil/edit/'.$list->id).'">EDIT</a></td>';
                            else echo '<td style="text-align:center"><a href="'.site_url('detil/proposal/'.$list->id).'">LIHAT</a></td>';
                        }

                        elseif($list->current_stat==2 && $_SESSION['sabilulungan']['role']==4 || $list->current_stat==2 && $_SESSION['sabilulungan']['role']==7 || $list->current_stat==2 && $_SESSION['sabilulungan']['role']==9){
                            if($_SESSION['sabilulungan']['role']==9){
                                echo '<td style="text-align:center"><a href="'.site_url('tatausaha/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('walikota/edit/'.$list->id).'">EDIT</a></td>';
                            }else{
                                $Qstat = $db->query("SELECT action FROM proposal_approval WHERE `proposal_id`='$list->id'");

                                foreach($Qstat->getResult() as $stat){
                                    if($stat->action==1) $status = '<a style="color:#00923f;cursor:text">DISETUJUI</a>'; elseif($stat->action==2) $status = '<a style="color:#F00;cursor:text">DITOLAK</a>';

                                    echo '<td style="text-align:center">'.$status.'</td>';
                                }
                            }
                            $approvalExists = $db->table('proposal_approval')
                                        ->where('flow_id', $list->current_stat+1)
                                        ->where('action', 2)
                                        ->countAllResults();

                                    if($approvalExists) {
                                        echo '<td style="text-align:center; "><a class="link-red" style="color:red;" href="'.site_url('pertimbangan/periksa/'.$list->id).'">DITOLAK</a></td>';
                                    } else {
                                        echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/periksa/'.$list->id).'">PROSES</a></td>';
                                    }
                            $status = !empty($approvalExists) ? 'PROSES DIHENTIKAN' : 'PROSES';

                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            if($_SESSION['sabilulungan']['role']==7 || $_SESSION['sabilulungan']['role']==9){
                                if($_SESSION['sabilulungan']['role']==9){
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a href="'.site_url('admin/edit/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">PROSES</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a href="'.site_url('admin/view/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }else{
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">PROSES</a>'; echo '</td>';
                                }
                            }
                            if($_SESSION['sabilulungan']['role']==9) echo '<td style="text-align:center"><a href="'.site_url('detil/edit/'.$list->id).'">EDIT</a></td>';
                            else echo '<td style="text-align:center"><a href="'.site_url('detil/proposal/'.$list->id).'">LIHAT</a></td>';
                        }

                        elseif($list->current_stat==3 && $_SESSION['sabilulungan']['role']==3 || $list->current_stat==3 && $_SESSION['sabilulungan']['role']==7 || $list->current_stat==3 && $_SESSION['sabilulungan']['role']==9){
                            if($_SESSION['sabilulungan']['role']==9){
                                echo '<td style="text-align:center"><a href="'.site_url('tatausaha/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('walikota/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/edit/'.$list->id).'">EDIT</a></td>';
                            }else{
                                $Qstat = $db->query("SELECT action FROM proposal_approval WHERE `proposal_id`='$list->id'");

                                foreach($Qstat->getResult() as $stat){
                                    if($stat->action==1) $status = '<a style="color:#00923f;cursor:text">DISETUJUI</a>'; elseif($stat->action==2) $status = '<a style="color:#F00;cursor:text">DITOLAK</a>';

                                    echo '<td style="text-align:center">'.$status.'</td>';
                                }
                            }
                            $approvalExists = $db->table('proposal_approval')
                                        ->where('flow_id', $list->current_stat+1)
                                        ->where('action', 2)
                                        ->countAllResults();

                                    if($approvalExists) {
                                        echo '<td style="text-align:center; "><a class="link-red" style="color:red;" href="'.site_url('skpd/periksa/'.$list->id).'">DITOLAK</a></td>';
                                    } else {
                                        echo '<td style="text-align:center"><a href="'.site_url('skpd/periksa/'.$list->id).'">PROSES</a></td>';
                                    }
                            
                            $status = !empty($approvalExists) ? 'PROSES DIHENTIKAN' : 'PROSES';

                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            echo '<td style="text-align:center">'.$status.'</td>';
                            if($_SESSION['sabilulungan']['role']==7 || $_SESSION['sabilulungan']['role']==9){
                                if($_SESSION['sabilulungan']['role']==9){
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a href="'.site_url('admin/edit/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a href="'.site_url('admin/view/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }else{
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }
                            }
                            if($_SESSION['sabilulungan']['role']==9) echo '<td style="text-align:center"><a href="'.site_url('detil/edit/'.$list->id).'">EDIT</a></td>';
                            else echo '<td style="text-align:center"><a href="'.site_url('detil/proposal/'.$list->id).'">LIHAT</a></td>';
                        }

                        elseif($list->current_stat==4 && $_SESSION['sabilulungan']['role']==4 || $list->current_stat==4 && $_SESSION['sabilulungan']['role']==7 || $list->current_stat==4 && $_SESSION['sabilulungan']['role']==9){
                            if($_SESSION['sabilulungan']['role']==9){
                                echo '<td style="text-align:center"><a href="'.site_url('tatausaha/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('walikota/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('skpd/edit/'.$list->id).'">EDIT</a></td>';
                            }else{
                                $Qstat = $db->query("SELECT action FROM proposal_approval WHERE `proposal_id`='$list->id'");

                                foreach($Qstat->getResult() as $stat){
                                    if($stat->action==1) $status = '<a style="color:#00923f;cursor:text">DISETUJUI</a>'; elseif($stat->action==2) $status = '<a style="color:#F00;cursor:text">DITOLAK</a>';

                                    echo '<td style="text-align:center">'.$status.'</td>';
                                }
                            }
                            $approvalExists = $db->table('proposal_approval')
                                        ->where('flow_id', $list->current_stat+1)
                                        ->where('action', 2)
                                        ->countAllResults();

                                    if($approvalExists) {
                                        echo '<td style="text-align:center; "><a class="link-red" style="color:red;" href="'.site_url('pertimbangan/verifikasi/'.$list->id).'">DITOLAK</a></td>';
                                    } else {
                                        echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/verifikasi/'.$list->id).'">PROSES</a></td>';
                                    }
                            echo '<td style="text-align:center">PROSES</td>';
                            echo '<td style="text-align:center">PROSES</td>';
                            if($_SESSION['sabilulungan']['role']==7 || $_SESSION['sabilulungan']['role']==9){
                                if($_SESSION['sabilulungan']['role']==9){
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a href="'.site_url('admin/edit/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a href="'.site_url('admin/view/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }else{
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }
                            }
                            if($_SESSION['sabilulungan']['role']==9) echo '<td style="text-align:center"><a href="'.site_url('detil/edit/'.$list->id).'">EDIT</a></td>';
                            else echo '<td style="text-align:center"><a href="'.site_url('detil/proposal/'.$list->id).'">LIHAT</a></td>';
                        }

                        elseif($list->current_stat==5 && $_SESSION['sabilulungan']['role']==2 || $list->current_stat==5 && $_SESSION['sabilulungan']['role']==7 || $list->current_stat==5 && $_SESSION['sabilulungan']['role']==9){
                            if($_SESSION['sabilulungan']['role']==9){
                                echo '<td style="text-align:center"><a href="'.site_url('tatausaha/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('walikota/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('skpd/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/view/'.$list->id).'">EDIT</a></td>';
                            }else{
                                $Qstat = $db->query("SELECT action FROM proposal_approval WHERE `proposal_id`='$list->id'");

                                foreach($Qstat->getResult() as $stat){
                                    if($stat->action==1) $status = '<a style="color:#00923f;cursor:text">DISETUJUI</a>'; elseif($stat->action==2) $status = '<a style="color:#F00;cursor:text">DITOLAK</a>';

                                    echo '<td style="text-align:center">'.$status.'</td>';
                                }
                            }
                            $approvalExists = $db->table('proposal_approval')
                                        ->where('flow_id', $list->current_stat+1)
                                        ->where('action', 2)
                                        ->countAllResults();

                                    if($approvalExists) {
                                        echo '<td style="text-align:center; "><a class="link-red" style="color:red;" href="'.site_url('tapd/verifikasi/'.$list->id).'">DITOLAK</a></td>';
                                    } else {
                                        echo '<td style="text-align:center"><a href="'.site_url('tapd/verifikasi/'.$list->id).'">PROSES</a></td>';
                                    }
                            
                            echo '<td style="text-align:center">PROSES</td>';
                            if($_SESSION['sabilulungan']['role']==7 || $_SESSION['sabilulungan']['role']==9){
                                if($_SESSION['sabilulungan']['role']==9){
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a href="'.site_url('admin/edit/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a href="'.site_url('admin/view/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }else{
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }
                            }
                            if($_SESSION['sabilulungan']['role']==9) echo '<td style="text-align:center"><a href="'.site_url('detil/edit/'.$list->id).'">EDIT</a></td>';
                            else echo '<td style="text-align:center"><a href="'.site_url('detil/proposal/'.$list->id).'">LIHAT</a></td>';
                        }

                        elseif($list->current_stat==6 && $_SESSION['sabilulungan']['role']==1 || $list->current_stat==6 && $_SESSION['sabilulungan']['role']==7 || $list->current_stat==6 && $_SESSION['sabilulungan']['role']==9){
                            if($_SESSION['sabilulungan']['role']==9){
                                echo '<td style="text-align:center"><a href="'.site_url('tatausaha/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('walikota/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('skpd/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/view/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('tapd/edit/'.$list->id).'">EDIT</a></td>';
                            }else{
                                $Qstat = $db->query("SELECT action FROM proposal_approval WHERE `proposal_id`='$list->id'");

                                foreach($Qstat->getResult() as $stat){
                                    if($stat->action==1) $status = '<a style="color:#00923f;cursor:text">DISETUJUI</a>'; elseif($stat->action==2) $status = '<a style="color:#F00;cursor:text">DITOLAK</a>';

                                    echo '<td style="text-align:center">'.$status.'</td>';
                                }
                            }
                            $approvalExists = $db->table('proposal_approval')
                            ->where('flow_id', $list->current_stat+1)
                            ->where('action', 2)
                            ->countAllResults();

                        if($approvalExists) {
                            echo '<td style="text-align:center; "><a class="link-red" style="color:red;" href="'.site_url('walikota/setuju/'.$list->id).'">DITOLAK</a></td>';
                        } else {
                            echo '<td style="text-align:center"><a href="'.site_url('walikota/setuju/'.$list->id).'">PROSES</a></td>';
                        }
                        $status = !empty($approvalExists) ? 'PROSES DIHENTIKAN' : 'PROSES';
                            
                            if($_SESSION['sabilulungan']['role']==7 || $_SESSION['sabilulungan']['role']==9){
                                if($_SESSION['sabilulungan']['role']==9){
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a href="'.site_url('admin/edit/'.$list->id).'">EDIT</a>'; else 
                                    echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) 
                                    echo '<a href="'.site_url('admin/view/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }else{
                                    echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                    echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">'.$status.'</a>'; echo '</td>';
                                }
                            }
                            if($_SESSION['sabilulungan']['role']==9) echo '<td style="text-align:center"><a href="'.site_url('detil/edit/'.$list->id).'">EDIT</a></td>';
                            else echo '<td style="text-align:center"><a href="'.site_url('detil/proposal/'.$list->id).'">LIHAT</a></td>';
                        }

                        elseif($list->current_stat==7 && $_SESSION['sabilulungan']['role']==7 || $list->current_stat==7 && $_SESSION['sabilulungan']['role']==9){
                            if($_SESSION['sabilulungan']['role']==9){
                                echo '<td style="text-align:center"><a href="'.site_url('tatausaha/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('walikota/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('skpd/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('pertimbangan/view/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('tapd/edit/'.$list->id).'">EDIT</a></td>';
                                echo '<td style="text-align:center"><a href="'.site_url('walikota/view/'.$list->id).'">EDIT</a></td>';
                            }else{
                                $Qstat = $db->query("SELECT action FROM proposal_approval WHERE `proposal_id`='$list->id'");

                                foreach($Qstat->getResult() as $stat){
                                    if($stat->action==1) $status = '<a style="color:#00923f;cursor:text">DISETUJUI</a>'; elseif($stat->action==2) $status = '<a style="color:#F00;cursor:text">DITOLAK</a>';

                                    echo '<td style="text-align:center">EDIT</td>';
                                }
                            }
                            if($_SESSION['sabilulungan']['role']==9){
                                echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a href="'.site_url('admin/edit/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">EDIT</a>'; echo '</td>';
                                echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a href="'.site_url('admin/view/'.$list->id).'">EDIT</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">PROSES</a>'; echo '</td>';
                            }else{
                                echo '<td style="text-align:center">'; if(isset($list->nphd)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/nphd/'.$list->id).'">PROSES</a>'; echo '</td>';
                                echo '<td style="text-align:center">'; if(isset($list->tanggal_lpj)) echo '<a style="color:#00923f;cursor:text">SELESAI</a>'; else echo '<a href="'.site_url('admin/lpj/'.$list->id).'">PROSES</a>'; echo '</td>';
                            }
                            if($_SESSION['sabilulungan']['role']==9) echo '<td style="text-align:center"><a href="'.site_url('detil/edit/'.$list->id).'">EDIT</a></td>';
                            else echo '<td style="text-align:center"><a href="'.site_url('detil/proposal/'.$list->id).'">LIHAT</a></td>';
                        }

                echo '</tr>';
            }
        }else echo '<tr><td align="center" colspan="12">No data.</td></tr>';
        echo '</tbody></table>';

        if(isset($_POST['search'])){
            $session = \Config\Services::session();
            $request = \Config\Services::request();

            $walikota = [1,6]; 
            $pertimbangan = [2,4];
            $keyword = $request->getPost('keyword');

            if($session->get('sabilulungan')['role'] == 5) {
                $Qpaging = $db->table('proposal')->select("id")->like('judul', $keyword)->where('current_stat', null)->get()->getResult();
            } elseif($session->get('sabilulungan')['role'] == 1) {
                $Qpaging = $db->table('proposal')->select("id")->like('judul', $keyword)->whereIn('current_stat', $walikota)->get()->getResult();
            } elseif($session->get('sabilulungan')['role'] == 4) {
                $Qpaging = $db->table('proposal')->select("id")->like('judul', $keyword)->whereIn('current_stat', $pertimbangan)->get()->getResult();
            } elseif($session->get('sabilulungan')['role'] == 3) {
                $Qpaging = $db->table('proposal')->select("id")->like('judul', $keyword)->where('current_stat', 3)->get()->getResult();
            } elseif($session->get('sabilulungan')['role'] == 2) {
                $Qpaging = $db->table('proposal')->select("id")->like('judul', $keyword)->where('current_stat', 5)->get()->getResult();
            } elseif(in_array($session->get('sabilulungan')['role'], [7, 9])) {
                $Qpaging = $db->table('proposal')->select("id")->like('judul', $keyword)->get()->getResult();
            }
        }else{
            $walikota = array(1,6); $pertimbangan = array(2,4);
            
            $builder = $db->table('proposal');
            $builder->select("id");

            if($_SESSION['sabilulungan']['role'] == 5) {
                $builder->where('current_stat', null);
            } elseif($_SESSION['sabilulungan']['role'] == 1) {
                $builder->whereIn('current_stat', $walikota);
            } elseif($_SESSION['sabilulungan']['role'] == 4) {
                $builder->whereIn('current_stat', $pertimbangan);
            } elseif($_SESSION['sabilulungan']['role'] == 3) {
                $builder->where('current_stat', 3);
            } elseif($_SESSION['sabilulungan']['role'] == 2) {
                $builder->where('current_stat', 5);
            } elseif($_SESSION['sabilulungan']['role'] == 7 || $_SESSION['sabilulungan']['role'] == 9) {
                // No additional conditions
            }

            $Qpaging = $builder->get()->getResult();
            
        } 

        $num_page = ceil(count($Qpaging) / $limit);
        if(count($Qpaging) > $limit){
            $this->ifunction->paging($p, site_url('report').'/', $num_page, count($Qpaging), 'href', false);
        }
        ?>
    </div>
    <!-- wrapper -->
</div>
<!-- content-main -->
<?= $this->endSection(); ?>