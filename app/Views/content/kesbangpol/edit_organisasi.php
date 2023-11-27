<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">            
        <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo site_url('proses_edit_organisasi') ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Ubah Organisasi Legal</h1>

            <div class="col-wrapper clearfix">
                <input type="hidden" name="id" value="<?= $data['id'];?>">
                <div class="control-group">
                    <label class="control-label" for="">Nama</label>
                    <div class="controls">
                        <input type="text" name="name" value="<?= $data['name'];?>" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Alamat</label>
                    <div class="controls">
                        <textarea type="text" name="address"  required style="height: 50px;"><?= $data['address'];?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">No Telp.</label>
                    <div class="controls">
                        <input type="text" name="phone"value="<?= $data['phone'];?>" required>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <div class="controls">
                        <label><input type="radio" name="status" value="<?= $data['legal'];?>" checked> Legal</label> &nbsp <label><input type="radio" name="status" value="0"> Tidak</label>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />
                <a href="<?php echo site_url('/organisasi') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
    </div>
</div>
<?= $this->endSection(); ?>