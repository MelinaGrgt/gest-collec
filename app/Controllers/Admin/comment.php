<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class comment extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];

    public function getindex($id = null)
    {
        if ($id == null) {
            return $this->view("/admin/item/comment", [], true);
        } else {
            if ($id) {
                $comment = model("CommentModel")->getCommentById($id);
                return $this->view("/admin/comment", ["comment" => $comment], true);
            }
        }
    }

    public function postupdatecomment($id = null, $content = null)
    {
        $data = $this->request->getPost();
        if ($data == null) {
            return $this->view("/admin/item/comment", [], true);
        } else {
            $com = model('CommentModel')->getupdatecomment($data);
            $this->success('Commentaire édité');
            return $this->view("/admin/item/comment", [], true);
        }
    }

    public function getdeactivatecomment($id = null)
    {
        $cm = Model('CommentModel');
        if ($cm->deleteComment($id))
        {
            $this->success("Commentaire désactivé");
        }
        else {
            $this->error("commentaire non désactivé");
        }
        $this->redirect('/admin/comment');
    }

    public function getactivatecomment($id){
        $cm = Model('CommentModel');
        if ($cm->activateComment($id)) {
            $this->success("Commentaire activé");
        } else {
            $this->error("Commentaire non activé");
        }
        $this->redirect('/admin/comment');
    }


}