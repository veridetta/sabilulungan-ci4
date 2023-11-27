<?= $this->extend('templates/index'); ?>
<?= $this->section('page-css'); ?>
<style>
    .step-big {
          background: #ebebeb;
          color: black;
          display: block;
          float: left;
          font-size: 66px !important;
          height: 112px !important;
          line-height: 114px !important;
          text-align: center;
          width: 129px  !important; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css"/>
<?= $this->endSection(); ?>

<?= $this->section('page-js'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
<script>
//document ready
$(document).ready(function(){
    if($("#prosesChart")){
    var chrt = $("#prosesChart")[0].getContext("2d");
    var chartId = new Chart(chrt, {
    type: 'doughnut',
    data: {
    datasets: [{
        label: "Persentase Tahapan",
        data: [14.8, 14.8, 14.8, 14.8, 14.8, 14.8, 14.8],
        backgroundColor: ['yellow', 'aqua', 'pink', 'lightgreen', 'gold', 'lightblue'],
        hoverOffset: 5
    }],
    labels: ["Pemeriksaan Kelengkapan oleh Bagian TU : Proses 15%", "Pemeriksaan oleh Walikota : Proses 30%", "Klasifikasi sesuai SKPD oleh Tim Pertimbangan : Proses 40%", "Rekomendasi Dana oleh SKPD  : Proses 50%", "Verifikasi Proposal oleh Tim Pertimbangan : Proses 65%", "Verifikasi Proposal oleh TAPD  : Proses 85%","Persetujuan Bupati : Proses 100%"],
    },
    options: {
    responsive: false,
    plugins: {
        legend: {
            display:false
        },
        title:{
            display:false,
            text:"Persentase Tahapan"
        },
        tooltip: {
        callbacks: {
            label: function(tooltipItem, data) {
                label = tooltipItem.label;
                labelSplit = label.split(":");
                label = labelSplit[0];
                label2 = labelSplit[1];
                return [label, label2];
            }
        }
    }
    }
    },
    });
}
});
</script>

<?= $this->endSection(); ?>

<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="about-page wrapper">
        <h1 class="page-title page-title-border" id="titlenya">DASHBOARD MONITORING HIBAH BANSOS TAHUN <?=date('Y');?></h1>
        <div class="col-wrapper clearfix">
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex col-12 clearfix">
                        <div class="col-10 p-2">

                            <ul class="project-list-progress list-nostyle" style="border:none;">
                            <?php
                                for($i=1;$i<8;$i++){
                                    $done = 'done';
                                    echo '<li class="step-big step-'.$i.' '.$done.'">'.$i.'</li>';
                                }
                                ?>
                            </ul>

                        </div>
                        <div class="col-2">
                            <div class="card bg-success mt-2">
                                <div class="card-body" style="height: 112px !important;">
                                    <p class="text-center mb-0 h6 text-white" >TOTAL</p>
                                    <h1 class="text-center text-white mb-0 display-4 font-weight-bold"><?=$totalProposal;?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 row d-flex mt-2">
                <div class="col-8 h-100">
                    <div class="card">
                        <div class="card-body">
                            <img class="img-fluid w-100" src="<?=base_url('/static/img/flow.png')?>" alt="flowchart">
                        </div>
                    </div>
                </div>
                <div class="col-4 h-100">
                    <div class="card h-100">
                        <div class="card-body justify-center">
                            <h6 class="fw-bold text-black">Persentase Tahapan</h6>
                            <canvas id="prosesChart" height="200" width="300" class="ml-0"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 row d-flex">
                <div class="col-9  p-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="fw-bold text-black mt-3">Yang Telah Diverifikasi OPD</h5>
                            <hr>
                            <div class="row col-12 d-flex p-2">
                                <?php foreach($proposalData as $p){?>
                                <div class="col-lg-4 col-md-4 col-12 p-2">
                                    <?php
                                $judul = $p->judul;
                                $judul = mb_strimwidth($judul, 0, 50, "...");
                            ?>
                                    <p class="mt-1 m-0"><a id="myLink"
                                            href="/detail/<?=$p->id;?>">Judul : <?php echo $judul; ?></a></p>
                                    <p class="m-0">Oleh : <span class="badge bg-success"><?= $p->name;?></span></p>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 p-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="fw-bold text-black">Total Proposal</h5>
                            <hr>
                            <p class="h1 fw-bold text-center"><?= $totalProposal;?></p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold text-black">Detail Proposal Hibah Bansos Tahun <?= date('Y')?></h5>
                    <hr>
                    <div class="col-12">
                        <div class="row col-12 d-flex p-2">
                        <?php foreach($proposalDataTahunIni as $p){?>
                                    <div class="col-12 col-lg-4 col-lg-4 p-2">
                                        <?php
                                $judul = $p->judul;
                                $judul = mb_strimwidth($judul, 0, 50, "...");
                            ?>
                                        <p class="mt-1 m-0"><a id="myLink"
                                            href="/detail/<?=$p->id;?>">Judul : <?php echo $judul; ?></a></p>
                                    <p class="m-0">Oleh : <span class="badge bg-success"><?= $p->name;?></span></p>
                                    </div>
                                    <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- content-main -->
<?= $this->endSection(); ?>