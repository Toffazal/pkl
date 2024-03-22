<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Kelompok;
use \App\Models\Permohonan;

    $User = new User;
    $Kelompok = new Kelompok;
    $Permohonan = new Permohonan;

?>

<?= $this->extend('siswa/template'); ?>

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


                <div class="white-box">
                    <h5 class="text-info bold"><i class="fas fa-book"></i> SURAT PERMOHONAN</h5>

                    <a href="<?= base_url('public/berkas/permohonan.pdf'); ?>" title="Lihat Berkas" class="btn btn-info text-white" download>Unduh Surat Permohonan</a>
                    <br><br>

                    <!-- Jika belum upload permohonan -->
                    <?php if(!$permohonan) { ?>
                        <form method="post" action="<?= base_url('siswa/uploadBerkas'); ?>" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="col-lg-6">
                                <label class="col-md-12 p-0">Tempat PKL</label>
                                <input type="text" name="tempat_pkl" class="form-control p-1 <?= ($validation->hasError('tempat_pkl')) ? 'is-invalid' : ''; ?>" value="<?= old('tempat_pkl'); ?>"> 
                                <div class="invalid-feedback">
                                        <?= $validation->getError('tempat_pkl'); ?>
                                </div>

                                <label for="formFile" class="form-label d-block mt-4">Upload Surat Permohonan (pdf, 2MB)</label>
                                <input name="berkas" class="form-control d-inline-block <?= ($validation->hasError('berkas')) ? 'is-invalid' : ''; ?>" type="file" id="formFile" style="width: 70%;">
                                <button type="submit" class="btn btn-primary d-inline-block" style="vertical-align: bottom;">Upload</button>
                                <div class="invalid-feedback">
                                        <?= $validation->getError('berkas'); ?>
                                </div>
                            </div>
                        </form>
                    <?php } ?>


                <!-- Jika sudah upload permohonan -->
                <?php if($permohonan) { ?>
                    <!-- Jika sudah upload permohonan tapi belum ditanggapi -->
                    <?php if($permohonan->status == 0) { ?>
                        <h4>PENDING : Pengajuan anda sedang diproses, mohon cek berkala 1x24 jam</h4>
                    <?php } ?>


                    <!-- Jika sudah upload dan ditolak -->
                    <?php if($permohonan->status == 1) { ?>
                        <form method="post" action="<?= base_url('siswa/uploadBerkas'); ?>" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="col-lg-6">
                                <label class="col-md-12 p-0">Tempat PKL</label>
                                <input type="text" name="tempat_pkl" class="form-control p-1 <?= ($validation->hasError('tempat_pkl')) ? 'is-invalid' : ''; ?>" value="<?= old('tempat_pkl'); ?>"> 
                                <div class="invalid-feedback">
                                        <?= $validation->getError('tempat_pkl'); ?>
                                </div>

                                <label for="formFile" class="form-label d-block mt-4">Upload Surat Permohonan (pdf, 2MB)</label>
                                <input name="berkas" class="form-control d-inline-block <?= ($validation->hasError('berkas')) ? 'is-invalid' : ''; ?>" type="file" id="formFile" style="width: 70%;">
                                <button type="submit" class="btn btn-primary d-inline-block" style="vertical-align: bottom;">Upload</button>
                                <div class="invalid-feedback">
                                        <?= $validation->getError('berkas'); ?>
                                </div>
                            </div>
                        </form>
                        <br>
                        <h4 class="text-danger"><b>DITOLAK :</b> Pengajuan anda ditolak, silahkan ajukan permohonan kembali</h4>
                        <h4><b>ALASAN :</b> <?= $permohonan->alasan; ?></h4>
                    <?php } ?>


                    <!-- Jika sudah upload dan disetujui -->
                    <?php if($permohonan->status == 2) { ?>
                        <h4 class="text-success"><b>DISETUJUI :</b> Pengajuan anda disetujui, tunggu informasi selanjutnya dari pihak sekolah</h4>
                    <?php } ?>


                    <!-- Jika sudah masuk dalam kelompok -->
                    <?php if($permohonan->status == 3) { $data = $Kelompok->where('uid', $permohonan->uid)->first();
                    $pembimbing = $User->where('id', $data->pid)->first(); 
                    $siswa = $Kelompok->where(['pid' => $pembimbing->id, 'status' => 0])->find();?>
                    <br>
                        <h5><b>Tempat PKL :</b> <?= $data->tempat_pkl; ?></h5>
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
                                            <th class="border-top-0">Foto Pembimbing</th>
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
                                            <td style="vertical-align: middle;"><a href="<?= base_url('public/img/'.$pembimbing->foto); ?>" target="_blank">Lihat Foto</a></td>
                                        </tr>
                            <?php }  ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
                    <?php } ?>



                    <!-- Jika sudah menyelesaikan kegiatan PKL -->
                    <?php if($permohonan->status == 4) { ?>
                        <h4 class="text-success"><b>SELAMAT,</b> Anda telah berhasil menyelesaikan kegiatan PKL anda!</h4>
                    <?php } ?>

                    <!-- Jika sudah mendapatkan nilai PKL -->
                    <?php if($permohonan->status == 5) { ?>
                        <h4 class="text-success"><b>SELAMAT,</b> Anda telah berhasil menyelesaikan kegiatan PKL anda!</h4>
                    <?php } ?>

                <?php } ?>
                    

                </div>

               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<?= $this->endSection(); ?>
            