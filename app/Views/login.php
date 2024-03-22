<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta name="description" content="Aplikasi Sistem Informasi Pengolahan Praktek Kerja Lapangan">
    <meta name="keyword" content="SMK Negeri 1 Tanjung Pura, Aplikasi Pengelola Praktek Kerja Lapangan">

    <!-- Icon -->
    <link rel="shortcut icon" href="<?=base_url('public/icon.webp');?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url('public/bootstrap/dist/css/bootstrap.min.css');?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Odibee+Sans&display=swap" rel="stylesheet">

    <!-- Fonts Awesome -->
    <link href="<?=base_url('public/fontawesome/css/all.css');?>" rel="stylesheet">

    <title><?=$title;?></title>
  </head>

  <body class="bg-white" style="overflow-x: hidden;">


<div class="bg-light shadow px-4 pt-3 my-5 mx-auto d-none d-lg-block" style="width: 400px; border: 1px solid lightgray; border-radius: 15px;">

  <center><img src="<?= base_url('public/icon.webp'); ?>" alt="Logo Kabupaten Langkat" width="70px" height="70px"></center>

  <h2 class="text-center text-primary mb-4" style="font-family: 'PT Sans', sans-serif;">Halaman Login</h2>

 <?php if(session()->getFlashdata('danied')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <?= session()->getFlashdata('danied'); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
  <?php endif; ?>

  <?php if(session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
  <?= session()->getFlashdata('pesan'); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
  <?php endif; ?>

<form method="post" action="<?=base_url('auth/prosesLogin');?>">
  <?= csrf_field(); ?>

  <label for="username" class="form-label mb-1 mt-2 ms-2" style="border-radius: 50px;">Username / Nomor Induk Siswa (NIS)</label>
      <input id="username" name="username" type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" style="border-radius: 30px; font-size: 17px;">
      <div class="invalid-feedback">
        <?= $validation->getError('username'); ?>
      </div>

      <label for="password" class="form-label ms-2 mt-4" style="border-radius: 50px;">Password</label>
      <input id="password" name="password" type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" style="border-radius: 30px; font-size: 17px;">
            <span id="mybutton" onclick="change()" style="float: right; position: relative; top: -27px; right: 10px;">
                    <i class="fa-solid fa-eye"></i>
            </span>
      <div class="invalid-feedback">
        <?= $validation->getError('password'); ?>
      </div>
          
  <button style="border-radius: 30px;" name="simpan" type="submit" class="btn btn-primary text-white d-block mt-5 mb-4 w-100">Login</button>
</form>

<p class="text-center text-secondary"><small>Aplikasi Sistem Informasi Praktek Kerja Lapangan</small></p>

</div>



<center>
<div class="bg-light shadow px-4 pt-3 my-5 d-lg-none" style="width: 96%; border: 1px solid lightgray; border-radius: 15px;">

  <center><img src="<?= base_url('public/icon.webp'); ?>" alt="Logo Kabupaten Langkat" width="70px" height="70px"></center>

  <h2 class="text-center text-success mb-4" style="font-family: 'PT Sans', sans-serif;">Halaman Login</h2>

 <?php if(session()->getFlashdata('danied')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <?= session()->getFlashdata('danied'); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
  <?php endif; ?>

  <?php if(session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
  <?= session()->getFlashdata('pesan'); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
  <?php endif; ?>

<form method="post" action="<?=base_url('auth/prosesLogin');?>" style="text-align: left;">
  <?= csrf_field(); ?>

  <label for="username" class="form-label mb-1 mt-2 ms-2">Username / Nomor Induk Siswa (NIS)</label>
      <input id="username" name="username" type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" style="border-radius: 30px; font-size: 17px;">
      <div class="invalid-feedback">
        <?= $validation->getError('username'); ?>
      </div>

      <label for="pass" class="form-label ms-2 mt-4">Password</label>
      <input id="pass" name="password" type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" style="border-radius: 30px; font-size: 17px;">
            <span id="mybuttonn" onclick="changee()" style="float: right; position: relative; top: -27px; right: 10px;">
                    <i class="fa-solid fa-eye"></i>
            </span>
      <div class="invalid-feedback">
        <?= $validation->getError('password'); ?>
      </div>
          
  <button style="border-radius: 30px;" name="simpan" type="submit" class="btn btn-primary text-white d-block mt-5 mb-4 w-100">Login</button>

</form>

<p class="text-center text-secondary"><small>Aplikasi Sistem Informasi Praktek Kerja Lapangan</small></p>

</div>
</center>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="<?=base_url('public/bootstrap/dist/js/bootstrap.bundle.min.js');?>"></script> 
    <script>
            // membuat fungsi change
            function change() {
    
                // membuat variabel berisi tipe input dari id='pass', id='pass' adalah form input password 
                var x = document.getElementById('password').type;
    
                //membuat if kondisi, jika tipe x adalah password maka jalankan perintah di bawahnya
                if (x == 'password') {
    
                    //ubah form input password menjadi text
                    document.getElementById('password').type = 'text';
                    
                    //ubah icon mata terbuka menjadi tertutup
                    document.getElementById('mybutton').innerHTML = `<i class="fa-solid fa-eye-slash"></i>`;
                }
                else {
    
                    //ubah form input password menjadi text
                    document.getElementById('password').type = 'password';
    
                    //ubah icon mata terbuka menjadi tertutup
                    document.getElementById('mybutton').innerHTML = `<i class="fa-solid fa-eye"></i>`;
                }
            }



            // membuat fungsi change
            function changee() {
    
                // membuat variabel berisi tipe input dari id='pass', id='pass' adalah form input password 
                var x = document.getElementById('pass').type;
    
                //membuat if kondisi, jika tipe x adalah password maka jalankan perintah di bawahnya
                if (x == 'password') {
    
                    //ubah form input password menjadi text
                    document.getElementById('pass').type = 'text';
                    
                    //ubah icon mata terbuka menjadi tertutup
                    document.getElementById('mybuttonn').innerHTML = `<i class="fa-solid fa-eye-slash"></i>`;
                }
                else {
    
                    //ubah form input password menjadi text
                    document.getElementById('pass').type = 'password';
    
                    //ubah icon mata terbuka menjadi tertutup
                    document.getElementById('mybuttonn').innerHTML = `<i class="fa-solid fa-eye"></i>`;
                }
            }
            </script>

  </body>
</html>