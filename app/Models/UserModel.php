<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'kimlik_no',
        'ad',
        'soyadi',
        'telefon_no',
        'e_posta',
        'sifre',
    ];
}
