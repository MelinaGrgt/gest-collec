<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    protected $require_auth = false;
    public function index($username = null): string
    {
        $im = model('ItemModel');
            $data = $this->request->getGet();
            // Définir le nombre d'éléments par page
            $perPage = 8;
            $genres = model('ItemGenreModel')->getAllGenres();
            $types = model('ItemTypeModel')->getAllTypes();
            $licenses = model('ItemLicenseModel')->getAllLicenses();
            $brands = model('ItemBrandModel')->getAllBrands();
            $allitems = $im->getAllItemsFiltered($data,1, $perPage);
            // Récupérer le pager pour générer les liens de pagination
            $pager = $im->pager;
            $collectionUser = null;

            return $this->view('home', [
                'items' => $allitems,
                'genres' => $genres,
                'types' => $types,
                'licenses' => $licenses,
                'brands' => $brands,
                'data' => $data,
                'pager' => $pager,
                'collectionUser' => $collectionUser,
            ]);
    }

    public function getforbidden() : string
    {
        return view('/templates/forbidden');
    }
}