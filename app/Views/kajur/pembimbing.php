<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Kelompok;

    $User = new User;
    $Kelompok = new Kelompok;

?>

<?= $this->extend('kajur/template'); ?>

<?= $this->section('content'); ?>
            
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title text-primary">Pembimbing</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Pembimbing</a></li>
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

                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Pembimbing</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                <li>
                                    <div id="sparklinedash"><canvas width="67" height="30"
                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                    </div>
                                </li>
                                <li class="ms-auto"><span class="counter text-success"><?= count($pembimbing); ?></span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Siswa</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                <li>
                                    <div id="sparklinedash2"><canvas width="67" height="30"
                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                    </div>
                                </li>
                                <li class="ms-auto"><span class="counter text-purple"><?= count($siswa); ?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>

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
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Daftar Guru Pembimbing</h3>
                            <div class="table-responsive">
                                <table class="table text-nowrap search-table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Tempat PKL</th>
                                            <th class="border-top-0">Jumlah Siswa</th>
                                            <th class="border-top-0">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php $no=1; foreach($pembimbing as $d) { ?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $d->nama; ?></td>
                                        <?php $anggota = $Kelompok->where(['pid' => $d->id, 'status' => 0])->first(); 
                                              $anggotaa = $Kelompok->where(['pid' => $d->id, 'status' => 0])->find(); ?>
                                            <td><?php if($anggota) {echo $anggota->tempat_pkl;}else{echo "Belum ditentukan";} ?></td>
                                            <td><?= count($anggotaa); ?></td>
                                            <td>
                                                <a href="<?= base_url('kajur/tambahKelompok/'.$d->id); ?>" class="btn btn-primary btn-sm" title="Tambah  Kelompok">Kelompok</a>
                                            </td>
                                        </tr>
                            <?php }  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<?= $this->endSection(); ?>
            