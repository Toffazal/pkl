<?php

namespace App\Controllers;

use \App\Models\User;

    $User = new User;

?>

<?= $this->extend('kajur/template'); ?>

<?= $this->section('content'); ?>
            
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title text-primary">Riwayat</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Permohonan</a></li>
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

<p class="position-relative d-inline-block p-0" style="left: -25px; top: -25px;">
    <a id="aktiff" class="btn btn-primary me-0" role="button" data-bs-toggle="collapse" href="#aktif" aria-expanded="false" aria-controls="collapse" style="border-left: 0px; border-top: 0px;">
        Disetujui (<?= count($setuju); ?>)
    </a>

    <a id="pendingg" class="btn btn-outline-primary ms-0" role="button" data-bs-toggle="collapse" href="#pending" aria-expanded="false" aria-controls="collapse" style="border-left: 0px; border-top: 0px;">
        Ditolak (<?= count($ditolak); ?>)
    </a>
</p>

                            <h3 class="box-title">Riwayat Permohonan</h3>
                            <div class="table-responsive">

                                <div class="collapse show" id="aktif">
                                <table class="table text-nowrap search-table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Tempat PKL</th>
                                            <th class="border-top-0">Tanggal Permohonan</th>
                                            <th class="border-top-0">Tanggal Disetujui</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php $no=1; foreach($disetujui as $d) { $user = $User->where('id', $d->uid)->first();?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $user->nama; ?></td>
                                            <td><?= $d->tempat_pkl; ?></td>
                                            <td><?= $d->tanggal_pengajuan; ?></td>
                                            <td><?= $d->tanggal_konfirmasi; ?></td>
                                        </tr>
                            <?php } ?>
                                    </tbody>
                                </table>
                                <?= $pager->links(); ?>
                                </div>


                                <div class="collapse" id="pending">
                                <table class="table text-nowrap search-table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Tempat PKL</th>
                                            <th class="border-top-0">Tanggal Permohonan</th>
                                            <th class="border-top-0">Alasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php $no=1; foreach($ditolak as $d) { $user = $User->where('id', $d->uid)->first();?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $user->nama; ?></td>
                                            <td><?= $d->tempat_pkl; ?></td>
                                            <td><?= $d->tanggal_pengajuan; ?></td>
                                            <td><?= $d->alasan; ?></td>
                                        </tr>
                            <?php } ?>
                                    </tbody>
                                </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

<?= $this->endSection(); ?>
            