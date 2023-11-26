<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php
$limit = 15;
$p = $p ? $p : 1;
$position = ($p -1) * $limit;
$db->_protect_identifiers=false;

?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="about-page wrapper">
        <h1 class="page-title page-title-border">Pengumuman</h1>
        <div class="col-wrapper clearfix">
            <style type="text/css">
            table{
                margin-bottom:10px;
            }
            table tr{
                border-bottom:1px dotted #CCC;
                /*height:70px;*/
            }
            table tr:last-child{
                border-bottom:none
            }
            table tr td{
                padding:15px 0
            }
            table tr td table tr{
                height:30px;        
            }
            table tr td table tr td{
                padding:0
            }
            span {
                color: #bbb;
                font-style: italic;
            }
            </style>

            <table width="100%">
            <?php
            $Qpage = $db->query("SELECT `pengumuman_id`, `judul`, `konten`, `date_created` FROM `pengumuman` ORDER BY `pengumuman_id` DESC LIMIT $position, $limit"); 

            foreach($Qpage->getResult() as $page){
                $konten = strip_tags($page->konten); $konten = substr($konten, 0, 150);
                $length = strlen($konten);
                
                $time = strtotime($page->date_created);
                switch (date('N', $time)){
                    case '1': $day = 'Senin'; break;
                    case '2': $day = 'Selasa'; break;
                    case '3': $day = 'Rabu'; break;
                    case '4': $day = 'Kamis'; break;
                    case '5': $day = 'Jum\'at'; break;
                    case '6': $day = "Sabtu"; break;
                    case '7': $day = 'Minggu'; break;
                }
                        
                echo '<tr><td colspan="2"><a href="'.site_url('view/'.$page->pengumuman_id).'"><h3>'.$page->judul.'</h3></a><span>'.$day.', '.date('d', $time).'/'.date('m', $time).'/'.date('Y', $time).' '.date('H', $time).':'.date('i', $time).' WIB</span><br>'.$konten.''; if($length >= 150) echo '...'; echo '</td></tr>';
            }
            ?>
            </table>
        </div>
        <?php
        $Qpaging = $db->query("SELECT `pengumuman_id`, `judul`, `konten`, `date_created` FROM `pengumuman`")->getResult();

        $num_page = ceil(count($Qpaging) / $limit);
        if(count($Qpaging) > $limit){
            $this->ifunction->paging($p, site_url('pengumuman').'/', $num_page, count($Qpaging), 'href', false);
        }
        ?> 
    </div>
</div>
<!-- content-main -->
<?= $this->endSection(); ?>