<?php

namespace App\Models;

use CodeIgniter\Model;

class Nilai extends Model
{

  protected $table = 'nilai';
  protected $allowedFields = ['uid', 'idp', 'nilai'];

}