<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['collaborateur','utilisateur','administrateur'];
    public function getindex()
    {
        return $this->view("/login/user");
    }
}
