<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">
        <h1 class="page-title page-title-border">Mendaftar Hibah Bansos</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?> 
        <form class="form-global" method="post" action="<?php echo site_url('process/input/daftar') ?>" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Nama (pengguna)</label>
                    <div class="controls">
                        <input type="text" name="user" required>
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
                    <label class="control-label" for="">Judul Kegiatan</label>
                    <div class="controls">
                        <input type="text" name="judul" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Latar Belakang</label>
                    <div class="controls">
                        <textarea name="latar" required></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Maksud dan Tujuan</label>
                    <div class="controls">
                        <textarea name="maksud" required></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Kategori</label>
                    <div class="controls">
                        <select name="skpd">
                        <option value="0">-- Silahkan Pilih</option>
                        <?php
                        $Qskpd = $this->db->query("SELECT * FROM skpd ORDER BY id ASC");

                        foreach($Qskpd->result_object() as $skpd){
                            echo '<option value="'.$skpd->id.'">'.$skpd->name.'</option>';
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Tahapan</label>
                    <div class="controls">
                        <select name="tahap">
                        <option value="0">-- Silahkan Pilih</option>
                        <?php
                        $Qtahap = $this->db->query("SELECT id, name FROM flow ORDER BY sequence ASC");

                        foreach($Qtahap->result_object() as $tahap){
                            echo '<option value="'.$tahap->id.'">'.$tahap->name.'</option>';
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Keterangan TU</label>
                    <div class="controls">
                        <textarea name="keterangan"></textarea>
                    </div>
                </div>
                <!-- <div class="control-group">
                    <label class="control-label" for="">Deskripsi Kegiatan</label>
                    <div class="controls">
                        <textarea name="kegiatan" required></textarea>
                    </div>
                </div> -->
                <div class="control-group">
                    <label class="control-label" for="">Proposal</label>
                    <div class="controls file">
                        <input type="file" name="proposal" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Dana</label>
                    <div class="controls file">
                        <input type="text" name="deskripsi[]" placeholder="Deskripsi">
                        <input type="number" name="jumlah[]" placeholder="Jumlah">
                    </div>
                    <a class="dana" href="#">Tambah Dana</a>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Foto</label>
                    <div class="controls file">
                        <input type="file" name="foto[]">
                    </div>
                    <a class="link" href="#">Tambah Foto</a>
                </div>
                <div class="control-actions clearfix">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <button class="btn-red btn-plain btn" type="submit">Daftar</button>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->