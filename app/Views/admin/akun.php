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
                        <h4 class="page-title text-primary">Pengaturan Akun</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Admin</a></li>
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
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-12">
                        <div class="white-box">
                            <img src="<?= base_url('public/img/'.$user->foto); ?>" width="100%">
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="<?= base_url('admin/updateAkun'); ?>" class="form-horizontal form-material" enctype="multipart/form-data">
                                    <?= csrf_field(); ?>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Nama</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" name="nama" value="<?= $user->nama; ?>"
                                                class="form-control p-0 border-0 <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('nama'); ?>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Telepon</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="number" name="telepon" value="<?= $user->telepon; ?>"
                                                class="form-control p-0 border-0 <?= ($validation->hasError('telepon')) ? 'is-invalid' : ''; ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('telepon'); ?>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Alamat</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <textarea  name="alamat"
                                                class="form-control p-1 <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" rows="5"><?= $user->alamat; ?></textarea>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('alamat'); ?>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Username</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" name="username" value="<?= $user->username; ?>"
                                                class="form-control p-0 border-0 <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('username'); ?>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Password</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="password" name="password" id="pass" class="form-control p-0 border-0 <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>">

                            <span id="mybutton" onclick="change()" style="float: right; position: relative; top: -30px;">
                                    <i class="fa-solid fa-eye"></i>
                            </span>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('password'); ?>
                                                </div>
                                        </div>
                                    </div>


                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Foto Profil (1MB)</label>
                                        <div class="col-md-12p-0">
                                            <input type="file" name="foto"
                                                class="form-control p-0 border-0 <?= ($validation->hasError('foto')) ? 'is-invalid' : ''; ?>"> 
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('foto'); ?>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success float-end">Update Profile</button>
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
            