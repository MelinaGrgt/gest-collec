<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'id';
    protected $allowedFields = ['file_path', 'entity_id', 'entity_type', 'created_at'];

    protected $useTimestamps = false;


    // retourne toutes les infos du tableau
    public function getAllMedias($limit = null, $offset = 0){
         return $this->findAll($limit, $offset);
    }

    public function getMediaById($id){
        if($id==null){
            return false;
        }
        return $this->find($id);
    }

    public function getFirstMediaByEntityAndType($entityId, $entityType){
        return $this->where('entity_type', $entityType)->where('entity_id', $entityId)->first();
    }

    // retourne une ligne du tableau correspondant à l'entity_type (ici peut prendre les valeurs suivantes: user, item, brand ou license)
    public function getAllMediasByEntityType($entityType, $limit = null, $offset = 0)
    {
        return $this-> where('entity_type', $entityType)->findAll($limit, $offset);
    }

    public function getMediaByEntityIdAndType($entityId, $entityType){
        return $this->where('entity_type', $entityType)->where('entity_id', $entityId)->findAll();
    }

    public function deleteMedia($id) {
        // Récupérer les informations du fichier depuis la base de données
        $fichier = $this->find($id);
        if ($fichier) {
            // Chemin complet du fichier tel qu'il est stocké dans la base de données
            $chemin = FCPATH . $fichier['file_path'];

            // Vérifier si le fichier existe et le supprimer
            if (file_exists($chemin)) {
                // Supprimer le fichier physique
                unlink($chemin);
                // Supprimer l'entrée de la base de données
                return $this->delete($id);
            }
        }
        return false; // Le fichier n'a pas été trouvé
    }
}




