<?php

namespace App\Models;

use CodeIgniter\Model;

class BiletModel extends Model
{
    protected $table            = 'bilet';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'userId',
        'seferId',
        'koltuk_no',
        'alim_tarihi',
        'ad',
        'soyadi',
        'cinsiyet'
    ];
}