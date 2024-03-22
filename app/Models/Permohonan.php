<?php

namespace App\Models;

use CodeIgniter\Model;

class Permohonan extends Model
{

  protected $table = 'permohonan';
  protected $allowedFields = ['uid', 'tempat_pkl', 'berkas', 'tanggal_pengajuan', 'status', 'alasan', 'tanggal_konfirmasi'];

}