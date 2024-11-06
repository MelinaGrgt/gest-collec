<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Chat extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur', 'utilisateur','collaborateur'];
    public function getindex()
    {
        $users=Model('UserModel')->getAllUsers();
        return $this->view('message/chat', ['users' => $users]);
    }


    public function postajaxsendmessage(){
        $data = $this->request->getPost();
        if(Model('InstantMessageModel')->insertMessage($data)){
            return $this->response->setJSON($data);
        }
        return false;
    }

    public function getajaxmessagehistory(){
        $data = $this->request->getGET();
        return $this->response->setJSON(Model('InstantMessageModel')->getMessageHistory($data['id_receiver'], $data['id_sender']));
    }

    public function getajaxlastmessagehistory(){
        $data = $this->request->getGET();
        return $this->response->setJSON(Model('InstantMessageModel')->getLastMessageHistory($data['id_receiver'], $data['id_sender'],$data["offset"],$data["limit"],$data["timestamp"]));
    }
}

