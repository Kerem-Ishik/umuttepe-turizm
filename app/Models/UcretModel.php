<?php

namespace App\Models;

use CodeIgniter\Model;

class UcretModel extends Model
{
    protected $table = 'ucret';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nereden',
        'nereye',
        'tutar'
    ];
}