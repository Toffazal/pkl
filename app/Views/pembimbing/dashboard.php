<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Kelompok;
use \App\Models\Permohonan;

    $User = new User;
    $Permohonan = new Permohonan;
    $Kelompok = new Kelompok;

?>
<?= $this->extend('pembimbing/template'); ?>

<?= $this->section('content'); ?>
            
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title text-primary">Dashboard</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Dashboard</a></li>
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

                <?php
                    $pembimbing = $User->where('id', $user->id)->first(); 
                    $data = $Kelompok->where(['pid' => $pembimbing->id, 'status' => 0])->first(); 
                    $siswa = $Kelompok->where(['pid' => $pembimbing->id, 'status' => 0])->find();
                ?>

                <?php if($siswa) { ?>
                    <a href="<?= base_url('pembimbing/selesai/'.$user->id); ?>" class="float-end btn btn-success btn-sm text-white" onclick="return confirm('Pastikan sudah benar-benar selesai PKL!');">Selesai</a>
                <?php } ?>

                <div class="white-box">
                    <h4 class="text-info bold"><i class="fas fa-users"></i> DAFTAR PESERTA</h4>
               <br>

                    <h5><b>Tempat PKL :</b> <?php if($data){echo $data->tempat_pkl;}else{echo "Belum ditentukan";} ?></h5>
                    <h5><b>Guru Pembimbing :</b> <?= $pembimbing->nama; ?></h5>
                    <h5><b>Telepon :</b> <?= $pembimbing->telepon; ?></h5>

                        <div class="row">
                    <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Kelas</th>
                                            <th class="border-top-0">Telepon</th>
                                            <th class="border-top-0">Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php $no=1; foreach($siswa as $d) { $p = $User->where('id', $d->uid)->first(); 
                            $pkl = $Permohonan->where(['uid' => $p->id, 'status' => 3])->first()?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $p->nama; ?> <br> <small class="text-secondary"><?php if($data){echo $pkl->tempat_pkl;} ?></small></td>
                                            <td style="vertical-align: middle;"><?= $p->kelas; ?></td>
                                            <td style="vertical-align: middle;"><?= $p->telepon; ?></td>
                                            <td style="vertical-align: middle;"><a href="<?= base_url('public/img/'.$p->foto); ?>" target="_blank">Lihat Foto</a></td>
                                        </tr>
                            <?php }  ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
                    <?php  ?>
                    

                </div>

               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<?= $this->endSection(); ?>
            