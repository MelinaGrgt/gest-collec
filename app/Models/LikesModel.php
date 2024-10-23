<?php

namespace App\Models;

use CodeIgniter\Model;

class LikesModel extends Model
{
    protected $table            = 'likes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user','id_comment'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];


    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    // Ajouter un like
    public function addLike($id_user, $id_comment) {
        return $this->insert(['id_user' => $id_user, 'id_item' => $id_comment]);
    }

    // Retirer un like
    public function removeLike($id_user, $id_comment) {
        return $this->where('id_user', $id_user)->where('id_item', $id_comment)->delete();
    }

    // Vérifier si l'utilisateur a déjà aimé
    public function hasLiked($id_user, $id_comment) {
        return $this->where('id_user', $id_user)->where('id_item', $id_comment)->countAllResults() > 0;
    }
}
