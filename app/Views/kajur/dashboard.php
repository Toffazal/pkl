<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Permohonan;

    $User = new User;
    $Permohonan = new Permohonan;

?>

<?= $this->extend('kajur/template'); ?>

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


                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Daftar Permohonan</h3>
                            <div class="table-responsive">
                                <table class="table text-nowrap search-table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Tempat PKL</th>
                                            <th class="border-top-0">Dokumen</th>
                                            <th class="border-top-0">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php $no=1; foreach($permohonan as $d) { 
                            $u = $User->where(['id' => $d->uid, 'jurusan' => $user->jurusan])->first(); 
                            if($u) { $us = $Permohonan->where(['uid' => $u->id, 'status' => 0])->first(); ?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $u->nama; ?></td>
                                            <td><?= $us->tempat_pkl; ?></td>                                            
                                            <td><a href="<?= base_url('public/berkas/'.$d->berkas); ?>" target="_blank">Lihat Dokumen</a></td>                                            
                                            <td>
                                                <a href="<?= base_url('kajur/setuju/'.$d->id); ?>" class="text-success me-2" title="Setujui" onclick="return confirm('Lanjutkan setujui permohonan?');"><i class="fas fa-check"></i><a>
                                                <a type="button" href="#tolak" class="text-danger" title="Tolak" data-bs-toggle="modal"><i class="fa-solid fa-circle-xmark"></i><a>
                                            </td>
                                        </tr>

<!-- Modal -->
<div class="modal fade" id="tolak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tolak Permohonan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form method="POST" action="<?= base_url('kajur/tolak/'.$d->id); ?>">
      <div class="modal-body">

            <label>Alasan ditolak</label>
            <textarea  name="alasan" class="form-control p-1 <?= ($validation->hasError('alasan')) ? 'is-invalid' : ''; ?>" rows="5"><?= old('alasan'); ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('alasan'); ?>
                </div>                   
   
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-danger text-white" id="simpanKonfimasi">Tolak</button>
      </div>
        </form>
    </div>
  </div>
</div>

                            <?php }} ?>
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
            