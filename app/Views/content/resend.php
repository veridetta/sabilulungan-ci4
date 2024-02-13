<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <h1 class="page-title page-title-border">Kirim ulang kode konfirmasi</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>        
        <form class="form-global" method="post" action="<?php echo site_url('/resend') ?>">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Email</label>
                    <div class="controls">
                        <input type="text" name="email" required>
                    </div>
                </div>
                <div class="control-actions clearfix">
                    <button class="btn-red btn-plain btn" type="submit">Konfirmasi</button>
                    <a class="btn-black btn-plain btn" href="<?php echo site_url('/confirm') ?>"target="_blank">Halaman konfirmasi</a>
                </div>
            </fieldset>
        </form>
        <!-- form-register -->
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->
<?= $this->endSection(); ?>