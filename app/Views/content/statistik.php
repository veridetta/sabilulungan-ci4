<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper">
        <form action="<?php echo site_url('statistik') ?>" method="post" class="form-check form-global">
        <h1 class="page-title page-title-border">Statistik</h1>
        <div class="form-global">
            <div class="date-search clearfix">
                <div class="control-group">
                    <label class="control-label control-label-inline" for="">Tahun: </label>
                    <input id="datepicker-from" type="text" name="tahun" value="<?php if(isset($_POST['tahun'])) echo $_POST['tahun']; ?>">
                </div>
                <div class="control-actions">
                    <input name="rekap" class="btn-red btn-plain btn" type="submit" value="Lihat">
                </div>
            </div>
        </form>

        <?php   
        $limit = 30;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $db->_protect_identifiers=false;
        ?>

        <table class="table-global">
            <thead>
                <tr>
                    <th rowspan="2" width="50">No.</th>
                    <th rowspan="2">SKPD</th>
                    <th rowspan="2">Nilai Proposal</th>
                    <th rowspan="2">Nilai Penyetujuan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $db->table('skpd')->select("id, name")->orderBy('id', 'ASC')->limit($limit, $position)->get()->getResult();

                if(count($Qlist)){
                    $i = 1;
                    foreach($Qlist as $list){
                        if(isset($_POST['rekap'])){
                            $tahun = $_POST['tahun'];
                            $Qmohon = $db->query("SELECT a.skpd_id, SUM(b.amount) AS mohon, SUM(b.correction) AS setuju
                                                FROM proposal a
                                                JOIN proposal_dana b ON b.proposal_id=a.id
                                                WHERE a.skpd_id='$list->id' AND YEAR(a.time_entry)='$tahun'");                            
                        }else $Qmohon = $db->query("SELECT a.skpd_id, SUM(b.amount) AS mohon, SUM(b.correction) AS setuju
                                                FROM proposal a
                                                JOIN proposal_dana b ON b.proposal_id=a.id
                                                WHERE a.skpd_id='$list->id'");

                        $mohon = $Qmohon->getResult();

                        echo '<tr>
                                <td style="text-align:center">'.$i.'</td>
                                <td>'.$list->name.'</td>
                                <td>'; if(isset($mohon[0]->mohon)) echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-'; else echo '-'; echo '</td>
                                <td>'; if(isset($mohon[0]->setuju)) echo 'Rp. '.number_format($mohon[0]->setuju,0,",",".").',-'; else echo '-'; echo '</td>
                            </tr>';
                        $i++;
                    }
                }else echo '<tr><td colspan="3">No data.</td></tr>';
                ?>
            </tbody>
        </table>

        <?php
        $Qpaging = $db->table('skpd')->select("id")->orderBy('id', 'ASC')->get()->getResult();

        $num_page = ceil(count($Qpaging) / $limit);
        if(count($Qpaging) > $limit){
            $this->ifunction->paging($p, site_url('statistik').'/', $num_page, count($Qpaging), 'href', false);
        }
        ?>
        </div>
    </div>
    <!-- wrapper -->
</div>
<!-- content-main -->
<?= $this->endSection(); ?>