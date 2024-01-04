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
        var chrt = $("#prosesChart")[0].getContext("2d");
        var chartId = new Chart(chrt, {
        type: 'doughnut',
        data: {
        datasets: [{
            label: "Persentase Tahapan",
            data: [14.8, 14.8, 10.8, 14.8, 25.8, 14.8, 7.8,20.8],
            backgroundColor: ['#2196F3', '#4CAF50', '#FF5722', '#ff8c00', '#FFEB3B', '#9C27B0','#009688'],
            hoverOffset: 5,
            borderWidth: 0
        }],
        labels: ["Pemeriksaan Kelengkapan oleh Bagian TU : Proses 15%", "Pemeriksaan oleh Walikota : Proses 30%", "Klasifikasi sesuai SKPD oleh Tim Pertimbangan : Proses 40%", "Rekomendasi Dana oleh SKPD  : Proses 50%", "Verifikasi Proposal oleh Tim Pertimbangan : Proses 65%", "Verifikasi Proposal oleh TAPD  : Proses 85%","Persetujuan Bupati : Proses 100%","Proese11"],
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
                    if(args.value>20){
                                return args.value + '%';
                            }
                },
            }
        }
        },
        });
    }
    if ($("#presentase").length && $("#presentase").is(":visible")) {
        var ctx = $("#presentase")[0].getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Verifikasi Proposal oleh Tim Pertimbangan', 'Klasifikasi sesuai SKPD oleh Tim Pertimbangan', 'Rekomendasi Dana oleh SKPD'],
                datasets: [{
                    label: 'Persentase Tahapan',
                    data: [14.8, 14.8, 14.8],
                    backgroundColor: ['#2196F3', '#4CAF50', '#FF5722'],
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
                            if(args.value>20){
                                return args.value + '%';
                            }
                        },
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
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalProposal;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 2</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalProposal;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 3</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalProposal;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 4</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalProposal;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 5</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalProposal;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 6</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalProposal;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 flex-fill bd-highlight">
                                    <div class="card bg-orange mt-2">
                                        <div class="card-body ps-2 pe-2 pt-3 pb-3" style="height: 100px !important;">
                                            <p class="text-center mb-0 h6 text-white" ><small>LEVEL 7</small></p>
                                            <p class="text-center text-white mt-0 mb-0 display-6 font-weight-bold"><?=$totalProposal;?></p>
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
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-biru"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Proposal oleh Tim Pertimbangan</small></p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-hijau"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Klasifikasi sesuai SKPD oleh Tim Pertimbangan</small></p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-merah"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Rekomendasi Dana oleh SKPD</small></p>
                                            </div>
                                        </div>
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
                                    <th class="text-center">Tahapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="">Sekertariat Daerah</td>
                                    <td class="text-center">0</td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text">Dinas Pendidikan, Pemuda, Olah Raga, dan Pariwisata</td>
                                    <td class="text-center">0</td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td class="">Dinas Pertanian, Ketahanan Pangan dan Perikanan</td>
                                    <td class="text-center">0</td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td class="">Dinas Sosial, Pemberdayaan Perempuan, dan Perlindungan Anak</td>
                                    <td class="text-center">0</td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td class="">Dinas Sosial, Pemberdayaan Perempuan, dan Perlindungan Anak</td>
                                    <td class="text-center">0</td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td class="">Dinas Sosial, Pemberdayaan Perempuan, dan Perlindungan Anak</td>
                                    <td class="text-center">0</td>
                                </tr>
                                <tr>
                                    <td class="text-center">7</td>
                                    <td class="">Dinas Sosial, Pemberdayaan Perempuan, dan Perlindungan Anak</td>
                                    <td class="text-center">0</td>
                                </tr>
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
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-biru"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Sekertariat Daerah</small></p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-hijau"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Dinas Pendidikan, Pemuda, Olah Raga, dan Pariwisata</small></p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-merah"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Dinas Pertanian, Ketahanan Pangan dan Perikanan</small></p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-orange"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Dinas Sosial, Pemberdayaan Perempuan, dan Perlindungan Anak</small></p>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-kuning"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Dinas Sosial, Pemberdayaan Perempuan, dan Perlindungan Anak</small></p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-ungu"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Dinas Sosial, Pemberdayaan Perempuan, dan Perlindungan Anak</small></p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rounded p-1 bg-hijau-tua"></div>
                                            </div>
                                            <div class="col">
                                                <p class="text m-0"><small>Dinas Sosial, Pemberdayaan Perempuan, dan Perlindungan Anak</small></p>
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
    </div>

</div>
<!-- content-main -->
<?= $this->endSection(); ?>