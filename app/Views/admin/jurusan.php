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
                        <h4 class="page-title text-primary">Jurusan</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Jurusan</a></li>
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

               <!-- Modal -->
<div class="modal fade" id="tambahJurusan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jurusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form method="POST" action="<?= base_url('admin/tambahJurusan'); ?>">
      <div class="modal-body">

            <label>Nama Jurusan</label>
            <input name="nama" type="text" class="form-control" required>
   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-primary" id="simpanKonfimasi">Tambah</button>
      </div>
        </form>
    </div>
  </div>
</div>

                <div class="row">
                    <div class="col-sm-12">
                        <a type="button" href="#tambahJurusan" class="float-end btn btn-primary btn-sm" data-bs-toggle="modal">+ Jurusan</a>
                        <div class="white-box">
                            <h3 class="box-title">Jurusan Terdaftar</h3>
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Jumlah Siswa</th>
                                            <th class="border-top-0">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach($jurusan as $d) { ?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $d->nama; ?></td>
                                            <?php $siswa = $User->where(['jurusan' => $d->id, 'role' => 'siswa'])->find();  ?>
                                            <td><?= count($siswa); ?></td>
                                            <td>
                                                <a type="button" href="#editJurusan<?=$d->id;?>" class="btn btn-success btn-sm text-white" title="Edit" data-bs-toggle="modal"><i class="fas fa-edit"></i> Edit</a>

                                                <a href="<?= base_url('admin/penilaian/'.$d->nama); ?>" class="btn btn-primary btn-sm text-white" title="Penilaian"><i class="fas fa-list-ol"></i> Penilaian</a>
                                            </td>
                                        </tr>



                                        <!-- Modal -->
<div class="modal fade" id="editJurusan<?=$d->id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Jurusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form method="POST" action="<?= base_url('admin/updateJurusan'); ?>">
      <div class="modal-body">

            <label>Nama Jurusan</label>
            <input type="hidden" name="id" value="<?= $d->id; ?>">
            <input name="nama" type="text" class="form-control" value="<?= $d->nama; ?>" required>
   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-primary" id="simpanKonfimasi">Edit</button>
      </div>
        </form>
    </div>
  </div>
</div>
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
            