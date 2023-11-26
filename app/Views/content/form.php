<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<?php

//$media = 'http://183.91.78.12/sabilulungan/media/';
$media = 'http://localhost/sabilulungan/media/';

switch($tp){

case 'verifikasi_tu':

// $Qedit = $db->query("SELECT * FROM ak_pengaturan WHERE `id`='pelanggan'"); 
// $edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">PENGECEKAN BERKAS TU <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/tatausaha/periksa') ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)">
		<h2>Detail Pengecekan Dokumen</h2>
            <ul class="category-list list-nostyle">
            	<li>
                    <label class="checkbox">
                        <h3 style="color:#ec7404">Kategori</h3>
                    </label>
                </li>
                <li>
                    <label class="checkbox">
                    	<select name="kategori">
                    	<option value="">-- Silahkan Pilih</option>
                    	<?php
                    	$Qkategori = $db->table('proposal_type')->select("id, name")->order_by('id', 'ASC')->get();

			            foreach($Qkategori->getResult() as $kategori){
			            	echo '<option value="'.$kategori->id.'">'.$kategori->name.'</option>';
			            }
                    	?>
                    	</select>
                    </label>
                </li>
                <?php
            	$Qlist1 = $db->table('checklist')->select("id, name")->where('role_id', 5)->order_by('sequence', 'ASC')->limit(4)->get();

	            foreach($Qlist1->getResult() as $list1){
	            	echo '<li>
		                    <label class="checkbox">
		                        <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
		                        '.$list1->name.'
		                    </label>
		                </li>';
	            }
            	?>
            </ul>
            <h2>Persyaratan Administrasi</h2>
            <ul class="category-list list-nostyle">
            	<?php
            	$Qlist2 = $db->table('checklist')->select("id, name")->where('role_id', 5)->order_by('sequence', 'ASC')->limit(8,4)->get();

	            foreach($Qlist2->getResult() as $list2){
	            	echo '<li>
		                    <label class="checkbox">
		                        <input type="checkbox" name="persyaratan[]" value="'.$list2->id.'">
		                        '.$list2->name.'
		                    </label>
		                </li>';
	            }
	            ?>
            </ul>
            <p>Pengecualian poin 1, 3, 5, 6 untuk proposal yang berkaitan dengan tempat peribadatan, pondok pesantren dan kelompok swadaya masyarakat yang bersifat non-formal dan pengelolaannya berupa partisipasi swadaya masyarakat.</p>
            <h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan"></textarea>

		<div class="ifooter">
		<input type="hidden" name="proposal_id" value="<?php echo $dx; ?>">
		<input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
		<input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Lanjut ke Pemeriksaan oleh Walikota" />
		<input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" />
		<input type="button" class="btn-grey btn-plain btn ifclose" style="display:inline" value="Kembali" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'pemeriksaan_walikota':

// $Qedit = $db->query("SELECT * FROM ak_pengaturan WHERE `id`='pelanggan'"); 
// $edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi TU <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/apps/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)" enctype="multipart/form-data">

		<p class="label">Nama (Individu atau Organisasi)</p>
        <p>Pengurus Sekolah Pemimpin</p>
        <p class="label">Judul Kegiatan</p>
        <p>Pembangunan Sekolah Pemimpin</p>
        <p class="label">Deskripsi Singkat Kegiatan</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est la.</p>
        <p class="label">Nominal yang Diajukan di Proposal</p>
        <p>Rp 50.000.000</p>
        <p class="label">Keterangan dari TU</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
        <h3 style="color:#ec7404">Keterangan</h3>
        <textarea rows="5"></textarea>

		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="btn-red btn-plain btn" style="display:inline" value="Disposisi ke Tim Pertimbangan" />
		<input type="button" class="btn-red btn-plain btn ifclose" style="display:inline" value="Ditolak" />
		<input type="button" class="btn-grey btn-plain btn ifclose" style="display:inline" value="Kembali" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'pemeriksaan_pertimbangan':

// $Qedit = $db->query("SELECT * FROM ak_pengaturan WHERE `id`='pelanggan'"); 
// $edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">Pemeriksaan Proposal Hibah Bansos Hasil Pemeriksaan Walikota <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/apps/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)" enctype="multipart/form-data">

		<p class="label">Nama (Individu atau Organisasi):</p>
        <p>Pengurus Sekolah Pemimpin</p>
        <p class="label">Judul Kegiatan:</p>
        <p>Pembangunan Sekolah Pemimpin</p>
        <p class="label">Deskripsi Singkat Kegiatan</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est la.</p>
        <p class="label">Nominal yang Diajukan di Proposal</p>
        <p>Rp 50.000.000</p>
        <p class="label">Keterangan dari TU</p>
        <p>OK</p>
        <h2></h2>
        <div class="col-wrapper clearfix">
            <h3 style="color:#ec7404">Kategori Hibah Bansos</h3>
            <ul class="category-list col list-nostyle">
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Perencanaan Pembangunan
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Lingkungan Hidup
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Pemberdayaan Perempuan dan Perlindungan Anak
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Kesatuan Bangsa dan Politik dalam Negeri
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Penanaman Modal
                    </label>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Pendidikan
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Kesehatan
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Pekerjaan Umum Bidang Jalan dan Jemabatan
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Perumahan dan Urusan Penataan Ruang
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Perhubungan
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Kependudukan dan Catatn Sipil
                    </label>
                </li>
            </ul>
            <ul class="category-list col list-nostyle">
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Sosial, Keagamaan/Peribadatan dan Pendidikan Agama
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Kesejahteraan Sosial
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Ketenagakerjaan
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Koperasi dan Usaha Kecil Menengah
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Kepemudaan dan Olah Raga Non Profesional
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Kebudayaan dan Adat Istiadat, Pariwisata dan Kesenian
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Komunikasi dan Informatika
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Pertanian
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Otonomi Daerah dan Pemerintahan Umum
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Perusahaan Daerah dan Perekonomian
                    </label>
                </li>
                <li>
                    <label class="radio">
                        <input type="radio" name="status-radio">
                        Kearsipan
                    </label>
                </li>
            </ul>
        </div>

		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="btn-red btn-plain btn" style="display:inline" value="Disposisi ke SKPD" />
		<input type="button" class="btn-grey btn-plain btn ifclose" style="display:inline" value="Kembali" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'pemeriksaan_skpd':

// $Qedit = $db->query("SELECT * FROM ak_pengaturan WHERE `id`='pelanggan'"); 
// $edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi Pertimbangan <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/apps/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)" enctype="multipart/form-data">

		<p class="label">Nama (Individu atau Organisasi)</p>
        <p>Pengurus Sekolah Pemimpin</p>
        <p class="label">Judul Kegiatan</p>
        <p>Pembangunan Sekolah Pemimpin</p>
        <p class="label">Deskripsi Singkat Kegiatan</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est la.</p>
        <p class="label">Nominal yang Diajukan di Proposal</p>
        <p>Rp 50.000.000</p>
        <p class="label">Keterangan dari TU</p>
        <p>OK</p>
        <p class="label">Keterangan dari Walikota</p>
        <p>OK</p>
        <p class="label">Keterangan dari Tim Pertimbangan</p>
        <p>OK</p>
        <h2></h2>
        <div class="col-wrapper clearfix">
            <h3 style="color:#ec7404">Pemberian Rekomendasi Dana</h3>
            <div class="control-group">
                <label class="control-label radio-inline radio">
                    <input type="radio" name="status-radio">
                    Ya
                </label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <label class="control-label radio-inline radio">
                    <input type="radio" name="status-radio">
                    Tidak
                </label>
            </div>
            <div class="control-group">
            <h3 style="color:#ec7404">Besar Rekomendasi Dana</h3>
                <div class="controls">
                    <input type="text" placeholder="Rp">
                </div>
            </div>
        </div>
        <br>
        <ul class="category-list list-nostyle">
            <li>
                <label class="checkbox">
                    <input type="checkbox" name="status-checkbox">
                    1. Kesesuaian Harga dalam Proposal dengan Standar Satuan Kerja
                </label>
            <li>
                <label class="checkbox">
                    <input type="checkbox" name="status-checkbox">
                    2. Kesesuaian Kebutuhan Peralatan dan Bahan dalam Kegiatan
                </label>
            </li>
            <li>
                <label class="checkbox">
                    <input type="checkbox" name="status-checkbox">
                    3. Organisasi Tidak Fiktif
                </label>
            </li>
            <li>
                <label class="checkbox">
                    <input type="checkbox" name="status-checkbox">
                    4. Alamat Organisasi/Ketua Sesuai dengan Proposal
                </label>
            </li>
            <li>
                <label class="checkbox">
                    <input type="checkbox" name="status-checkbox">
                    5. Belum Pernah Menerima Satu Tahun Sebelumnya
                </label>
            </li>
            <li>
                <label class="checkbox">
                    <input type="checkbox" name="status-checkbox">
                    6. Verifikasi KTP
                </label>
            </li>
            <li>
                <label class="checkbox">
                    <input type="checkbox" name="status-checkbox">
                    7. Verifikasi Organisasi Berbadan Hukum
                </label>
            </li>
        </ul>
        <h3 style="color:#ec7404">Keterangan</h3>
        <textarea rows="5"></textarea>

		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="btn-red btn-plain btn" style="display:inline" value="Disposisi ke Tim Pertimbangan" />
		<input type="button" class="btn-grey btn-plain btn ifclose" style="display:inline" value="Kembali" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'verifikasi_pertimbangan':

// $Qedit = $db->query("SELECT * FROM ak_pengaturan WHERE `id`='pelanggan'"); 
// $edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">Pemeriksaan Berdasarkan Pertimbangan SKPD <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/apps/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)" enctype="multipart/form-data">

		<p class="label">Nama (Individu atau Organisasi)</p>
        <p>Pengurus Sekolah Pemimpin</p>
        <p class="label">Judul Kegiatan</p>
        <p>Pembangunan Sekolah Pemimpin</p>
        <p class="label">Deskripsi Singkat Kegiatan</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est la.</p>
        <p class="label">Nominal yang diajukan di Proposal</p>
        <p>Rp 50.000.000</p>
        <h2></h2>
        <div class="col-wrapper clearfix">
        	<h3 style="color:#ec7404">Formulir Verifikasi</h3>
            <div class="control-group">
                <label class="control-label" for="">Koreksi (Angka)</label>
                <div class="controls">
                    <input type="text">
                </div>
            </div>            
            <div class="control-group">
                <label class="control-label" for="">Keterangan</label>
                <div class="controls">
                    <textarea rows="5"></textarea>
                </div>
            </div>
        </div>

		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="btn-red btn-plain btn" style="display:inline" value="Verifikasi" />
		<input type="submit" class="btn-orange btn-plain btn" style="display:inline" value="Preview Formulir" />
		<input type="submit" class="btn-orange btn-plain btn" style="display:inline" value="Cetak Formulir" />
		<input type="button" class="btn-grey btn-plain btn ifclose" style="display:inline" value="Kembali" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'verifikasi_tapd':

// $Qedit = $db->query("SELECT * FROM ak_pengaturan WHERE `id`='pelanggan'"); 
// $edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi Pertimbangan <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/apps/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)" enctype="multipart/form-data">

		<p class="label">Nama (Individu atau Organisasi)</p>
        <p>Pengurus Sekolah Pemimpin</p>
        <p class="label">Judul Kegiatan</p>
        <p>Pembangunan Sekolah Pemimpin</p>
        <p class="label">Deskripsi Singkat Kegiatan</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est la.</p>
        <p class="label">Nominal yang Diajukan di Proposal</p>
        <p>Rp 50.000.000</p>
        <p class="label">Nominal yang Direkomendasikan Tim Pertimbangan</p>
        <p>Rp 30.000.000</p>
        <div class="control-group">
            <label class="control-label" for=""><p class="label">Nominal yang Direkomendasikan TAPD</p></label>
            <div class="controls">
                <input type="text" placeholder="Rp">
            </div>
        </div>           
        <div class="control-group">
            <label class="control-label" for=""><p class="label">Keterangan</p></label>
            <div class="controls">
                <textarea rows="5"></textarea>
            </div>
        </div>

		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="btn-red btn-plain btn" style="display:inline" value="Verifikasi" />
		<input type="button" class="btn-grey btn-plain btn ifclose" style="display:inline" value="Kembali" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'penyetujuan_walikota':

// $Qedit = $db->query("SELECT * FROM ak_pengaturan WHERE `id`='pelanggan'"); 
// $edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi TU <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/apps/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)" enctype="multipart/form-data">

		<p class="label">No DNC PBH</p>
        <p>Pengurus Sekolah Pemimpin</p>
        <p class="label">SKPD</p>
        <p>Pembangunan Sekolah Pemimpin</p>
        <p class="label">Tanggal Awal</p>
        <p>Lorem ipsum dolor sit amet</p>
        <p class="label">Tanggal Akhir</p>
        <p>Lorem ipsum dolor sit amet</p>

        <table class="table-global">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Nama Lengkap Calon Penerima</th>
                    <th rowspan="2">Alamat Lengkap</th>
                    <th rowspan="2">Rencana Penggunaan</th>
                    <th class="has-sub" colspan="3">Besaran Belanja Hibah (Rp)</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th>Permohonan</th>
                    <th>Hasil Evaluasi</th>
                    <th>Pertimbangan TAPD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Lulu Kartanegara</td>
                    <td>Pejaten</td>
                    <td>Rencana</td>
                    <td>Permohonan</td>
                    <td>Hasil</td>
                    <td>TAPD</td>
                    <td>Keterangan</td>
                </tr>
            </tbody>
        </table>

        <h3 style="color:#ec7404">Keterangan</h3>
        <textarea rows="5"></textarea>

		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="btn-red btn-plain btn" style="display:inline" value="Setuju" />
		<input type="submit" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" />
		<input type="button" class="btn-grey btn-plain btn ifclose" style="display:inline" value="Kembali" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'detail_proposal':

$Qdetail = $db->query("SELECT a.name, a.address, a.judul, a.latar_belakang, a.maksud_tujuan, a.time_entry, SUM(b.amount) AS mohon FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); 
$detail = $Qdetail->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">Detail Proposal Hibah Bansos <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/apps/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)" enctype="multipart/form-data">

		<p class="label">Nama (Individu atau Organisasi)</p>
        <p><?php echo $detail[0]->name ?></p>
        <p class="label">Alamat</p>
        <p><?php echo $detail[0]->address ?></p>
        <p class="label">Judul Kegiatan</p>
        <p><?php echo $detail[0]->judul ?></p>
        <p class="label">Latar Belakang</p>
        <p><?php echo $detail[0]->latar_belakang ?></p>
        <p class="label">Maksud dan Tujuan</p>
        <p><?php echo $detail[0]->maksud_tujuan ?></p>
        <p class="label">Nominan yang Diajukan di Proposal</p>
        <p><?php echo 'Rp. '.number_format($detail[0]->mohon,0,",",".").',-' ?></p>
        <p class="label">Tanggal Proposal Masuk</p>
        <p><?php echo date('M d, Y. g:i a', strtotime($detail[0]->time_entry)) ?></p>
        <p class="label">Tanggal Pemeriksaan TU</p>
        <p><?php echo date('M d, Y. g:i a', strtotime($detail[0]->time_entry)) ?></p>
        <p class="label">Tanggal Pemeriksaan Walikota</p>
        <p><?php echo date('M d, Y. g:i a', strtotime($detail[0]->time_entry)) ?></p>
        <p class="label">Tanggal Pemeriksaan Tim Pertimbangan</p>
        <p><?php echo date('M d, Y. g:i a', strtotime($detail[0]->time_entry)) ?></p>
        <p class="label">Tanggal Pemeriksaan SKPD</p>
        <p><?php echo date('M d, Y. g:i a', strtotime($detail[0]->time_entry)) ?></p>
        <p class="label">Tanggal Verifikasi Tim Pertimbangan</p>
        <p><?php echo date('M d, Y. g:i a', strtotime($detail[0]->time_entry)) ?></p>
        <p class="label">Tanggal Pemeriksaan TAPD</p>
        <p><?php echo date('M d, Y. g:i a', strtotime($detail[0]->time_entry)) ?></p>
        <p class="label">Tanggal Penyetujuan Walikota</p>
        <p><?php echo date('M d, Y. g:i a', strtotime($detail[0]->time_entry)) ?></p>

		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="button" class="btn-grey btn-plain btn ifclose" style="display:inline" value="Kembali" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'app':

$Qedit = $db->query("SELECT * FROM ak_pengaturan WHERE `id`='koordinator'"); 
$edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">MANAJEMEN APLIKASI (KOORDINATOR) <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/app/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)" enctype="multipart/form-data">
		<table border="0" width="100%">
		<tr height="30"><td class="pt9" width="95">Versi Aplikasi</td><td class="pt9" width="10">:</td><td><input type="text" name="version" class="inputbox w330" maxlength="5" value="<?php echo $edit[0]->konten ?>" /></td></tr>
		<tr><td class="pt5">Apk File</td><td class="pt5">:</td><td><input type="file" name="file" class="inputbox" /></td></tr>
		</table>
		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="button" value="Simpan" />
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'det_order':

$Qdetail = $db->query("SELECT a.*, b.nama AS user, b.telepon, c.nama AS pangkalan, d.nama AS ojeg
							FROM ak_order a
							JOIN ak_pengguna b ON b.pengguna_id=a.user_id
							JOIN ak_pangkalan c ON c.pangkalan_id=a.pangkalan_id
							LEFT JOIN ak_ojeg d ON d.ojeg_id=a.ojeg_id
							WHERE a.`order_id`='$dx'"); 
$detail = $Qdetail->getResult();
?>

<script>
function initMap() {
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var directionsService = new google.maps.DirectionsService;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 14,
    center: {lat: -6.918441, lng: 107.614658}
  });
  directionsDisplay.setMap(map);

  directionsService.route({
    origin: {lat: <?php echo $detail[0]->lat_dari ?>, lng: <?php echo $detail[0]->long_dari ?>},  // Haight.
    destination: {lat: <?php echo $detail[0]->lat_tujuan ?>, lng: <?php echo $detail[0]->long_tujuan ?>},  // Ocean Beach.
    // Note that Javascript allows us to access the constant
    // using square brackets and a string value as its
    // "property."
    travelMode: google.maps.TravelMode['DRIVING']
  }, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxYWRXoFSHOFCjuZZrDziGbog-u6SUCq4&callback=initMap" async defer></script>

<div id="ifbox_body">
	<div class="iheader">DETAIL ORDER<span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td colspan="3" id="map" style="height:250px"></td></tr>
		<tr height="30"><td width="40%">Tujuan</td><td>:</td><td><?php echo $detail[0]->loc_dari.' - '.$detail[0]->loc_tujuan ?></td></tr>
		<tr height="30"><td>Pangkalan</td><td>:</td><td><?php echo $detail[0]->pangkalan; ?></td></tr>
		<tr height="30"><td>Ojeg</td><td>:</td><td><?php if($detail[0]->ojeg) echo $detail[0]->ojeg; else echo '-'; ?></td></tr>
		<tr height="30"><td>Penumpang</td><td>:</td><td><?php echo $detail[0]->user.' ('.$detail[0]->telepon.')' ?></td></tr>
		<tr height="30"><td>Jasa</td><td>:</td><td><?php if($detail[0]->tipe_order==1) echo 'Transport'; else echo 'Barang'; ?></td></tr>
		<tr height="30"><td>Pembayaran</td><td>:</td><td><?php echo 'Rp. '.number_format($detail[0]->total_bayar,0,",","."); if($detail[0]->tipe_bayar==1) echo ' (Cash)'; elseif($detail[0]->tipe_bayar==2) echo ' (Transfer)'; ?></td></tr>
		<tr height="30"><td>Status</td><td>:</td><td><?php if($detail[0]->status==0) echo 'Baru'; elseif($detail[0]->status==1) echo 'Antar'; elseif($detail[0]->status==2) echo 'Selesai'; elseif($detail[0]->status==3) echo 'Batal'; elseif($detail[0]->status==4) echo 'Tolak'; ?></td></tr>
		<?php if($detail[0]->status==2){ ?>
		<tr height="30"><td>Penilaian</td><td>:</td><td><?php if($detail[0]->opsi==1) echo 'Sangat Puas'; elseif($detail[0]->opsi==2) echo 'Puas'; elseif($detail[0]->opsi==3) echo 'Cukup Puas'; elseif($detail[0]->opsi==4) echo 'Tidak Puas'; ?></td></tr>
		<tr height="30"><td>Deskripsi</td><td>:</td><td><?php echo $detail[0]->deskripsi; ?></td></tr>
		<?php } ?>
		</table>
		<div class="ifooter">
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>  
	</div>
</div>

<?php
break;

case 'add_koordinator':
?>

<div id="ifbox_body">
	<div class="iheader">TAMBAH KOORDINATOR <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/koordinator/add') ?>" method="post" enctype="multipart/form-data" id="iforms_f1" onsubmit="return iForms_s(1)">
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td width="150">Pangkalan</td><td width="10">:</td><td><select name="pangkalan"><option>-- Pilih Pangkalan</option> 
			<?php
			$Qcheck = $db->table('ak_koordinator')->select("pangkalan_id")->get();
			$not = array(); 
			foreach($Qcheck->getResult() as $check){ 
				array_push($not, $check->pangkalan_id);
			}

			$Qlist = $db->tabel('ak_pangkalan')->select("pangkalan_id, nama")->where_not_in('pangkalan_id', $not)->order_by('nama', 'ASC')->get();
			foreach($Qlist->getResult() as $list){ 
				echo '<option value="'.$list->pangkalan_id.'">'.$list->nama.'</option> ';
			}
			?>
			</select></td>
		</tr>
		<tr height="30"><td width="150">Nomor Identitas</td><td width="10">:</td><td><input type="text" name="no_identitas" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Nomor KTP</td><td width="10">:</td><td><input type="text" name="ktp" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Nama</td><td width="10">:</td><td><input type="text" name="nama" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Alamat</td><td width="10">:</td><td><input type="text" name="alamat" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Email</td><td width="10">:</td><td><input type="text" name="email" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Telepon</td><td width="10">:</td><td><input type="text" name="telepon" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Kata Sandi</td><td width="10">:</td><td><input type="password" name="pswd" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Foto</td><td width="10">:</td><td><input type="file" name="file" class="inputbox w330" /></td></tr>
		</table>
		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="button" value="Simpan" />
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'ed_koordinator':

$Qedit = $db->query("SELECT * FROM ak_koordinator WHERE `koordinator_id`='$dx'"); 
$edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">EDIT KOORDINATOR <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/koordinator/edit/'.$dx) ?>" method="post" enctype="multipart/form-data" id="iforms_f1" onsubmit="return iForms_s(1)">
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td width="150">Pangkalan</td><td width="10">:</td><td><select name="pangkalan"><option>-- Pilih Pangkalan</option> 
			<?php
			$Qcheck = $db->table('ak_koordinator')->select("pangkalan_id")->where('pangkalan_id !=', $edit[0]->pangkalan_id)->get();
			$not = array();
			foreach($Qcheck->getResult() as $check){ 
				array_push($not, $check->pangkalan_id);
			}

			if(empty($not)) $Qlist = $db->table('ak_pangkalan')->select("pangkalan_id, nama")->order_by('nama', 'ASC')->get();
			else $Qlist = $db->table('ak_pangkalan')->select("pangkalan_id, nama")->where_not_in('pangkalan_id', $not)->order_by('nama', 'ASC')->get();
			foreach($Qlist->getResult() as $list){ 
				echo '<option value="'.$list->pangkalan_id.'"'; if($list->pangkalan_id==$edit[0]->pangkalan_id) echo ' selected'; echo '>'.$list->nama.'</option> ';
			}
			?>
			</select></td>
		</tr>
		<tr height="30"><td width="150">Nomor Identitas</td><td width="10">:</td><td><input type="text" name="no_identitas" value="<?php echo $edit[0]->no_identitas ?>" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Nomor KTP</td><td width="10">:</td><td><input type="text" name="ktp" value="<?php echo $edit[0]->ktp ?>" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Nama</td><td width="10">:</td><td><input type="text" name="nama" class="inputbox w330" value="<?php echo $edit[0]->nama ?>" /></td></tr>
		<tr height="30"><td width="150">Alamat</td><td width="10">:</td><td><input type="text" name="alamat" class="inputbox w330" value="<?php echo $edit[0]->alamat ?>" /></td></tr>
		<tr height="30"><td width="150">Email</td><td width="10">:</td><td><input type="text" name="email" class="inputbox w330" value="<?php echo $edit[0]->email ?>" /></td></tr>
		<tr height="30"><td width="150">Telepon</td><td width="10">:</td><td><input type="text" name="telepon" class="inputbox w330" value="<?php echo $edit[0]->telepon ?>" /></td></tr>
		<tr height="30"><td width="150">Kata Sandi</td><td width="10">:</td><td><input type="password" name="pswd" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Foto</td><td width="10">:</td><td><input type="file" name="file" class="inputbox w330" /></td></tr>
		</table>
		<div class="ifooter">
		<input type="hidden" name="old" value="<?php echo $edit[0]->foto ?>" />
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="button" value="Simpan" />
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'det_koordinator':

$Qdetail = $db->query("SELECT a.*, b.nama AS pangkalan FROM ak_koordinator a JOIN ak_pangkalan b ON b.pangkalan_id=a.pangkalan_id WHERE a.`koordinator_id`='$dx'"); 
$detail = $Qdetail->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">DETAIL KOORDINATOR<span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td colspan="2" align="center"><img src="<?php echo $media.'image/'.$detail[0]->foto ?>" width="150"></td></tr>
		<tr height="30"><td width="50%">Nomor Identitas</td><td width="50%">: <?php echo $detail[0]->no_identitas ?></td></tr>
		<tr height="30"><td>Nomor KTP</td><td>: <?php echo $detail[0]->ktp ?></td></tr>
		<tr height="30"><td>Nama</td><td>: <?php echo $detail[0]->nama ?></td></tr>
		<tr height="30"><td>Alamat</td><td>: <?php echo $detail[0]->alamat ?></td></tr>
		<tr height="30"><td>Email</td><td>: <?php echo $detail[0]->email ?></td></tr>
		<tr height="30"><td>Telepon</td><td>: <?php echo $detail[0]->telepon ?></td></tr>
		<tr height="30"><td>Pangkalan</td><td>: <?php echo $detail[0]->pangkalan ?></td></tr>
		</table>
		<div class="ifooter">
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div> 	
	</div>
</div>

<?php
break;

case 'det_pengguna':

$Qdetail = $db->query("SELECT * FROM ak_pengguna WHERE `pengguna_id`='$dx'"); 
$detail = $Qdetail->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">DETAIL PENGGUNA<span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td width="50%">Nama</td><td>: <?php echo $detail[0]->nama ?></td></tr>
		<tr height="30"><td>Email</td><td>: <?php echo $detail[0]->email ?></td></tr>
		<tr height="30"><td>Telepon</td><td>: <?php echo $detail[0]->telepon ?></td></tr>
		<tr height="30"><td>Imei</td><td>: <?php echo $detail[0]->imei ?></td></tr>
		<tr height="30"><td>Status</td><td>: <?php if($detail[0]->status==1) echo 'Aktif'; else echo 'Blok'; ?></td></tr>
		</table>
		<div class="ifooter">
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div> 	
	</div>
</div>

<?php
break;

case 'add_pangkalan':
?>

<div id="ifbox_body">
	<div class="iheader">TAMBAH PANGKALAN <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/pangkalan/add') ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)">
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td width="150">Nama</td><td width="10">:</td><td><input type="text" name="nama" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Alamat</td><td width="10">:</td><td><input type="text" name="alamat" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Jam Buka</td><td width="10">:</td><td><input type="text" name="buka" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Jam Tutup</td><td width="10">:</td><td><input type="text" name="tutup" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Latitude</td><td width="10">:</td><td><input type="text" name="latitude" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Longitude</td><td width="10">:</td><td><input type="text" name="longitude" class="inputbox w330" /></td></tr>
		</table>
		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="button" value="Simpan" />
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'ed_pangkalan':

$Qedit = $db->query("SELECT * FROM ak_pangkalan WHERE `pangkalan_id`='$dx'"); 
$edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">EDIT PANGKALAN <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/pangkalan/edit/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)">
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td width="150">Nama</td><td width="10">:</td><td><input type="text" name="nama" class="inputbox w330" value="<?php echo $edit[0]->nama ?>" /></td></tr>
		<tr height="30"><td width="150">Alamat</td><td width="10">:</td><td><input type="text" name="alamat" class="inputbox w330" value="<?php echo $edit[0]->alamat ?>" /></td></tr>
		<tr height="30"><td width="150">Jam Buka</td><td width="10">:</td><td><input type="text" name="buka" class="inputbox w330" value="<?php echo $edit[0]->buka ?>" /></td></tr>
		<tr height="30"><td width="150">Jam Tutup</td><td width="10">:</td><td><input type="text" name="tutup" class="inputbox w330" value="<?php echo $edit[0]->tutup ?>" /></td></tr>
		<tr height="30"><td width="150">Latitude</td><td width="10">:</td><td><input type="text" name="latitude" class="inputbox w330" value="<?php echo $edit[0]->latitude ?>" /></td></tr>
		<tr height="30"><td width="150">Longitude</td><td width="10">:</td><td><input type="text" name="longitude" class="inputbox w330" value="<?php echo $edit[0]->longitude ?>" /></td></tr>
		</table>
		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="button" value="Simpan" />
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'det_pangkalan':

$Qdetail = $db->query("SELECT * FROM ak_pangkalan WHERE `pangkalan_id`='$dx'"); 
$detail = $Qdetail->getResult();
?>

<script>
function initMap() {
  var myLatLng = {lat: <?php echo $detail[0]->latitude ?>, lng: <?php echo $detail[0]->longitude ?>};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: myLatLng
  });

  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Hello World!'
  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxYWRXoFSHOFCjuZZrDziGbog-u6SUCq4&callback=initMap" async defer></script>

<div id="ifbox_body">
	<div class="iheader">DETAIL PANGKALAN<span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td colspan="3" id="map" style="height:250px"></td></tr>
		<tr height="30"><td width="50%">Nama</td><td width="50%">: <?php echo $detail[0]->nama ?></td></tr>
		<tr height="30"><td width="50%">Alamat</td><td width="50%">: <?php echo $detail[0]->alamat ?></td></tr>
		<tr height="30"><td width="50%">Jam Buka</td><td width="50%">: <?php echo date('H:i', strtotime($detail[0]->buka)) ?></td></tr>
		<tr height="30"><td width="50%">Jam Tutup</td><td width="50%">: <?php echo date('H:i', strtotime($detail[0]->tutup)) ?></td></tr>
		</table>
		<div class="ifooter">
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div> 	
	</div>
</div>

<?php
break;

case 'add_ojeg':
?>

<div id="ifbox_body">
	<div class="iheader">TAMBAH OJEG <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/ojeg/add') ?>" method="post" id="iforms_f1" enctype="multipart/form-data" onsubmit="return iForms_s(1)">
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td width="150">Pangkalan</td><td width="10">:</td><td><select name="pangkalan"><option>-- Pilih Pangkalan</option> 
			<?php
			$Qlist = $db->table('ak_pangkalan')->select("pangkalan_id, nama")->order_by('nama', 'ASC')->get();
			foreach($Qlist->getResult() as $list){ 
				echo '<option value="'.$list->pangkalan_id.'">'.$list->nama.'</option> ';
			}
			?>
			</select></td>
		</tr>
		<tr height="30"><td width="150">Nomor Identitas</td><td width="10">:</td><td><input type="text" name="no_identitas" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Nomor KTP</td><td width="10">:</td><td><input type="text" name="ktp" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Nama</td><td width="10">:</td><td><input type="text" name="nama" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Alamat</td><td width="10">:</td><td><input type="text" name="alamat" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Telepon</td><td width="10">:</td><td><input type="text" name="telepon" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Foto</td><td width="10">:</td><td><input type="file" name="file" class="inputbox w330" /></td></tr>
		</table>
		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="button" value="Simpan" />
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'ed_ojeg':

$Qedit = $db->query("SELECT * FROM ak_ojeg WHERE `ojeg_id`='$dx'"); 
$edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">EDIT OJEG <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/ojeg/edit/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)">
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">

		<tr height="30"><td width="150">Pangkalan</td><td width="10">:</td><td><select name="pangkalan"><option>-- Pilih Pangkalan</option> 
			<?php
			$Qlist = $db->table('ak_pangkalan')->select("pangkalan_id, nama")->order_by('nama', 'ASC')->get();
			foreach($Qlist->getResult() as $list){ 
				echo '<option value="'.$list->pangkalan_id.'"'; if($edit[0]->pangkalan_id==$list->pangkalan_id) echo ' selected'; echo '>'.$list->nama.'</option> ';
			}
			?>
			</select></td>
		</tr>
		<tr height="30"><td width="150">Nomor Identitas</td><td width="10">:</td><td><input type="text" name="no_identitas" value="<?php echo $edit[0]->no_identitas ?>" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Nomor KTP</td><td width="10">:</td><td><input type="text" name="ktp" value="<?php echo $edit[0]->ktp ?>" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Nama</td><td width="10">:</td><td><input type="text" name="nama" value="<?php echo $edit[0]->nama ?>" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Alamat</td><td width="10">:</td><td><input type="text" name="alamat" value="<?php echo $edit[0]->alamat ?>" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Telepon</td><td width="10">:</td><td><input type="text" name="telepon" value="<?php echo $edit[0]->telepon ?>" class="inputbox w330" /></td></tr>
		<tr height="30"><td width="150">Foto</td><td width="10">:</td><td><input type="file" name="file" class="inputbox w330" /></td></tr>
		</table>
		<div class="ifooter">
		<input type="hidden" name="old" value="<?php echo $edit[0]->foto ?>">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="button" value="Simpan" />
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'det_ojeg':

$Qdetail = $db->query("SELECT a.*, b.nama AS pangkalan FROM ak_ojeg a JOIN ak_pangkalan b ON b.pangkalan_id=a.pangkalan_id WHERE a.`ojeg_id`='$dx'"); 
$detail = $Qdetail->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">DETAIL OJEG<span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td colspan="2" align="center"><img src="<?php echo $detail[0]->foto ?>" width="150"></td></tr>
		<tr height="30"><td width="50%">Pangkalan</td><td width="50%">: <?php echo $detail[0]->pangkalan ?></td></tr>
		<tr height="30"><td>Nomor Identitas</td><td>: <?php echo $detail[0]->no_identitas ?></td></tr>
		<tr height="30"><td>Nomor KTP</td><td>: <?php echo $detail[0]->ktp ?></td></tr>
		<tr height="30"><td>Nama</td><td>: <?php echo $detail[0]->nama ?></td></tr>
		<tr height="30"><td>Alamat</td><td>: <?php echo $detail[0]->alamat ?></td></tr>
		<tr height="30"><td>Telepon</td><td>: <?php echo $detail[0]->telepon ?></td></tr>
		</table>
		<div class="ifooter">
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div> 	
	</div>
</div>

<?php
break;

case 'harga':

$Qedit = $db->query("SELECT konten FROM ak_pengaturan WHERE `id`='harga'"); 
$edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">HARGA <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/harga/edit') ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)">
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
		<tr height="30"><td width="150">Harga (km)</td><td width="10">:</td><td><input type="text" name="harga" class="inputbox w330" value="<?php echo $edit[0]->konten ?>" /></td></tr>
		</table>
		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="button" value="Simpan" />
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

case 'ed_profil':

$Qedit = $db->query("SELECT * FROM ak_admin WHERE `admin_id`='$dx'"); 
$edit = $Qedit->getResult();
?>

<div id="ifbox_body">
    <div class="iheader">EDIT AKUN <span class="ifclose" title="Tutup">X</span></div>
    <div class="ibody">
    	<div id="iforms_r1" style="text-align:center"></div>
        <form action="<?php echo site_url('process/admin/profil/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)">
        <table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
        <tr height="30"><td width="150">Nama Pengguna</td><td width="10">:</td><td><input type="text" name="uname" class="inputbox w330" value="<?php echo $edit[0]->username ?>" /></td></tr>
        <tr height="30"><td width="150">Kata Sandi</td><td width="10">:</td><td><input type="password" name="pswd" class="inputbox w330" /></td></tr>
        <!-- <tr height="30"><td width="150">Nama Lengkap</td><td width="10">:</td><td><input type="text" name="name" class="inputbox w330" value="<?php echo $edit[0]->nama ?>" /></td></tr>
        <tr height="30"><td width="150">Email</td><td width="10">:</td><td><input type="text" name="email" class="inputbox w330" value="<?php echo $edit[0]->email ?>" /></td></tr> -->
        </table>
        <div class="ifooter">
        <input type="hidden" id="timereload" value="2" />
        <input type="submit" class="button" value="Simpan" />
        <input type="button" class="buttons ifclose" value="Tutup" />
        </div>
        </form>    	
	</div>
</div>

<?php
break;

case 'ed_status':

$Qedit = $db->query("SELECT status, warning FROM ak_pengguna WHERE `pengguna_id`='$dx'"); 
$edit = $Qedit->getResult();
?>

<div id="ifbox_body">
	<div class="iheader">EDIT STATUS <span class="ifclose" title="Tutup">X</span></div>
	<div class="ibody">
		<div id="iforms_r1" style="text-align:center"></div>
		<form action="<?php echo site_url('process/pengguna/status/'.$dx) ?>" method="post" id="iforms_f1" onsubmit="return iForms_s(1)">
		<table border="0" width="100%" class="list" cellpadding="0" cellspacing="0">
        <tr height="30"><td width="150">Peringatan</td><td width="10">:</td><td><?php echo $edit[0]->warning ?></td></tr>
		<tr height="30"><td width="150">Status</td><td width="10">:</td><td><input type="radio" name="status" value="1" class="inputbox w330" <?php if($edit[0]->status==1) echo ' checked' ?> /> Aktif &nbsp <input type="radio" name="status" value="2" class="inputbox w330" <?php if($edit[0]->status==2) echo ' checked' ?> /> Blok</td></tr>
		</table>
		<div class="ifooter">
		<input type="hidden" id="timereload" value="2" />
		<input type="submit" class="button" value="Simpan" />
		<input type="button" class="buttons ifclose" value="Tutup" />
		</div>
		</form>    	
	</div>
</div>

<?php
break;

}
?>
<?= $this->endSection(); ?>