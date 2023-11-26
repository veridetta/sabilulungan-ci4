<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">
        <h1 class="page-title page-title-border">Lupa Kata Sandi</h1>
        <form class="form-global" action="">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Email</label>
                    <div class="controls">
                        <input type="email">
                    </div>
                </div>
                <div class="control-actions clearfix">
                    <button class="btn-red btn-plain btn" type="submit">Kirim</button>
                </div>
            </fieldset>
        </form>
        <!-- form-register -->
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->
<?= $this->endSection(); ?>