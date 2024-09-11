<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Item extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord','url' => '/admin/dashboard']];
    public function getindex(){
        return $this->view('admin/item/index', [], true);
    }
//GESTION DES TYPES
    public function gettype(){
        $this->title="Gestion des Types";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Types','');
        $itm = model("ItemTypeModel");
        $all_types = $itm->getAllTypes();
        return $this->view('admin/item/type', ['all_types' => $all_types], true);
    }

    public function getdeletetype($id) {
        $itm = model("ItemTypeModel");
        if ($itm->deleteType($id)) {
            $this->success("Type supprimé");
        } else {
            $this->error("Type non supprimé");
        }
        return $this->redirect('/admin/item/type');
    }

    public function postcreatetype() {
        $data = $this->request->getPost();
        $itm = Model('ItemTypeModel');
        if ($itm->insertType($data)) {
            $this->success('Type ajouté');
        } else {
            $this->error('Type non ajouté');
        }
        $this->redirect('/admin/item/type');
    }

public function gettotalitemtype(){
        $id = $this->request->getGet('id');
        $tt = model("ItemModel");
        return json_encode($tt->getTotalItembyTypeId($id));

}

// GESTION DE BRAND
    public function getbrand(){
        $this->title="Gestion des Marques";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Marques','');
        $ibm = model("ItemBrandModel");
        $all_brands = $ibm->getAllBrands();
        return $this->view('admin/item/brand', ['all_brands' => $all_brands], true);
    }

    public function getdeletebrand($id) {
        $ibm = model("ItemBrandModel");
        if ($ibm->deleteBrand($id)) {
            $this->success("Marques supprimé");
        } else {
            $this->error("Marques non supprimé");
        }
        return $this->redirect('/admin/item/brand');
    }

    public function postcreatebrand() {
        $data = $this->request->getPost();
        $ibm = Model('ItemBrandModel');
        if ($ibm->insertBrand($data)) {
            $this->success('Marque ajouté');
        } else {
            $this->error('Marque non ajouté');
        }
        $this->redirect('/admin/item/brand');
    }

    public function gettotalitembybrand(){
        $id = $this->request->getGet("id");
        $tb = model("ItemModel");
        return json_encode($tb->getTotalItemByBrandId($id));
    }


// GESTION DES GENRES

    public function getgenre(){
        $this->title="Gestion des Genres";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Genres','');
        $ibm = model("ItemGenreModel");
        $all_genres = $ibm->getAllGenres();
        return $this->view('admin/item/genre', ['all_genres' => $all_genres], true);
    }

    public function getdeletegenre($id) {
        $ibm = model("ItemGenreModel");
        if ($ibm->deleteGenre($id)) {
            $this->success("Genre supprimé");
        } else {
            $this->error("Genre non supprimé");
        }
        return $this->redirect('/admin/item/genre');
    }

    public function postcreategenre() {
        $data = $this->request->getPost();
        $ibm = Model('ItemGenreModel');
        if ($ibm->insertGenre($data)) {
            $this->success('Genre ajouté');
        } else {
            $this->error('Genre non ajouté');
        }
        $this->redirect('/admin/item/genre');
    }

    public function gettotalitemgenre(){
        $id = $this->request->getGet("id");
        $igim = model("ItemGenreItemModel");
        return json_encode($igim->getTotalItemByGenreId($id));
    }


    // gestion des licenses
    public function getlicense(){
        $this->title="Gestion des Licences";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Licences','');
        $ilm = model("ItemLicenseModel");
        $all_licences = $ilm->getAllLicenses();
        return $this->view('admin/item/license', ['all_licenses' => $all_licences], true);
    }

    public function getdeletelicense($id) {
        $ilm = model("ItemLicenseModel");
        if ($ilm->deleteLicense($id)) {
            $this->success("Licence supprimé");
        } else {
            $this->error("Licence non supprimé");
        }
        return $this->redirect('/admin/item/license');
    }

    public function postcreatelicense() {
        $data = $this->request->getPost();
        $ibm = Model('ItemLicenseModel');
        if ($ibm->insertLicense($data)) {
            $this->success('Licence ajouté');
        } else {
            $this->error('Licence non ajouté');
        }
        $this->redirect('/admin/item/license');
    }

    public function gettotalitemlicense(){
        $id = $this->request->getGet("id");
        $tl = model("ItemModel");
        return json_encode($tl->getTotalItemByLicenseId($id));
    }
    public function postsearchdatatable()
    {
        $model_name = $this->request->getPost('model');
        $model = model($model_name);

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];

        // Obtenez les données triées et filtrées
        $data = $model->getPaginated($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $model->getTotal();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $model->getFiltered($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }
}