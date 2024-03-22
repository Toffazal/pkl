<?php

namespace App\Models;

use CodeIgniter\Model;

class Penilaian extends Model
{

  protected $table = 'penilaian';
  protected $allowedFields = ['jid', 'kategori', 'nama'];

}