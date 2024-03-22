<?php

namespace App\Models;

use CodeIgniter\Model;

class Kelompok extends Model
{

  protected $table = 'kelompok';
  protected $allowedFields = ['pid', 'uid', 'tempat_pkl', 'status'];

}