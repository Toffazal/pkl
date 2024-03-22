<?php

namespace App\Controllers;

use \App\Models\User;

    $User = new User;

?>
<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
            
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title text-primary">Pegawai</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Pegawai</a></li>
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
                
            <form method="get" action="">
                <input type="search" name="keyword" placeholder="Cari Pegawai ..." class="form-goup mb-2 p-1" style="border: 1px solid lightgray;">
                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                <a href="<?= base_url('admin/pegawai'); ?>" title="Reload" class="text-info ms-2"><i class="fas fa-rotate" style="font-size: 22px; vertical-align: middle;"></i></a>
            </form>

                <div class="row">
                    <div class="col-sm-12">
                        <a href="<?= base_url('admin/tambahPegawai'); ?>" class="float-end btn btn-primary btn-sm">+ Pegawai</a>
                        <div class="white-box">
                            <h3 class="box-title">Pegawai Terdaftar</h3>
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Jabatan</th>
                                            <th class="border-top-0">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach($kajur as $d) { ?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $d->nama; ?></td>
                                            <td><?= $d->role; ?></td>                                            
                                            <td>
                                                <a href="<?= base_url('admin/editPegawai/'.$d->id); ?>" class="text-success me-2" title="Edit"><i class="fas fa-edit"></i><a>
                                                <a href="<?= base_url('admin/hapusPegawai/'.$d->id); ?>" onclick="return confirm('Lanjutkan hapus pegawai?');" class="text-danger" title="Hapus"><i class="fas fa-trash"></i><a>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php foreach($pembimbing as $d) { ?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $d->nama; ?></td>
                                            <td><?= $d->role; ?></td>                                            
                                            <td>
                                                <a href="<?= base_url('admin/editPegawai/'.$d->id); ?>" class="text-success me-2" title="Edit"><i class="fas fa-edit"></i></a>
                                                <a href="<?= base_url('admin/hapusPegawai/'.$d->id); ?>" onclick="return confirm('Lanjutkan hapus pegawai?');" class="text-danger" title="Hapus"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
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
            