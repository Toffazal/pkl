<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Permohonan;
use \App\Models\Kelompok;

    $User = new User;
    $Permohonan = new Permohonan;
    $Kelompok = new Kelompok;

?>
<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
            
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title text-primary">Sertifikat</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Certificate</a></li>
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
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Siswa Terdaftar</h3>
                            <div class="table-responsive">
                                <table class="table text-nowrap search-table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">No.</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Tempat PKL</th>
                                            <th class="border-top-0">Pembimbing</th>
                                            <th class="border-top-0">Sertifikat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach($siswa as $d) { 
                                    $user = $User->where('id', $d->uid)->first(); 
                                    $kelompok = $Kelompok->where('uid', $d->uid)->first();
                                    $pembimbing = $User->where('id', $kelompok->pid)->first(); ?>
                                        <tr>
                                            <td style="vertical-align: middle;"><?= $no++; ?>.</td>
                                            <td><?= $user->nama; ?> <br> <small class="text-secondary">( <?= $user->kelas; ?> )</small></td>
                                            <td style="vertical-align: middle;"><?= $d->tempat_pkl; ?></td>                                         
                                            <td style="vertical-align: middle;"><?= $pembimbing->nama; ?></td>                                         
                                            <td style="vertical-align: middle;">
                                                <a href="<?= base_url('admin/sertifikat/cover/'.$user->id); ?>" class="btn btn-primary btn-sm text-white" title="Nilai">Cover</a>
                                                <a href="<?= base_url('admin/sertifikat/nilai/'.$user->id); ?>" class="btn btn-primary btn-sm text-white mx-1" title="Nilai">Nilai</a>
                                                <a href="<?= base_url('admin/ubahNilai/'.$user->id); ?>" class="btn btn-secondary btn-sm text-white" title="Nilai">Ubah Nilai</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?= $pager->links(); ?>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<?= $this->endSection(); ?>
            