<?php

namespace App\Models;

use CodeIgniter\Model;

class LikesModel extends Model
{
    protected $table            = 'likes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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
    public function addLike($id_user, $id_item) {
        return $this->insert(['id_user' => $id_user, 'id_item' => $id_item]);
    }

    // Retirer un like
    public function removeLike($id_user, $id_item) {
        return $this->where('id_user', $id_user)->where('id_item', $id_item)->delete();
    }

    // Vérifier si l'utilisateur a déjà aimé
    public function hasLiked($id_user, $id_item) {
        return $this->where('id_user', $id_user)->where('id_item', $id_item)->countAllResults() > 0;
    }

    // Obtenir le nombre de likes d'un item
    public function getLikesCount($id_item) {
        return $this->where('id_item', $id_item)->countAllResults();
    }
}
