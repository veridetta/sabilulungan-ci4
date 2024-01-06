<?= $this->extend('templates/index'); ?>
<?= $this->section('page-css'); ?>
<style>
    .step-big {
          background: #ebebeb;
          color: black;
          display: block;
          float: left;
          font-size: 66px !important;
          height: 67px !important;
          line-height: 114px !important;
          text-align: center;
          border-radius: 7px !important;
          width: 100px  !important; }
    .bg-orange{
        background-color: #ff8c00 !important;
    }
    .bg-biru{
        background-color: #2196F3 !important;
    }
    .bg-hijau{
        background-color: #4CAF50 !important;
    }
    .bg-merah{
        background-color: #FF5722 !important;
    }
    .bg-kuning{
        background-color: #FFEB3B !important;
    
    }
    .bg-ungu{
        background-color: #9C27B0 !important;
    }
    .bg-hijau-tua{
        background-color: #009688 !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css"/>
<?= $this->endSection(); ?>

<?= $this->section('page-js'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
<script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>
<script>
//document ready
$(document).ready(function(){
    if($("#prosesChart").length && $("#prosesChart").is(":visible")){
        var data = <?php echo json_encode($resultArray); ?>;
        console.log(data);
        var chrt = $("#prosesChart")[0].getContext("2d");
        var chartId = new Chart(chrt, {
        type: 'doughnut',
        data: {
                labels: data.labels,
                datasets: [{
                    data: data.datasets[0].data,
                    backgroundColor: data.datasets[0].backgroundColor,
                    hoverOffset: 4,
                    borderWidth: 0
                }]
            },
        options: {
            plugins: {
                legend: {
                    display:false
                },
                title:{
                    display:false,
                    text:"Persentase Tahapan"
                },
                labels:{
                    render: (args)=>{
                        if(args.value><?php echo $persen;?> ){
                                    return args.value + '%';
                                }
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            //ambil label
                            var label = context.label || '';
                            //atur max char
                            if (label.length > 20) {
                                label = label.substr(0, 20) + '...';
                            }
                            return label;
                        }
                    }
                }
            },

        },
        });
    }
    if ($("#presentase").length && $("#presentase").is(":visible")) {
        var data = <?php echo json_encode($resultArrayFlow); ?>;
        var ctx = $("#presentase")[0].getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.datasets[0].data,
                    backgroundColor: data.datasets[0].backgroundColor,
                    hoverOffset: 4,
                    borderWidth: 0
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    labels:{
                        render: (args)=>{
                            if(args.value><?php echo $persenFlow;?>){
                                return args.value + '%';
                            }
                        },
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                //ambil label
                                var label = context.label || '';
                                //atur max char
                                if (label.length > 20) {
                                    label = label.substr(0, 20) + '...';
                                }
                                return label;
                            }
                        }
                    }
                },
            }
        });
    }


});
</script>

<?= $this->endSection(); ?>

<?= $this->section('page-content'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="about-page wrapper">
        <div class="col-12 row equal">
            <div class="col-10">
                <div class="h-100 bg-info p-2 d-flex align-items-center justify-content-center">
                    <p class="h2 font-weight-bold mb-0 text-white" id="titlenya">DASHBOARD MONITORING HIBAH BANSOS TAHUN <?=date('Y');?></p>
                </div>
            </div>
            <div class="col-2 bg-info p-2">
                <div class="h-100">
                    <p class="text-center text-white m-0 h6">Total Proposal</p>
                    <p class="h4 text-center text-white m-0 font-weight-bold"><?= $totalProposal;?></p>
                </div>
            </div>
        </div>
        <div class="col-wrapper clearfix">
            <div class="col-12 row d-flex equal mt-2">
                <div class="col-7">
                    <div class="h-100">
                    <div class="card">
                        <div class="card-body">
                            <img class="img-fluid w-100" src="<?=base_url('/static/img/flow.png')?>" alt="flowchart">
                        </div>
                    </div>
                    <div class="d-flex">
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 1</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalproposalstep1;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 2</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalproposalstep2;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 3</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalproposalstep3;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 4</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalproposalstep4;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 5</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalproposalstep5;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 6</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalproposalstep6;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 7</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalproposalstep7;?></p>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card h-100">
                        <div class="card-body justify-center">
                            <div class="d-flex justify-content-end">
                                <span class="h6 font-weight-bold rounded text-black bg-danger pl-3 pr-3 p-2 text-white">Persentase Tahapan</span>
                            </div>
                            <div class="row">
                                <div class="col-8 ">
                                    <canvas id="presentase" height="200" width="300" class="ml-0"></canvas>
                                </div>
                                <div class="col-4 d-flex align-items-center">
                                    <div>
                                        <?php
                                        if(!empty($resultArrayFlow['labels'])){
                                            $x = 0;
                                            foreach ($resultArrayFlow['labels'] as $key => $label) {
                                                ?>
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="rounded p-1" style="background-color: <?php echo $colors[$x]; ?>"></div>
                                                    </div>
                                                    <div class="col">
                                                        <p class="text m-0"><small><?php echo $label; ?></small></p>
                                                    </div>
                                                </div>
                                                <?php
                                                $x++;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 row d-flex equal mt-2">
                <div class="col-7">
                    <div class="h-100">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama SKPD</th>
                                    <th class="text-center">Jumlah Proposal</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no = 1;
                                if (!empty($resultArray['labels'])) {
                                    foreach ($resultArray['labels'] as $key => $label) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td class=""><?= $label; ?></td>
                                            <?php
                                            $totalProposalSkpd = isset($resultArray['datasets'][0]['data'][$key]) ? $resultArray['datasets'][0]['data'][$key] : 0;
                                            ?>
                                            <td class="text-center"><?= $totalProposalSkpd; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data</td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card h-100">
                        <div class="card-body justify-center">
                            <div class="row justify-content-center">
                                <div class="col-8 d-flex align-items-center justify-content-center">
                                    <div>
                                        <canvas id="prosesChart" height="200" width="300" class="ml-0"></canvas>
                                    </div>
                                </div>
                                <div class="col-12 mt-1 d-flex align-items-center">
                                    <div class="row">
                                        <div class="col-6">
                                            <?php
                                            $x = 0;
                                            $half = ceil(count($resultArray['labels']) / 2);
                                            foreach ($resultArray['labels'] as $key => $label) {
                                                if ($key < $half) {
                                                    ?>
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="rounded p-1" style="background-color: <?php echo $colors[$x]; ?>"></div>
                                                        </div>
                                                        <div class="col">
                                                            <p class="text m-0"><small><?php echo $label; ?></small></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $x++;
                                                }
                                            }
                                            ?>
                                        </div>

                                        <div class="col-6">
                                            <?php
                                            foreach ($resultArray['labels'] as $key => $label) {
                                                if ($key >= $half) {
                                                    ?>
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="rounded p-1" style="background-color: <?php echo $colors[$x]; ?>"></div>
                                                        </div>
                                                        <div class="col">
                                                            <p class="text m-0"><small><?php echo $label; ?></small></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $x++;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>



                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- content-main -->
<?= $this->endSection(); ?>