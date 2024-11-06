<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
protected $table = 'message';
protected $primaryKey = 'id';
protected $allowedFields = ['id_receiver','id_sender','content','subject','created_at','updated_at', 'deleted_at'];
protected $useTimestamps = true;
protected $useSoftDeletes = true;
protected $createdField = 'created_at';
protected $updatedField = 'updated_at';
protected $deletedField = 'deleted_at';

    public function insertMessage($data){
        return $this->insert($data);
    }


    public function getAllMessageByIdUser($id=null){
        $this->select('*');
        $this->groupStart();
        $this->where('id_sender', $id);
        $this->orwhere('id_receiver', $id);
        $this->groupEnd();
        return $this->findAll();
    }
}