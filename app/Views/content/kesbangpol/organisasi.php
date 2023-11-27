<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">            
        <ul class="nav-project list-nostyle clearfix">
            <li class="active">
                <?php if($_SESSION['sabilulungan']['role'] == 10) { ?>
                <a class="btn" href="<?php echo site_url('add_organisasi'); ?>">+ Tambah</a>
                <?php } ?>
            </li>
        </ul>

        <div class="project-detail-wrapper">
            <?php
            if(isset($_SESSION['notify'])){
                echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
                unset($_SESSION['notify']);
            }            
            ?>

            <h1 class="page-title">Organisasi Legal</h1>
            <div class="form-search-wrapper">
                <form class="form-search form-search-small clearfix" action="<?php echo site_url('organisasi') ?>" method="post">
                    <input type="text" name="keyword" value="<?= $q;?>" placeholder="Cari Organisasi">
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
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telp</th>
                        <th>Status</th>
                        <?php if($_SESSION['sabilulungan']['role']== 10) { ?>
                            <th width="100">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($q){
                        $Qlist = $db->query("SELECT a.id, a.name, a.legal, a.address, a.phone FROM organisasi a WHERE a.name LIKE ? ORDER BY a.name ASC LIMIT $position,$limit", ['%'.$q.'%'])->getResult();
                    }else{
                        $Qlist = $db->query("SELECT a.id, a.name, a.legal, a.address, a.phone FROM organisasi a ORDER BY a.name ASC LIMIT $position,$limit")->getResult();
                    }

                    if(count($Qlist)){
                        $i = ($p*15)-14;
                        foreach($Qlist as $list){
                            echo '<tr>
                                    <td style="text-align: center;">'.$i.'</td>
                                    <td>'.$list->name.'</td>
                                    <td>'.$list->address.'</td>
                                    <td>'.$list->phone.'</td>
                                    <td style="text-align: center;">'; if($list->legal==1) echo 'Aktif'; else echo 'Tidak Aktif'; echo '</td>';
                                    if($_SESSION['sabilulungan']['role'] == 10) { 
                                        echo '<td style="text-align: center;"><a href="'.site_url('edit_organisasi/'.$list->id).'">Edit</a> | <a href="'.base_url('delete_organisasi/'.$list->id).'" onclick="return confirm(\'Apakah Anda yakin akan menghapus Organisasi ini ?\');">Hapus</a></td>';
                                    }
                                echo '</tr>';
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>   

            <?php
            if($q){
                $Qpaging = $db->query("SELECT a.id, a.name, a.legal, a.address, a.phone FROM organisasi a WHERE a.name LIKE ? ", ['%'.$q.'%'])->getResult();
            }else{
                $Qpaging = $db->query("SELECT a.id, a.name, a.legal, a.address, a.phone FROM organisasi a ")->getResult();
            }

            $num_page = ceil(count($Qpaging) / $limit);
            if(count($Qpaging) > $limit){
                $ifunction->paging($p, site_url('organisasi').'/'.$tp.'/', $num_page, count($Qpaging), 'href', false);
            }
            ?>             
        </div>
    <!-- project-detail-wrapper -->
    </div>
</div>
<?= $this->endSection(); ?>