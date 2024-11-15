<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table            = 'comment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user','id_comment_parent','content','entity_id','entity_type','created_at','updated_at','deleted_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getAllCommentsByIdItem($id_item) {
        return $this->where('entity_id', $id_item)->where('entity_type', 'item')->findAll();
    }

    public function insertItemComment($data) {
        $data['entity_type'] = "item";
        return $this->insert($data);
    }
    public function insertCollectionComment($data) {
        $data['entity_type'] = "collection";
        return $this->insert($data);
    }

    public function getAllCommentsByItem($id_item) {
        $this->select("comment.id, comment.content, comment.id_user, comment.updated_at as date, u.username, m.file_path as profile_file_path");

        $this->selectCount("l.id", 'nb_likes');  // Compter le nombre de likes

        $this->join('TableUser u', 'u.id = comment.id_user');

        $this->join("media m", "comment.id_user = m.entity_id AND m.entity_type = 'user'", "left");

        $this->join('likes l', 'l.id_comment = comment.id', 'left');  // Joindre les likes par commentaire
        $this->where("comment.entity_type", "item");
        $this->where("comment.entity_id", $id_item);
        $this->groupBy("comment.id");  // Nécessaire pour l'agrégation (likes)
        $this->orderBy("comment.updated_at", "ASC");
        return $this->findAll();
    }

    public function getAllCommentsByCollection($id_collection) {
        $this->select("comment.id, comment.content, comment.updated_at as date, u.username, m.file_path as profile_file_path");
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join("media m", "comment.id_user = m.entity_id and m.entity_type = 'user'", "left");
        $this->where("comment.entity_type", "collection");
        $this->where("comment.entity_id", $id_collection);
        return $this->findAll();
    }

    public function getTotalCommentsByIdItem($id_item){
        $builder = $this->db->table('comment');
        $builder -> selectCount('id');
        $builder->where('entity_id',$id_item);
        $builder->where('entity_type','item');
        $builder->where('deleted_at IS null');
        $totalcomments = $builder->get();
        return $totalcomments->getRow()->id;
    }

    public function getCommentByEntityId($id){
        $builder = $this->db->table('comment c');
        $builder -> select('c.id,i.name as itemname, c.id_user,u.username, c.id_comment_parent, c.content,c.created_at,c.updated_at, c.deleted_at');
        $builder->join('TableUser u', 'u.id = c.id_user');
        $builder->join('item i', 'i.id=c.entity_id');
        $builder -> where('c.entity_id', $id);
        return $builder->get()->getresult();
    }

    public function getCommentByIdUser($id){
        $builder = $this->db->table('comment c');
        $builder -> select('c.id, c.entity_id,i.name as itemname, c.id_user,u.username, c.id_comment_parent, c.content,c.created_at,c.updated_at, c.deleted_at');
        $builder->join('TableUser u', 'u.id = c.id_user');
        $builder->join('item i', 'i.id=c.entity_id');
        $builder -> where('c.id_user', $id);
        return $builder->get()->getResultArray();
    }

    public function getCommentById($id){
        $builder = $this->db->table('comment c');
        $builder -> select('c.id, i.name as itemname, c.id_user,u.username, c.id_comment_parent, c.content,c.created_at,c.updated_at,c.deleted_at');
        $builder->join('TableUser u', 'u.id = c.id_user');
        $builder->join('item i', 'i.id=c.entity_id');
        $builder -> where('c.id', $id);
        return $builder->get()->getRowArray();
    }

    public function getPaginated($start, $length, $searchValue, $orderColumnName, $orderDirection,$custom_filter=null ,$custom_filter_value=null)
    {
        $builder = $this->builder();
        $builder->select("comment.id, comment.content,i.name, comment.id_comment_parent, u.username,comment.entity_id,comment.updated_at, comment.deleted_at");
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.entity_type','item');
        if ( $custom_filter){
            switch ($custom_filter) {
                case "user" :
                    $builder->where('u.id', $custom_filter_value);
                    break;
                case "item" :
                    $builder->where('i.id', $custom_filter_value);
                    break;
            }
        }

        // Recherche
        if ($searchValue != null) {
            $builder->groupStart(); // Démarre un groupe de conditions
            $builder->like('comment.id', $searchValue);
            $builder->orLike('comment.id_comment_parent', $searchValue);
            $builder->orLike('comment.content', $searchValue);
            $builder->orLike('comment.entity_id', $searchValue);
            $builder->orLike('u.username', $searchValue);
            $builder->groupEnd(); // Termine le groupe de conditions
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotal($custom_filter=null,$custom_filter_value=null)
    {
        $builder = $this->builder();
        $builder->select("comment.id, comment.content, i.name, comment.id_comment_parent, u.username,comment.entity_id,comment.updated_at, comment.deleted_at");
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.entity_type','item');
        if ($custom_filter){
            switch ($custom_filter) {
                case "user" :
                    $builder->where('u.id', $custom_filter_value);
                    break;
                case "item" :
                    $builder->where('i.id', $custom_filter_value);
                    break;
            }
        }
        return $builder->countAllResults();
    }

    public function getFiltered($searchValue, $custom_filter=null, $custom_filter_value=null)
    {
        $builder = $this->builder();
        $builder->select("comment.id, comment.content,i.name, comment.id_comment_parent, u.username,comment.entity_id,comment.updated_at, comment.deleted_at");
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.entity_type','item');
        if ( $custom_filter){
            switch ($custom_filter) {
                case "user" :
                    $builder->where('u.id', $custom_filter_value);
                    break;
                case "item" :
                    $builder->where('i.id', $custom_filter_value);
                    break;
            }
        }
        if (!empty($searchValue)) {
            $builder->groupStart(); // Démarre un groupe de conditions
            $builder->like('comment.id', $searchValue);
            $builder->orLike('comment.id_comment_parent', $searchValue);
            $builder->orLike('comment.content', $searchValue);
            $builder->orLike('comment.entity_id', $searchValue);
            $builder->orLike('comment.updated_at', $searchValue);
            $builder->orLike('u.username', $searchValue);
            $builder->groupEnd(); // Termine le groupe de conditions
        }

        return $builder->countAllResults();
    }

    public function deleteComment($id)
    {
        return $this->delete($id);
    }

    public function activateComment($id) {
        $builder = $this->builder();
        $builder->set('deleted_at', NULL);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function getupdatecomment($data)
    {  $builder = $this->db->table('comment');
        $builder -> where('id', $data['id']);
        return $builder->update($data);
    }


}