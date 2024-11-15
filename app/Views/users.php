<div class="col">
    <div class="card h-100">
        <div class="card-header"><h3>Listes des utilisateurs</h3>
        </div>
        <div class="card-body">
            <?php foreach (array_chunk($users, 6) as $chunk): ?>
            <div class="row shelf-row px-4 ">
                <?php foreach ($chunk as $user): ?>
                <div class="col-md-2 col-6">
                    <div class="card h-100">
                        <?php
                        // Utilise l'image par défaut si aucune image n'est disponible pour l'item
                        $img_src = !empty($user['file_path']) ? base_url($user['file_path']) : base_url('assets/brand/logo-bleu.svg');
                        ?>
                        <a href="<?= base_url('collection/' . $user['username']) ?>">
                            <img src="<?=$img_src?>" class="card-img-top" alt="<?= $user['username']; ?>">
                        </a>
                        <div class="card-body d-flex justify-content-center align-items-end">
                            <div class="card-title"><b><?= ucfirst($user['username']); ?></b></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
            <div class="row">
                <div class="col">
                    <div class="pagination justify-content-center">
                        <?= $pager->links('default', 'bootstrap_pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .shelf-row {
        position: relative; /* Positionnement nécessaire pour le pseudo-élément */
        margin-bottom: 50px; /* Assurez-vous d'avoir un espace en bas pour l'étagère */
    }

    .shelf-row::after {
        content: '';
        display: block; /* Rendre le pseudo-élément un bloc pour pouvoir ajuster la largeur */
        background-image: url("https://www4-static.gog-statics.com/bundles/gogwebsiteaccount/img/shelf/wood.png"); /* Lien vers l'image de l'étagère */
        background-size: cover; /* S'assurer que l'image couvre toute la largeur */
        background-repeat: no-repeat; /* Éviter que l'image se répète */
        position: absolute; /* Positionnement absolu par rapport au conteneur */
        bottom: -57px; /* Positionner l'étagère en bas du conteneur */
        left: 0; /* Aligné à gauche */
        width: 100%; /* Largeur de l'étagère à 100% */
        height: 85px; /* Ajuster la hauteur de l'étagère selon vos besoins */
        z-index: 0; /* Mettre l'étagère derrière les cartes */
    }
    /* Ajustement des étagères pour les petits écrans */
    @media(max-width: 768px) {
        .shelf-row::after {
            content: none;
        }
        .shelf-row {
            margin-bottom: 0;
        }
        .shelf-row .col-6 {
            margin-bottom: 1em;
        }
    }
    .shelf-row .col-md-3 {
        z-index: 1;
    }
    .shelf-row .card {
        box-shadow: 0 1px 5px rgba(0,0,0,.15);
        overflow: hidden;
    }

    .shelf-row .card-footer {
        position: absolute; /* Nécessaire pour l'effet */
        bottom: -50px; /* Ajustez cette valeur pour que le footer soit hors de la carte initialement */
        left: 0;
        right: 0;
        opacity: 0; /* Caché par défaut */
        transition: opacity 0.3s ease; /* Effet de transition pour la visibilité */
    }
</style>