<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Item extends ResourceController
{
    public function gettest(){
        $data = $this->request->getGet();
        $data_post = $this->request->getPost();
        return $this->response->setJSON([
            'response'=> 'Coucou',
            'data'=> $data,
            'data_post'=> $data_post,
        ]);
    }

    public function posttest(){
        $data = $this->request->getGet();
        $data_post = $this->request->getPost();
        return $this->response->setJSON([
            'response'=> 'Coucou',
            'data'=> $data,
            'data_post'=> $data_post,
        ]);
    }
 public function getindex(){
     $data = $this->request->getGet();
     if (isset($data['id'])){
         $im = Model('ItemModel');
         $item = $im->getItem($data['id']);
         if($item){
             return $this->response->setJSON([
                 'message'=> 'success',
                 'item'=> $item,
             ]);
     } else {
             return $this->response->setJSON([
                 'message'=> 'Erreur: ID non existant',
             ]);
         }
     }
     return $this->response->setJSON([
         'message'=> "Erreur: pas d'information",
     ]);
 }

    public function postindex(){
        $data = $this->request->getPost();
        if (isset($data['name'])){
            $im = Model('ItemModel');
            $id_item = $im->insertItem($data);
            if($id_item){
                $item = $im->getItem($id_item);
                return $this->response->setJSON([
                    'message'=> "L'objet à été ajouté",
                    'item'=> $item,
                ]);
            } else {
                return $this->response->setJSON([
                    'message'=> "Erreur: objet non ajouté",
                ]);
            }
    } else {
        return $this->response->setJSON([
            'message'=> "Erreur: le nom de l'objet est obligatoire",
        ]);
        }
    }
}
