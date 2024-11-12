<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiTokenModel extends Model
{
    protected $table            = 'apitokens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [ 'user_id', 'token','created_at','expires_at'];
    protected $useTimestamps = false;
}
