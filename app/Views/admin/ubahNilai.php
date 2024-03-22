<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Nilai;

    $User = new User;
    $Nilai = new Nilai;

?>
<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
            
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title text-primary">Penilaian</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal"><?= $siswa->nama; ?></a></li>
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

<div class="white-box">
    <p class="fs-4 mb-1"><b>Nama :</b> <?= $siswa->nama; ?></p>
    <p class="fs-4 mb-1"><b>Kelas :</b> <?= $siswa->kelas; ?></p>
    <p class="fs-4 mb-1"><b>Tempat PKL :</b> <?= $kelompok->tempat_pkl; ?></p>
    <p class="fs-4 mb-1"><b>Guru Pembimbing :</b> <?= $pembimbing->nama; ?></p>
</div>

                <!-- Row -->
                     <form method="post" action="<?= base_url('admin/updateNilai'); ?>" class="form-horizontal form-material" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="uid" value="<?= $siswa->id; ?>">
                        <input type="hidden" name="jid" value="<?= $jurusan->id; ?>">

                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-primary bold mb-4">Penilaian Non-Teknis</h5>
                            <?php foreach($nonTeknis as $n) { $nilai = $Nilai->where(['uid' => $siswa->id, 'idp' => $n->id])->first(); ?>
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0" style="font-weight: bold;"><?= $n->nama; ?></label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="number" name="<?= $n->id; ?>" class="form-control p-0 border-0" value="<?php if($nilai){echo $nilai->nilai;}else{echo '';} ?>" required> 
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-primary bold mb-4">Penilaian Teknis</h5>
                            <?php foreach($teknis as $t) { $nilai = $Nilai->where(['uid' => $siswa->id, 'idp' => $t->id])->first();?>
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0" style="font-weight: bold;"><?= $t->nama; ?></label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="number" name="<?= $t->id; ?>" class="form-control p-0 border-0" value="<?php if($nilai){echo $nilai->nilai;}else{echo '';} ?>" required> 
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <div class="form-group mb-4 w-100">
                        <button type="submit" class="btn btn-success w-100">Simpan Penilaian</button>
                    </div>

                </div>
                <!-- Row -->
                </form>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<?= $this->endSection(); ?>
            