<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemLicenseModel extends Model
{
    protected $table            = 'license';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnLicense       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','slug','id_license_parent'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

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

    public function getLicenseById($id) {
        return $this->find($id);
    }

    public function getAllLicenses() {
        return $this->findAll();
    }

    public function deleteLicense($id) {
        return $this->delete($id);
    }

    public function getLicenseBySlug($slug) {
        return $this->where('slug',$slug)->first();
    }
    public function insertLicense($item) {
        if(isset($item['id_license_parent']) && empty($item['id_license_parent'])) {
            unset($item['id_license_parent']);
        }
        if (isset($item['name'])) {
            $item['slug'] = $this->generateUniqueSlug($item['name']);
        }
        return $this->insert($item);
    }

    public function updatelicense($id,$item)
    {
        if (isset($item['name'])) {
            $item['slug'] = $this->generateUniqueSlug($item['name']);
        }
        return $this->update($id,$item);
    }


    private function generateUniqueSlug($name)
    {
        $slug = generateSlug($name);
        $builder = $this->builder();
        $count = $builder->where('slug', $slug)->countAllResults();
        if ($count === 0) {
            return $slug;
        }
        $i = 1;
        while ($count > 0) {
            $newSlug = $slug . '-' . $i;
            $count = $builder->where('slug', $newSlug)->countAllResults();
            $i++;
        }
        return $newSlug;
    }

    public function getPaginated($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();
        // Recherche
        if ($searchValue != null) {
            $builder->like('name', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }


    public function getTotal()
    {
        $builder = $this->builder();
        return $builder->countAllResults();
    }

    public function getFiltered($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }
}