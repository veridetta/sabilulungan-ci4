<!DOCTYPE html>
		<html>
		<head>
			<title></title>
		</head>
		<style type="text/css">
		table tr td{
			vertical-align: top
		}
		</style>
		<body>
			<table align="right" border="1" cellpadding="0" cellspacing="0" width="100"><tr><td align="center">HIBAH</td></tr></table><br>
			<p align="center"><span style="font-size:20px">REKOMENDASI</span><br>
			PEMBERIAN BELANJA HIBAH DAN BELANJA BANTUAN SOSIAL YANG<br>
			BERSUMBER DARI ANGGARAN PENDAPATAN DAN BELANJA DAERAH</p>
			<hr>
			<!-- <hr style="border: 2px solid #000;margin-top: -8px;"> -->

			<p>Yang bertanda tangan di bawah ini, kami telah melakukan evaluasi Proposal yang disusulkan oleh Permohonan Belanja Hibah dan memberikan Rekomendasi sebagai berikut:</p>

			<?php
			$Qisi = $db->query("SELECT a.id, a.judul, a.name, b.name AS ketua, b.address, a.maksud_tujuan, SUM(c.amount) AS usulan  FROM proposal a JOIN user b ON b.id=a.user_id JOIN proposal_dana c ON c.proposal_id=a.id WHERE a.id='$tp'");
			$isi = $Qisi->getResult(); $id = $isi[0]->id;

			$Qbesar = $db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$id' AND checklist_id IN (26,27)"); $besar = $Qbesar->getResult();

			?>

			<table width="100%" >
				<tr><td width="3%">1.</td><td width="37%">NAMA KEGIATAN</td><td>:</td><td width="60%"><?php echo $isi[0]->judul ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>2.</td><td>NAMA ORGANISASI / KEPANITIAAN</td><td>:</td><td><?php echo $isi[0]->name ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>3.</td><td>NAMA KETUA/PIMPINAN ORGANISASI / KEPANITIAAN</td><td>:</td><td><?php echo $isi[0]->ketua ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>4.</td><td>ALAMAT ORGANISASI / KEPANITIAAN</td><td>:</td><td><?php echo $isi[0]->address ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>5.</td><td>RENCANA PELAKSANAAN KEGIATAN</td><td>:</td><td><?php echo $isi[0]->maksud_tujuan ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>6.</td><td>BESARNYA USULAN</td><td>:</td><td>Rp. <?php echo number_format($isi[0]->usulan,0,",","."); echo ',-'; ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>7.</td><td>BESARNYA REKOMENDASI</td><td>:</td><td><?php if(isset($besar[0]->value)) echo 'Rp. '.number_format($besar[0]->value,0,",",".").',-'; else echo '-'; ?></td></tr>
				<tr><td colspan="3"></td></tr>
				<tr><td>8.</td><td>CATATAN</td><td>:</td><td><?php if(isset($besar[1]->value)) echo $besar[1]->value; else echo '-'; ?></td></tr>
				<tr><td colspan="3"></td></tr>
			</table>

			<?php $bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember') ?>
			<p align="right">Bandung, <?php echo date('j').' '.$bulan[date('n')].' '.date('Y'); ?></p>
			<br>

			<table width="100%" border="1" cellpadding="0" cellspacing="0">
				<tr><td align="center" width="40%">JABATAN</td><td align="center" width="40%">NAMA/NIP</td><td align="center" width="20%">TANDA TANGAN</td></tr>
				<tr><td>Kepala SKPD................................</td><td></td><td></td></tr>
				<tr><td>Camat................................</td><td></td><td></td></tr>
				<tr><td>Lurah................................</td><td></td><td></td></tr>
			</table>

			<br>
			<p>Telah dilakukan pembahasan<br>Pada tanggal..........................</p>
			<p>Ketua Tim Pertimbangan Pemberian<br>Belanja Hibah dan Belanja Bantuan Sosial</p>
			<br>
			<p>....................................................................</p>
		</body>
		</html>