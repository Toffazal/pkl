<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Kelompok;
use \App\Models\Permohonan;

    $User = new User;
    $Kelompok = new Kelompok;
    $Permohonan = new Permohonan;

?>
<?= $this->extend('kajur/template'); ?>

<?= $this->section('content'); ?>
            
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title text-primary">Kelompok</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Kelompok</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

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


                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-12 d-none d-lg-block">
                        <div class="white-box">
                            <img src="<?= base_url('public/icon.webp'); ?>" width="100%">
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="<?= base_url('kajur/simpanKelompok'); ?>" class="form-horizontal form-material">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="pid" value="<?= $pembimbing->id; ?>">

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0 bold">Nama Pembimbing</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <p><?= $pembimbing->nama; ?></p>
                                        </div>
                                    </div>

                                    <?php if($tempatPKL != ''){$tempat = $tempatPKL->tempat_pkl;}else{$tempat = '';} ?>

                                     <div class="form-group mb-4">
                                        <label class="col-md-12 p-0 bold">Tempat PKL</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" name="tempat_pkl"
                                                class="form-control p-0 border-0 <?= ($validation->hasError('tempat_pkl')) ? 'is-invalid' : ''; ?>" value="<?= $tempat; ?>" required> 
                                        </div>
                                    </div>


                                <?php $no = 1; $n =1; foreach($aktif as $j) {  $siswa = $User->where('id', $j->uid)->first(); 
                                $pkl = $Permohonan->where(['uid' => $j->uid, 'status' => 3])->first(); ?>
                                    <p><i class="fas fa-circle-minus text-danger" style="cursor: pointer;" onclick="hapusKelompok(<?=$siswa->id;?>, <?= $pembimbing->id; ?>);"></i> [<?= $siswa->kelas; ?>] <?= $siswa->nama; ?> (<?= $pkl->tempat_pkl; ?>)</p>
                                <?php } ?>


                                <?php $no = 1; $n =1; foreach($permohonan as $j) {  $siswa = $User->where('id', $j->uid)->first(); 
                                $pkl = $Permohonan->where(['uid' => $j->uid, 'status' => 2])->first(); ?>
                                    <div class="form-check">
                                        <input name="nama[]" class="form-check-input" type="checkbox" id="inlineCheckbox<?=$n++;?>" value="<?= $siswa->id; ?>">
                                        <label class="form-check-label" for="inlineCheckbox<?=$no++;?>">[<?= $siswa->kelas; ?>] <?= $siswa->nama; ?> (<?= $pkl->tempat_pkl; ?>)</label>
                                    </div>
                                <?php } ?>


                                    <div class="form-group mb-4 mt-3">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success float-end">Simpan Kelompok</button>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->

               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<?= $this->endSection(); ?>
            