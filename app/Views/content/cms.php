<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
<div class="wrapper clearfix">
    <aside class="sidebar">
    <div class="widget-side">
        <h2>Manajemen Pengguna</h2>
        <ul class="category-list list-nostyle">            
            <li><a href="<?php echo site_url('cms/koordinator'); ?>">Koordinator</a></li>   
            <li><a href="<?php echo site_url('cms/umum'); ?>">Umum</a></li>                     
        </ul>
    </div>
    <!-- widget-side -->
    <div class="widget-side">
        <h2>Manajemen Konten</h2>
        <ul class="category-list list-nostyle">
            <li><a href="<?php echo site_url('cms/home'); ?>">Home</a></li>   
            <li><a href="<?php echo site_url('cms/tentang'); ?>">Tentang Sabilulungan</a></li> 
            <li><a href="<?php echo site_url('cms/peraturan'); ?>">Peraturan</a></li>
            <li><a href="<?php echo site_url('cms/pengumuman'); ?>">Pengumuman</a></li>
        </ul>
    </div>
    <!-- widget-side -->
    <div class="widget-side nav-filter">
        <h2><a href="<?php echo site_url('cms/log'); ?>">Log Pengguna</a></h2>
    </div>
</aside>
<!-- sidebar -->

<?php
switch($tp){

case 'koordinator':
?>

<div class="primary">            
    <ul class="nav-project list-nostyle clearfix">
        <li class="active">
            <a class="btn" href="<?php echo site_url('cms/add_koordinator'); ?>">+ Tambah</a>
        </li>
    </ul>

    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <h1 class="page-title">Koordinator</h1>

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
                    <th>Role</th>
                    <th>Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $db->query("SELECT a.id, a.name, b.name AS role, a.is_active FROM user a JOIN role b ON b.id=a.role_id WHERE a.role_id!='6' ORDER BY a.role_id ASC LIMIT $position,$limit")->getResult();

                if(count($Qlist)){
                    $i = ($p*15)-14;
                    foreach($Qlist as $list){
                        echo '<tr>
                                <td style="text-align: center;">'.$i.'</td>
                                <td>'.$list->name.'</td>
                                <td>'.$list->role.'</td>
                                <td style="text-align: center;">'; if($list->is_active==1) echo 'Aktif'; else echo 'Tidak Aktif'; echo '</td>
                                <td style="text-align: center;"><a href="'.site_url('cms/edit_koordinator/'.$list->id).'">Edit</a> | <a href="'.base_url('process/cms/delete_koordinator/'.$list->id).'" onclick="return confirm(\'Apakah Anda yakin akan menghapus Koordinator ini ?\');">Hapus</a></td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $db->query("SELECT a.name, b.name AS role, a.is_active FROM user a JOIN role b ON b.id=a.role_id WHERE a.role_id!='6'")->getResult();

        $num_page = ceil(count($Qpaging) / $limit);
        if(count($Qpaging) > $limit){
            $ifunction->paging($p, site_url('cms').'/'.$tp.'/', $num_page, count($Qpaging), 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'add_koordinator':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/add_koordinator') ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Tambah Koordinator</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Role</label>
                    <div class="controls">
                        <select name="role" onchange="dochange('role', this.value)">
                        <option value="0">-- Silahkan Pilih</option>
                        <?php
                        $Qkategori = $db->table('role')->select("id, name")->where('id !=', 6)->orderBy('id', 'ASC')->get();

                        foreach($Qkategori->getResult() as $kategori){
                            echo '<option value="'.$kategori->id.'">'.$kategori->name.'</option>';
                        }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="control-group" id="role"></div>

                <div class="control-group">
                    <label class="control-label" for="">Nama</label>
                    <div class="controls">
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Username</label>
                    <div class="controls">
                        <input type="text" name="uname">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Password</label>
                    <div class="controls">
                        <input type="password" name="pswd">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Ulangi Password</label>
                    <div class="controls">
                        <input type="password" name="repswd">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <div class="controls">
                        <label><input type="radio" name="status" value="1" checked> Ya</label> &nbsp <label><input type="radio" name="status" value="0"> Tidak</label>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Tambah" />
                <a href="<?php echo site_url('cms/koordinator') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'edit_koordinator':

$Qedit = $db->query("SELECT role_id, name, username, skpd_id, is_active FROM user WHERE `id`='$p'"); $edit = $Qedit->getResult();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/edit_koordinator/'.$p) ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Edit Koordinator</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Role</label>
                    <div class="controls">
                        <select name="role" onchange="dochange('role', this.value)">
                        <option value="0">-- Silahkan Pilih</option>
                        <?php
                        $Qkategori = $db->table('role')->select("id, name")->where('id !=', 6)->orderBy('id', 'ASC')->get();

                        foreach($Qkategori->getResult() as $kategori){
                            echo '<option value="'.$kategori->id.'"'; if($edit[0]->role_id==$kategori->id) echo ' selected'; echo '>'.$kategori->name.'</option>';
                        }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="control-group" id="role">
                <?php
                if($edit[0]->skpd_id){
                    echo '<label class="control-label" for="">SKPD</label>
                            <div class="controls">
                                <select name="skpd">
                                <option value="0">-- Silahkan Pilih</option>';

                                $Qkategori = $db->table('skpd')->select("id, name")->orderBy('id', 'ASC')->get();

                                foreach($Qkategori->getResult() as $kategori){
                                    echo '<option value="'.$kategori->id.'"'; if($edit[0]->skpd_id==$kategori->id) echo ' selected'; echo '>'.$kategori->name.'</option>';
                                }

                                echo '</select>
                            </div>';
                }
                ?>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Nama</label>
                    <div class="controls">
                        <input type="text" name="name" value="<?php echo $edit[0]->name ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Username</label>
                    <div class="controls">
                        <input type="text" name="uname" value="<?php echo $edit[0]->username ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Password</label>
                    <div class="controls">
                        <input type="password" name="pswd">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Ulangi Password</label>
                    <div class="controls">
                        <input type="password" name="repswd">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <div class="controls">
                        <label><input type="radio" name="status" value="1" <?php if($edit[0]->is_active==1) echo ' checked'; ?>> Ya</label> &nbsp <label><input type="radio" name="status" value="0" <?php if($edit[0]->is_active==0) echo ' checked'; ?>> Tidak</label>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
                <a href="<?php echo site_url('cms/koordinator') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'umum':
?>

<div class="primary">            
    <ul class="nav-project list-nostyle clearfix">
        <li class="active">
            <a class="btn" href="<?php echo site_url('cms/add_umum'); ?>">+ Tambah</a>
        </li>
    </ul>

    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <h1 class="page-title">Umum</h1>

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
                    <th>Email</th>
                    <th>Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $db->query("SELECT id, name, email, is_active FROM user WHERE role_id='6' ORDER BY id DESC LIMIT $position,$limit")->getResult();

                if(($Qlist)){
                    $i = ($p*15)-14;
                    foreach($Qlist as $list){
                        echo '<tr>
                                <td style="text-align: center;">'.$i.'</td>
                                <td>'.$list->name.'</td>
                                <td>'.$list->email.'</td>
                                <td style="text-align: center;">'; if($list->is_active==1) echo 'Aktif'; else echo 'Tidak Aktif'; echo '</td>
                                <td style="text-align: center;"><a href="'.site_url('cms/edit_umum/'.$list->id).'">Edit</a> | <a href="'.base_url('process/cms/delete_umum/'.$list->id).'" onclick="return confirm(\'Apakah Anda yakin akan menghapus Pengguna ini ?\');">Hapus</a></td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $db->query("SELECT id, name, email, is_active FROM user WHERE role_id='6'")->getResult();

        $num_page = ceil(count($Qpaging) / $limit);
        if(count($Qpaging) > $limit){
            $ifunction->paging($p, site_url('cms').'/'.$tp.'/', $num_page, count($Qpaging), 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'add_umum':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/add_umum') ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Tambah Pengguna Umum</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Username</label>
                    <div class="controls">
                        <input type="text" name="uname" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Password</label>
                    <div class="controls">
                        <input type="password" name="pswd" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Ulangi Password</label>
                    <div class="controls">
                        <input type="password" name="repswd" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nama (individu atau organisasi)</label>
                    <div class="controls">
                        <input type="text" name="name" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Alamat</label>
                    <div class="controls">
                        <textarea name="address" required></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nomor Telepon</label>
                    <div class="controls">
                        <input type="text" name="phone" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nomor KTP</label>
                    <div class="controls">
                        <input type="text" name="ktp" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Email</label>
                    <div class="controls">
                        <input type="email" name="email" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <div class="controls">
                        <label><input type="radio" name="status" value="1" checked=""> Ya</label> &nbsp <label><input type="radio" name="status" value="0"> Tidak</label>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Tambah" />
                <a href="<?php echo site_url('cms/umum') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'edit_umum':

$Qedit = $db->query("SELECT name, email, address, phone, ktp, username, is_active FROM user WHERE `id`='$p'"); $edit = $Qedit->getResult();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/edit_umum/'.$p) ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Edit Pengguna Umum</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Username</label>
                    <div class="controls">
                        <input type="text" name="uname" value="<?php echo $edit[0]->username ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Password</label>
                    <div class="controls">
                        <input type="password" name="pswd">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Ulangi Password</label>
                    <div class="controls">
                        <input type="password" name="repswd">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nama (individu atau organisasi)</label>
                    <div class="controls">
                        <input type="text" name="name" value="<?php echo $edit[0]->name ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Alamat</label>
                    <div class="controls">
                        <textarea name="address" required><?php echo $edit[0]->address ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nomor Telepon</label>
                    <div class="controls">
                        <input type="text" name="phone" value="<?php echo $edit[0]->phone ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nomor KTP</label>
                    <div class="controls">
                        <input type="text" name="ktp" value="<?php echo $edit[0]->ktp ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Email</label>
                    <div class="controls">
                        <input type="email" name="email" value="<?php echo $edit[0]->email ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <div class="controls">
                        <label><input type="radio" name="status" value="1" <?php if($edit[0]->is_active==1) echo ' checked'; ?>> Ya</label> &nbsp <label><input type="radio" name="status" value="0" <?php if($edit[0]->is_active==0) echo ' checked'; ?>> Tidak</label>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
                <a href="<?php echo site_url('cms/umum') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'home':

$Qedit = $db->query("SELECT content, sequence FROM cms WHERE `page_id`='home' ORDER BY sequence ASC"); $edit = $Qedit->getResult();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/home') ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Home</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Gambar 1</label>
                    <div class="controls file">
                        <input type="file" name="image1">
                        <a class="info" target="_blank" href="<?php echo base_url('media/cms/'.$edit[0]->content) ?>">Lihat Gambar</a>
                        <input type="hidden" name="sequence1" value="<?php echo $edit[0]->sequence ?>">
                        <input type="hidden" name="old_image1" value="<?php echo $edit[0]->content ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Gambar 2</label>
                    <div class="controls file">
                        <input type="file" name="image2">
                        <a class="info" target="_blank" href="<?php echo base_url('media/cms/'.$edit[1]->content) ?>">Lihat Gambar</a>
                        <input type="hidden" name="sequence2" value="<?php echo $edit[1]->sequence ?>">
                        <input type="hidden" name="old_image2" value="<?php echo $edit[1]->content ?>">
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'tentang':

$Qedit = $db->query("SELECT content, sequence, type FROM cms WHERE `page_id`='tentang' ORDER BY sequence ASC"); $edit = $Qedit->getResult();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/tentang') ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Tentang Sabilulungan</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Konten</label>
                    <div class="controls file">
                        <textarea id="editor" style="width:100%;height:450px" name="content"><?php echo $edit[0]->content ?></textarea>
                        <input type="hidden" name="sequence0" value="<?php echo $edit[0]->sequence ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Gambar 1</label>
                    <div class="controls file">
                        <input type="file" name="image1">
                        <a class="info" target="_blank" href="<?php echo base_url('media/cms/'.$edit[1]->content) ?>">Lihat Gambar</a>
                        <input type="hidden" name="sequence1" value="<?php echo $edit[1]->sequence ?>">
                        <input type="hidden" name="old_image1" value="<?php echo $edit[1]->content ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Gambar 2</label>
                    <div class="controls file">
                        <input type="file" name="image2">
                        <a class="info" target="_blank" href="<?php echo base_url('media/cms/'.$edit[2]->content) ?>">Lihat Gambar</a>
                        <input type="hidden" name="sequence2" value="<?php echo $edit[2]->sequence ?>">
                        <input type="hidden" name="old_image2" value="<?php echo $edit[2]->content ?>">
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'peraturan':
?>

<div class="primary">            
    <ul class="nav-project list-nostyle clearfix">
        <li class="active">
            <a class="btn" href="<?php echo site_url('cms/add_peraturan'); ?>">+ Tambah</a>
        </li>
    </ul>

    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <h1 class="page-title">Peraturan</h1>

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
                    <th>Judul</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $db->query("SELECT sequence, title FROM cms WHERE page_id='peraturan' ORDER BY sequence ASC LIMIT $position,$limit")->getResult();

                if(count($Qlist)){
                    $i = ($p*15)-14;
                    foreach($Qlist as $list){
                        echo '<tr>
                                <td style="text-align: center;">'.$i.'</td>
                                <td>'.$list->title.'</td>
                                <td style="text-align: center;"><a href="'.site_url('cms/edit_peraturan/'.$list->sequence).'">Edit</a> | <a href="'.base_url('process/cms/delete_peraturan/'.$list->sequence).'" onclick="return confirm(\'Apakah Anda yakin akan menghapus Peraturan ini ?\');">Hapus</a></td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $db->query("SELECT page_id, title FROM cms WHERE page_id='peraturan'")->getResult();

        $num_page = ceil(count($Qpaging) / $limit);
        if(count($Qpaging) > $limit){
            $ifunction->paging($p, site_url('cms').'/'.$tp.'/', $num_page, count($Qpaging), 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'add_peraturan':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/add_peraturan') ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Tambah Peraturan</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Judul</label>
                    <div class="controls">
                        <input type="text" name="title">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">File</label>
                    <div class="controls file">
                        <input type="file" name="file">
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Tambah" />
                <a href="<?php echo site_url('cms/peraturan') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'edit_peraturan':

$Qedit = $db->query("SELECT title, content FROM cms WHERE `sequence`='$p' AND page_id='peraturan'"); $edit = $Qedit->getResult();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/edit_peraturan/'.$p) ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Edit Peraturan</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Judul</label>
                    <div class="controls">
                        <input type="text" name="title" value="<?php echo $edit[0]->title ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">File</label>
                    <div class="controls file">
                        <input type="file" name="file">
                        <a class="info" target="_blank" href="<?php echo base_url('media/peraturan/'.$edit[0]->content) ?>">Lihat File</a>
                        <input type="hidden" name="sequence" value="<?php echo $p ?>">
                        <input type="hidden" name="old_file" value="<?php echo $edit[0]->content ?>">
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
                <a href="<?php echo site_url('cms/peraturan') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'pengumuman':
?>

<div class="primary">            
    <ul class="nav-project list-nostyle clearfix">
        <li class="active">
            <a class="btn" href="<?php echo site_url('cms/add_pengumuman'); ?>">+ Tambah</a>
        </li>
    </ul>

    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <h1 class="page-title">Pengumuman</h1>

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
                    <th>Judul</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $db->query("SELECT pengumuman_id, judul FROM pengumuman ORDER BY pengumuman_id DESC LIMIT $position,$limit")->getResult();

                if(count($Qlist)){
                    $i = ($p*15)-14;
                    foreach($Qlist as $list){
                        echo '<tr>
                                <td style="text-align: center;">'.$i.'</td>
                                <td>'.$list->judul.'</td>
                                <td style="text-align: center;"><a href="'.site_url('cms/edit_pengumuman/'.$list->pengumuman_id).'">Edit</a> | <a href="'.base_url('process/cms/delete_pengumuman/'.$list->pengumuman_id).'" onclick="return confirm(\'Apakah Anda yakin akan menghapus Pengumuman ini ?\');">Hapus</a></td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $db->query("SELECT pengumuman_id, judul FROM pengumuman")->getResult();

        $num_page = ceil(count($Qpaging) / $limit);
        if(count($Qpaging) > $limit){
            $ifunction->paging($p, site_url('cms').'/'.$tp.'/', $num_page, count($Qpaging), 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'add_pengumuman':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/add_pengumuman') ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Tambah Pengumuman</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Judul</label>
                    <div class="controls">
                        <input type="text" name="judul">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Konten</label>
                    <div class="controls file">
                        <textarea id="editor" style="width:100%;height:300px" name="konten"></textarea>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Tambah" />
                <a href="<?php echo site_url('cms/pengumuman') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'edit_pengumuman':

$Qedit = $db->query("SELECT * FROM pengumuman WHERE `pengumuman_id`='$p'"); $edit = $Qedit->getResult();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('process/cms/edit_pengumuman/'.$p) ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Edit Pengumuman</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Judul</label>
                    <div class="controls">
                        <input type="text" name="judul" value="<?php echo $edit[0]->judul ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Konten</label>
                    <div class="controls file">
                        <textarea id="editor" style="width:100%;height:300px" name="konten"><?php echo $edit[0]->konten ?></textarea>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
                <a href="<?php echo site_url('cms/pengumuman') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'log':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <h1 class="page-title">Log Pengguna</h1>

        <?php   
        $limit = 15;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $db->_protect_identifiers=false;
        ?>

        <table class="table-global">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Aktifitas</th>
                    <th>Alamat IP</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $db->query("SELECT a.activity, a.ip, a.time_entry, b.name FROM log a JOIN user b ON b.id=a.user_id ORDER BY time_entry ASC LIMIT $position,$limit")->getResult();

                if(count($Qlist)){                  
                    $i = ($p*15)-14;
                    foreach($Qlist as $list){
                        switch ($list->activity) {
                            case 'login': $aktifitas = 'Login Manajemen Sistem'; break;
                            case 'register': $aktifitas = 'Mendaftar Sebagai Pengguna'; break;
                            case 'daftar_hibah': $aktifitas = 'Mendaftar Hibah atau Bansos'; break;
                            case 'edit_hibah': $aktifitas = 'Mengedit Hibah atau Bansos'; break;
                            case 'add_koordinator': $aktifitas = 'Menambah Koordinator'; break;
                            case 'edit_koordinator': $aktifitas = 'Mengedit Koordinator'; break;
                            case 'delete_koordinator': $aktifitas = 'Menghapus Koordinator'; break;
                            case 'add_umum': $aktifitas = 'Menambah Pengguna Umum'; break;
                            case 'edit_umum': $aktifitas = 'Mengedit Pengguna Umum'; break;
                            case 'delete_umum': $aktifitas = 'Menghapus Pengguna Umum'; break;
                            case 'home': $aktifitas = 'Mengedit Halaman Home'; break;
                            case 'tentang': $aktifitas = 'Mengedit Halaman Tentang Sabilulungan'; break;
                            case 'add_peraturan': $aktifitas = 'Menambah Peraturan'; break;
                            case 'edit_peraturan': $aktifitas = 'Mengedit Peraturan'; break;
                            case 'delete_peraturan': $aktifitas = 'Menghapus Peraturan'; break;
                            case 'add_nphd': $aktifitas = 'Menambah NPHD'; break;
                            case 'edit_nphd': $aktifitas = 'Mengedit NPHD'; break;
                            case 'add_lpj': $aktifitas = 'Menambah LPJ'; break;
                            case 'edit_lpj': $aktifitas = 'Mengedit LPJ'; break;
                            case 'edit_detail': $aktifitas = 'Mengedit Detail Hibah atau Bansos'; break;
                            case 'tu_periksa': $aktifitas = 'Pemeriksaan Hibah atau Bansos'; break;
                            case 'tu_periksa_edit': $aktifitas = 'Edit Pemeriksaan Hibah atau Bansos'; break;
                            case 'walikota_periksa': $aktifitas = 'Pemeriksaan Hibah atau Bansos'; break;
                            case 'walikota_periksa_edit': $aktifitas = 'Edit Pemeriksaan Hibah atau Bansos'; break;
                            case 'walikota_setuju': $aktifitas = 'Penyetujuan Walikota'; break;
                            case 'walikota_setuju_edit': $aktifitas = 'Edit Penyetujuan Walikota'; break;
                            case 'pertimbangan_periksa': $aktifitas = 'Pemeriksaan Hibah atau Bansos'; break;
                            case 'pertimbangan_periksa_edit': $aktifitas = 'Edit Pemeriksaan Hibah atau Bansos'; break;
                            case 'pertimbangan_verifikasi': $aktifitas = 'Verifikasi Hibah atau Bansos'; break;
                            case 'pertimbangan_verifikasi_edit': $aktifitas = 'Edit Verifikasi Hibah atau Bansos'; break;
                            case 'skpd_periksa': $aktifitas = 'Pemeriksaan Hibah atau Bansos'; break;
                            case 'skpd_periksa_edit': $aktifitas = 'Edit Pemeriksaan Hibah atau Bansos'; break;
                            case 'tapd_verifikasi': $aktifitas = 'Verifikasi Hibah atau Bansos'; break;
                            case 'tapd_verifikasi_edit': $aktifitas = 'Edit Verifikasi Hibah atau Bansos'; break;
                            case 'report': $aktifitas = 'Cetak Formulir Hibah atau Bansos'; break;
                            case 'generate_dnc': $aktifitas = 'Cetak Generate DNC PBH'; break;
                            case 'logout': $aktifitas = 'Logout Manajemen Sistem'; break;
                        }

                        echo '<tr>
                                <td>'.$list->name.'</td>
                                <td>'.$aktifitas.'</td>
                                <td style="text-align:center">'.$list->ip.'</td>
                                <td style="text-align:center">'.date('M d, Y. g:i A', strtotime($list->time_entry)).'</td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $db->query("SELECT a.activity, a.ip, a.time_entry, b.name AS user FROM log a JOIN user b ON b.id=a.user_id")->getResult();

        $num_page = ceil(count($Qpaging) / $limit);
        if(count($Qpaging) > $limit){
            $ifunction->paging($p, site_url('cms').'/'.$tp.'/', $num_page, count($Qpaging), 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

}
?>

</div>
<!-- wrapper -->
</div>
<!-- content-main -->
<?= $this->endSection(); ?>