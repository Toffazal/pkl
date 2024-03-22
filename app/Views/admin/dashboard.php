<?= $this->extend('admin/template'); ?>

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

                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Jurusan</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                <li>
                                    <div id="sparklinedash"><canvas width="67" height="30"
                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                    </div>
                                </li>
                                <li class="ms-auto"><span class="counter text-success"><?= count($jurusan); ?></span></li>
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


                <div class="white-box">
                    <h5 class="text-success bold"><i class="fas fa-book"></i> SURAT PERMOHONAN</h5>

                    <a href="<?= base_url('public/berkas/permohonan.pdf'); ?>" title="Lihat Berkas" class="btn btn-success text-white" target="_blank">Lihat Surat Permohonan</a>
                    <br><br>
                    <form method="post" action="<?= base_url('admin/uploadBerkas'); ?>" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="col-lg-6">
                                <label for="formFile" class="form-label d-block">Upload Surat Permohonan (pdf, 2MB)</label>
                                <input name="berkas" class="form-control d-inline-block <?= ($validation->hasError('berkas')) ? 'is-invalid' : ''; ?>" type="file" id="formFile" style="width: 70%;">
                                <button type="submit" class="btn btn-primary d-inline-block" style="vertical-align: bottom;">Upload</button>
                                <div class="invalid-feedback">
                                        <?= $validation->getError('berkas'); ?>
                                </div>
                            </div>
                        </form>

                </div>

               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<?= $this->endSection(); ?>
            