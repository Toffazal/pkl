<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Nilai;
use \App\Models\Jurusann;

    $User = new User;
    $Nilai = new Nilai;
    $Jurusan = new Jurusann;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="refresh" content="2;url=<?=base_url('admin/sertifikat');?>">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Icon -->
    <link rel="shortcut icon" href="<?=base_url('public/icon.webp');?>">
	<title><?= $title; ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<link href="<?= base_url('public/css/style.css'); ?>" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

</head>
<body style="background: url('<?= base_url("public/img/nilai.jpg"); ?>'); background-size: 100%;">

	<h2 class="text-center bold mt-5" style="font-family: 'Lato', sans-serif;">DAFTAR NILAI PRAKTEK KERJA LAPANGAN</h2>

	<p class="ms-5 mt-5 mb-1 bold" style="text-transform: uppercase; font-family: 'Lato', sans-serif;">NAMA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $siswa->nama; ?></p>
	<p class="ms-5 mb-1 bold" style="text-transform: uppercase; font-family: 'Lato', sans-serif;">NIS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $siswa->nis; ?></p>
	<?php $jurusan = $Jurusan->where('id', $siswa->jurusan)->first(); ?>
	<p class="ms-5 mb-1 bold" style="text-transform: uppercase; font-family: 'Lato', sans-serif;">JURUSAN : <?= $jurusan->nama; ?></p>
	<p class="ms-5 bold" style="text-transform: uppercase; font-family: 'Lato', sans-serif;">TEMPAT &nbsp;&nbsp;&nbsp;&nbsp;: <?= $permohonan->tempat_pkl; ?></p>

	<div class="row mx-5">

		<div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6">
			<table class="table table-sm table-bordered">
  				<thead>
    				<tr>
      					<th scope="col" class="text-center">No.</th>
      					<th scope="col" class="text-center">Nilai Kepribadian</th>
      					<th scope="col" class="text-center">Nilai</th>
      					<th scope="col" class="text-center">Predikat</th>
    				</tr>
  				</thead>
  				<tbody>
  				<?php $no = 1; foreach($nonTeknis as $n) { $nilai = $Nilai->where(['uid' => $siswa->id, 'idp' => $n->id])->first(); 

  				//Rumus Penilaian
  				if($nilai->nilai < 70)
  				{
  					$predikat = "C";
  				}

  				if($nilai->nilai >= 70)
  				{
  					$predikat = "B";
  				}

  				if($nilai->nilai > 85)
  				{
  					$predikat = "A";
  				}

  				?>
    				<tr>
      					<td class="text-center"><?= $no++; ?>.</td>
      					<td><?= $n->nama; ?></td>
      					<td class="text-center"><?= $nilai->nilai; ?></td>
      					<td class="text-center"><?= $predikat; ?></td>
    				</tr>
    			<?php } ?>
  				</tbody>
			</table>
		</div>

		<div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6">
			<table class="table table-sm table-bordered">
  				<thead>
    				<tr>
      					<th scope="col" class="text-center">No.</th>
      					<th scope="col" class="text-center">Nilai Kompetensi/Keahlian</th>
      					<th scope="col" class="text-center">Nilai</th>
      					<th scope="col" class="text-center">Predikat</th>
    				</tr>
  				</thead>
  				<tbody>
  				<?php $no = 1; foreach($teknis as $n) { $nilai = $Nilai->where(['uid' => $siswa->id, 'idp' => $n->id])->first(); 

  				//Rumus Penilaian
  				if($nilai->nilai < 70)
  				{
  					$predikat = "C";
  				}

  				if($nilai->nilai >= 70)
  				{
  					$predikat = "B";
  				}

  				if($nilai->nilai > 85)
  				{
  					$predikat = "A";
  				}

  				?>
    				<tr>
      					<td class="text-center"><?= $no++; ?>.</td>
      					<td><?= $n->nama; ?></td>
      					<td class="text-center"><?= $nilai->nilai; ?></td>
      					<td class="text-center"><?= $predikat; ?></td>
    				</tr>
    			<?php } ?>
  				</tbody>
			</table>

			<?php 
				$timezone = time() + (60 * 60 * 7);
        	?>
			<p class="text-end mb-1">Tanjung Pura, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?=gmdate('F Y', $timezone);?> </p>
			<p class="text-end mb-5">Pembimbing Insdustri</p>
			<br>
			<hr class="float-end" width="250px">
			
		</div>

	</div>
	
</body>
<script type="text/javascript">window.print();</script>
</html>