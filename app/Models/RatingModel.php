<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table            = 'rating';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = ['id_user','id_item','rating','created_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

    public function getinsert($notation){
        return $this->insert($notation);
    }

    public function getAvRatingByItem($id){
        $builder = $this->db->table('rating');
        $builder->selectAvg('rating');
        $builder->where('id_item', $id);
        $AVGrating=$builder->get();
        return $AVGrating->getRow()->rating;
    }

}
