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
	<link href="<?= base_url('public/css/style.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/style.css'); ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap" rel="stylesheet">

</head>
<body>
		<img src="<?=base_url("public/img/sertifikat_depan.png");?>" class="w-100">


		<h1 class="text-center position-relative d-none d-lg-block" style="font-family: 'Roboto Slab', serif;; font-size: 60px; top: -500px;"><?= $siswa->nama; ?></h1>

		<h1 class="text-center position-relative d-xl-none" style="font-family: 'Roboto Slab', serif;; font-size: 60px; top: -420px;"><?= $siswa->nama; ?></h1>
</body>

<script type="text/javascript">window.print();</script>
</html>