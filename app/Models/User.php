<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{

  protected $table = 'user';
  protected $allowedFields = ['nama', 'nis', 'jurusan', 'kelas', 'telepon', 'alamat', 'foto', 'username', 'password', 'role'];

}