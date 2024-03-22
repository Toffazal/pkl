<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Jurusann;

    $User = new User;
    $Jurusan = new Jurusann;

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


                <!-- Row -->
                     <form method="post" action="<?= base_url('admin/updatePegawai'); ?>" class="form-horizontal form-material" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" value="<?= $data->id; ?>">
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Nama Pegawai</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" name="nama"
                                                class="form-control p-0 border-0 <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" value="<?= $data->nama; ?>" autofocus> 
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('nama'); ?>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Jabatan</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <select name="jabatan" class="form-control px-2 border-0" aria-label="Default select example">
                                                <option value="<?= $data->role; ?>" selected><?= $data->role; ?></option>
                                                    <option value="kajur">Kajur</option>
                                                    <option value="pembimbing">Pembimbing</option>
                                            </select> 
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('jabatan'); ?>
                                                </div>
                                        </div>
                                    </div>

                                    <?php $prodi = $Jurusan->where('id', $data->jurusan)->first(); ?>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Jurusan</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <select name="jurusan" class="form-control px-2 border-0" aria-label="Default select example">
                                                <option value="<?= $prodi->id; ?>" selected><?= $prodi->nama; ?></option>
                                                <?php foreach($jurusan as $j) { ?>
                                                    <option value="<?= $j->id; ?>"><?= $j->nama; ?></option>
                                                <?php } ?>
                                            </select> 
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('jurusan'); ?>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Telepon/WhatsApp</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="tel" name="telepon"
                                                class="form-control p-0 border-0 <?= ($validation->hasError('telepon')) ? 'is-invalid' : ''; ?>" value="<?= $data->telepon; ?>"> 
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('telepon'); ?>
                                                </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Alamat</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <textarea  name="alamat"
                                                class="form-control p-1 <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" rows="4"><?= $data->alamat; ?></textarea>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('alamat'); ?>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Username</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" name="username"
                                                class="form-control p-0 border-0 <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" value="<?= $data->username; ?>"> 
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('username'); ?>
                                                </div>
                                        </div>
                                    </div>
   
                            </div>
                        </div>

                            <div class="form-group mb-4 w-100">
                                <button type="submit" class="btn btn-success w-100">Update Pegawai</button>
                            </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                </form>



            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

<?= $this->endSection(); ?>
            