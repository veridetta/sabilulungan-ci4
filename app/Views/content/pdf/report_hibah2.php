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
		<body style="padding:10px">
			<div style="float: right; width:40%">
				<p style="margin:2px !important;">LAMPIRAN II</p>
				<p style="margin:2px !important;">PERATURAN BUPATI MEMPAWAH NOMOR  TAHUN 2023</p>
				<p style="margin:2px !important;">TENTANG</p>
				<p style="margin:2px !important;">PEMBERIAN HIBAH PEMERINTAH KABUPATEN MEMPAWAH</p>
			</div>
			<div style="clear: both;"></div>
			<br>
			<p align="center">HASIL EVALUASI ATAS USULAN/PROPOSAL HIBAH<br>
			DALAM BENTUK UANG<br></p>
			
			<br>
			<table width="100%" border="1" >
				<thead style="background-color: black; color:white;">
					<tr style="padding: 5px;">
						<th style="text-align:center;">No</th>
						<th style="text-align:center;">Nama Calon Penerima Hibah</th>
						<th style="text-align:center;">Uraian Usulan</th>
						<th style="text-align:center;">Jumlah</th>
						<th style="text-align:center;">Besaran / Nilai Hibah Yang Disetujui</th>
					</tr>
					<tr>
						<th style="text-align:center;">1</th>
						<th style="text-align:center;">2</th>
						<th style="text-align:center;">3</th>
						<th style="text-align:center;">4</th>
						<th style="text-align:center;">5</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$builder = $db->table('proposal');
					$builder->select("proposal.id, proposal.name, proposal.maksud_tujuan, proposal.address, proposal.judul, proposal.current_stat, proposal.nphd, proposal.tanggal_lpj, proposal_checklist.value, 
					(SELECT SUM(amount) FROM proposal_dana WHERE proposal_dana.proposal_id = proposal.id) as total_amount");
					$builder->join('proposal_checklist', 'proposal.id = proposal_checklist.proposal_id');
					if (isset($_POST['keyword'])) {
						$builder->like('proposal.judul', $_POST['keyword']);
					}
					$builder->where('proposal_checklist.checklist_id', 28);
					$builder->where('YEAR(proposal.time_entry) >=', date('Y'));
					$builder->orderBy('proposal.id', 'DESC');
					$Qlist = $builder->get()->getResult();
					if(count($Qlist)){
						$no=1;
						foreach($Qlist as $row){
							echo '<tr>
								<td style="text-align:center;">'.$no.'</td>
								<td>'.$row->name.'</td>
								<td>'.$row->maksud_tujuan.'</td>
								<td style="text-align:center;">Rp.'.number_format($row->total_amount, 0, ',', '.').'</td>
								<td style="text-align:center;">Rp. '.number_format($row->value, 0, ',', '.').'</td>
							</tr>';
							$no++;
						}
						?>
						<?php
					}else echo '<tr><td align="center" colspan="12">No data.</td></tr>';
						echo '</tbody></table>';
						?>
				</tbody>
			</table>

			<?php $bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember') ?>
			<div style="float: right; width:35%">
			<p>Bandung, <?php echo date('j').' '.$bulan[date('n')].' '.date('Y'); ?></p>
			<p>KEPALA SKPD .........................,</p>
			<br>
			
			<br>
			<br>
			<br>
			<br>
			<p> .................................................</p>
			</div>
			<div style="clear: both;"></div>
		</body>
		</html>