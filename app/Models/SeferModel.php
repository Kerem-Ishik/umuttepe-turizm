<?php

namespace App\Models;

use CodeIgniter\Model;

class SeferModel extends Model
{
    protected $table            = 'sefer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'kalkis',
        'varis',
        'tarih'
    ];
}