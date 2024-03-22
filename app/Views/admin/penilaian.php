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
                        <h4 class="page-title text-primary">Format Penilaian</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal"><?= $jurusan->nama; ?></a></li>
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
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="text-primary bold mb-4">Penilaian Non-Teknis</h5>

            <?php foreach($nonTeknis as $p) { ?>
                <p><i class="fas fa-circle-minus text-danger" style="cursor: pointer;" onclick="hapusPenilaian(<?=$p->id;?>, '<?=$jurusan->nama;?>');"></i> <?= $p->nama; ?></p>
            <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="text-primary bold mb-4">Penilaian Teknis</h5>

            <?php foreach($teknis as $p) { ?>
                <p><i class="fas fa-circle-minus text-danger" style="cursor: pointer;" onclick="hapusPenilaian(<?=$p->id;?>, '<?=$jurusan->nama;?>');"></i> <?= $p->nama; ?></p>
            <?php } ?>
            </div>
        </div>
    </div>
</div>

                <!-- Row -->
                     <form method="post" action="<?= base_url('admin/simpanPenilaian'); ?>" class="form-horizontal form-material" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="jid" value="<?= $jurusan->id; ?>">

                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-primary bold mb-4">Penilaian Non-Teknis</h5>

                                <div class="non-teknis">
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Nama Penilaian</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" name="non_teknis[]" class="form-control p-0 border-0"> 
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary btn-sm add-non float-end">+ Tambah</button>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-primary bold mb-4">Penilaian Teknis</h5>
                                
                                <div class="teknis">
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" style="font-weight: bold;">Nama Penilaian</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" name="teknis[]" class="form-control p-0 border-0">
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary btn-sm add-teknis float-end">+ Tambah</button>
   
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <div class="form-group mb-4 w-100">
                        <button type="submit" class="btn btn-success w-100">Simpan Penilaian</button>
                    </div>

                </div>
                <!-- Row -->
                </form>


                <div class="copyNon hide">
                    <div class="groupNon">
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0" style="font-weight: bold;">Nama Penilaian</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="non_teknis[]" class="form-control p-0 border-0"> 
                            </div>
                        </div>

                        <button type="button" class="btn btn-danger btn-sm mb-4 text-white hapusNon"><i class="fas fa-trash"></i> Hapus</button>

                    </div>
                </div>


                <div class="copyTeknis hide">
                    <div class="groupTeknis">
                    <div class="form-group mb-4">
                        <label class="col-md-12 p-0" style="font-weight: bold;">Nama Penilaian</label>
                        <div class="col-md-12 border-bottom p-0">
                            <input type="text" name="teknis[]" class="form-control p-0 border-0">
                        </div>
                    </div>

                        <button type="button" class="btn btn-danger btn-sm mb-4 text-white hapusTeknis"><i class="fas fa-trash"></i> Hapus</button>

                    </div>
                </div>



            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<?= $this->endSection(); ?>
            