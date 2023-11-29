<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>


<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper">
        <h1 class="page-title page-title-border">Laporan Hibah Bansos</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>
        <!-- Filter -->
        <form action="<?php echo site_url('tapd-report') ?>" method="post" class="form-check form-global">
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
        <div style="float: left;">
            <!-- Search -->
            <div class="form-search-wrapper-alt">
                <form class="form-search form-search-large clearfix" action="<?php echo site_url('tapd-report') ?>" method="post">
                    <input type="text" name="keyword" placeholder="Search Nama">
                    <button name="search" class="btn-ir" type="submit">Search</button>
                </form>
            </div>        
        </div>
        <div style="float: right;">
            <a href="<?php echo site_url('pdf/export/report/3/'.$userid) ?>" target="_blank" class="btn-red btn-plain btn">Download</a>
        </div>

        <!-- Clear float -->
        <div style="clear: both;"></div>

        <table class="table-global">
        <?php
        echo '<thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th style="text-align:center;">Nama Calon Penerima Hibah</th>
                <th style="text-align:center;">Uraian Usulan</th>
                <th style="text-align:center;">Jumlah</th>
                <th style="text-align:center;">Besaran / Nilai Hibah Yang Disetujui</th>
            </tr>
            <tr>
                <th style="text-align:center;">1</th>
                <th style="text-align:center;">2</th>
                <th style="text-align:center;">3</th>
                <th style="text-align:center;">4</th>
                <th style="text-align:center;">5</th>
            </tr>
        </thead>';
        ?>        
        <tbody>
            <?php
            if(count($Qlist)){
                $no=1;
                foreach($Qlist as $row){
                    echo '<tr>
                        <td style="text-align:center;">'.$no.'</td>
                        <td>'.$row->name.'</td>
                        <td>'.$row->maksud_tujuan.'</td>
                        <td style="text-align:center;">Rp.'.number_format($row->total_amount, 0, ',', '.').'</td>
                        <td style="text-align:center;">Rp. '.number_format($row->value, 0, ',', '.').'</td>
                    </tr>';
                    $no++;
                }
                ?>
                <?php
            }else echo '<tr><td align="center" colspan="12">No data.</td></tr>';
                echo '</tbody></table>';
                ?>
        </tbody>
        </table>

    </div>
    <!-- wrapper -->
</div>
<!-- content-main -->
<?= $this->endSection(); ?>