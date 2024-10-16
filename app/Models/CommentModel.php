<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table            = 'comments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = ['id_user','entity_id','entity_type','content','created_at','updated_at','deleted_at','id_comment_parent'];


    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getinsert($comment){
        return $this->insert($comment);
    }

    public function getupdate($comment ){
        $builder = $this->db->table('comments');
        $builder->where('id',$comment['id']);
        return $builder->update($comment);
    }

    public function getAllCommentsByIdItemAndUserName($id_item){
        $builder = $this->db->table('comments c');
        $builder->select('c.id, c.id_user, u.username, c.entity_id, c.content, r.rating, r.id as id_rating, c.id_comment_parent, c.created_at, c.updated_at');
        $builder->join('TableUser u', 'u.id = c.id_user');
        $builder->join('rating r', 'r.id_item = c.entity_id AND r.id_user = c.id_user', 'left');
        $builder->where('c.entity_id',$id_item);
        $builder->where('c.entity_type','item');
        $builder->groupBy('c.id');
        $comments =$builder->get();
        return $comments->getResultArray();
    }

    public function getTotalCommentsByIdItem($id){
        $builder = $this->db->table('comments');
        $builder -> selectCount('id');
        $builder->where('entity_id',$id);
        $totalcomments = $builder->get();
        return $totalcomments->getRow()->id;
    }



}



