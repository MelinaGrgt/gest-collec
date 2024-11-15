
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="d-flex justify-content-center text-primary">Bienvenue sur Gest-Collect'</h1>
            <div class="d-flex justify-content-center text-secondary fst-italic">Le meilleur ami des collectionneurs!!</div>
        </div>
    </div>
    <div class="row">



        les derniers utilisateurs


    </div>


    <div class="row">
        <div class="col">
            <!-- Section principale pour afficher la liste des objets -->
                <div class="card h-100">
                    <div class="card-header">Liste des objets
                    </div>
                    <div class="card-body">
                        <!-- Boucle pour diviser les items en groupes de 4, afin d'organiser l'affichage par lignes -->
                        <?php foreach(array_chunk($items, 4) as $chunk) : // Diviser les éléments en groupes de 4 ?>
                            <div class="row shelf-row px-4 ">
                                <!-- Boucle à travers chaque item du groupe de 4 -->
                                <?php foreach($chunk as $item) : ?>
                                    <div class="col-md-3 col-6">
                                        <!--AFFICHAGE DE LA CARTE D'UN ITEM-->
                                        <div class="card h-100">
                                            <!--AFFICHAGE DE L'IMAGE PRINCIPALE-->
                                            <?php
                                            // Utilise l'image par défaut si aucune image n'est disponible pour l'item
                                            $img_src = !empty($item['default_img_file_path']) ? base_url($item['default_img_file_path']) : base_url('assets/brand/logo-bleu.svg');
                                            ?>
                                            <a href="<?= base_url('item/' . $item['slug']) ?>">
                                                <img src="<?= $img_src; ?>" class="card-img-top" alt="...">
                                            </a>
                                            <!--AFFICHAGE DU NOM DE L'OBJET-->
                                            <div class="card-body">
                                                <div class="card-title"><?= ucfirst($item['name']); ?></div>
                                            </div>
                                            <!--AFFICHAGE DES OPTIONS POUR AJOUTER OU SUPPRIMER DANS LA COLLECTION L'OBJET-->
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                        <!-- Affichage de la pagination au bas de la page -->
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
        </div>
    </div>

<!-- Styles personnalisés pour l'apparence des étagères (shelf) -->
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
    .card-img-top {
        width: 100%; /* Définissez la taille du carré souhaitée */
        height: 200px;
        object-fit: cover;
    }
</style>

