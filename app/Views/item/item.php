<style>
    .splide {
        margin: 0 auto;
        type : loop;
        focus    : 'center';
        autoWidth: true;
        autoHeight: true;
    }

    .thumbnails {
        display: flex;
        margin: 1rem auto 0;
        padding: 0;
        justify-content: center;
    }

    .thumbnail {
        width: 70px;
        height: 70px;
        overflow: hidden;
        list-style: none;
        margin: 0 0.2rem;
        cursor: pointer;
        opacity: 0.3;
    }

    .thumbnail.is-active {
        opacity: 1;
    }

    .thumbnail img {
        width: 100%;
        height: auto;
    }

    .splide__slide img {
        width: auto;
        height: auto;
        object-fit: contain; /* ajuste l'image pour qu'elle soit entièrement visible et conserve son ratio */
        object-position: center; /* centre l'image si elle est plus petite */
        display: block; /* évite les espaces blancs autour de l'image */
    }

    #main-carousel {
        width: auto; /* largeur du carousel */
        height: auto; /* hauteur fixe du carousel, ajuste cette valeur selon tes besoins */
        overflow: hidden; /* masque les débordements */
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
             <div class="card-header">
                <div class="card-title py-1 d-flex justify-content-between align-items-center">
                    <!--affichage nom de l'objet-->
                    <h2 class="mb-0"><?=ucfirst($item['item_name'])?></h2>
                    <!--Affichage du type de l'objet-->
                    <a class="badge text-bg-light border border-secondary link-offset-2 link-dark link-underline link-underline-opacity-0" href="<?= base_url('item?type[slug]=' . $item['type_slug']); ?>"><?=ucfirst($item['type_name'])?></a>
                </div>
                 <!--Affichage de la notation-->
                 <div class="d-flex align-items-center">
                     <div class="rating">
                         <?php if($AVGrating==null) { ?>
                             Pas encore noté <br>
                         <?php } else { renderStars($AVGrating);}?>
                     </div>
                 <div>
            </div>
        </div>
    </div>
</div>
<!--zone d'affichage de gauche-->
<div class="row mt-3">
    <div class="col-md-9">
        <div class="row">
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <!-- Carrousel d'images-->
                        <div class="mb-3 bg-secondary-subtle">
                        <!-- Affichage de l'image en grand-->
                            <section id="main-carousel" class="splide bg-body" aria-label="My Awesome Gallery">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <!--affichage de l'image par principal, sinon affichage de l'image par default-->
                                        <?php if(empty($item['medias'])){ ?>
                                            <li class="splide__slide">
                                                <img src="<?= base_url('/assets/brand/logo-bleu.svg') ?>" alt="Image de l'objet" title="Image par défaut"
                                            </li>
                                            <?php } else {
                                                if (isset($item['default_img']) && !empty ($item['default_img']['file_path'])) { ?>
                                                    <li class="splide__slide">
                                                        <img src="<?= base_url($item['default_img']['file_path'])?>" alt="Image de l'objet" title="Image principale">
                                                    </li>
                                                <?php }
                                              } ?>
                                        <!--affichage des autres images s'il y en a-->
                                        <?php if (!empty($item['medias'])) :
                                            foreach ($item['medias'] as $media) :
                                                if (!empty($media['file_path']) && $media['id']!=$item['id_default_img']) : ?>
                                                    <li class="splide__slide">
                                                        <img src="<?= base_url($media['file_path']) ?>" alt="Image de l'objet<?=ucfirst($item['item_name'])?>">
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </section>
                            <!-- fin de l'Affichage de l'image en grand-->
                            <!--Affichage des mignatures-->
                            <ul id="thumbnails" class="thumbnails">
                                <?php if(empty($item['medias'])){ ?>
                                    <li class="thumbnail">
                                        <img src="<?= base_url('/assets/brand/logo-bleu.svg') ?>" alt="Image de l'objet" title="Image par défaut"
                                    </li>
                                <?php } else {
                                    if (isset($item['default_img']) && !empty ($item['default_img']['file_path'])) { ?>
                                        <li class="thumbnail">
                                            <img src="<?= base_url($item['default_img']['file_path'])?>" alt="Image de l'objet" title="Image principale">
                                        </li>
                                    <?php }
                                } ?>
                                <?php if (!empty($item['medias'])) :
                                    foreach ($item['medias'] as $media) :
                                        if (!empty($media['file_path']) && $media['id']!=$item['id_default_img']) : ?>
                                <li class="thumbnail">
                                    <img src="<?= base_url($media['file_path']) ?>" alt="Image de l'objet">
                                </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <!--fin du caroussel pour les images-->

                        <!--Affichage de la description-->
                        <div class="border border-dark-subtle border-1 rounded-2">
                            <div class="card-header">
                                <h5>Description de <?=ucfirst($item['item_name'])?></h5>
                            </div>
                            <div class="card-body">
                                <?= ucfirst($item['description']) ?>
                            </div>
                        </div>
                        <!--Affichage des commentaires-->
                        <div class="border border-dark-subtle border-1 rounded-2 mt-3" id="commentaires-section">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="col-6" id="avis-section">
                                    <h5 id="C10">Avis</h5>
                                    <div>
                                        <!--Affichage de la note et du nombre de commentaires-->
                                        <?php if($AVGrating==null) { ?>
                                            Pas encore noté |
                                        <?php } else { renderStars($AVGrating);}?>
                                        <?=$totalcomments?> avis.</div>
                                </div>
                                <div class="col-3 d-flex justify-content-end">
                                    <!--BOUTON POUR OUVRIR LA MODAL pour laisser un COMMENTAIRE-->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Laisser un avis
                                    </button>
                                </div>
                                <?php if(isset($user)){?>
                                <!-- Modal POUR LAISSER UN COMMENTAIRE-->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Laisser un avis sur <?=ucfirst($item['item_name'])?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <!--FORMULAIRE POUR LES COMMENTAIRES-->
                                            <form action="<?= base_url('/comment/createitemcomment');?>" method="post">
                                            <div class="modal-body">
                                                <!--Le commentaire-->
                                                <textarea class="form-control mt-3" placeholder="Entrez votre avis (max 250 caractères)" id="avis" name="content" size="250" maxlength="250" minlength="3" required></textarea>
                                                <!--Champs cachés pour envoyer l'id_item et l'entity_type-->
                                                <input type="hidden" name="entity_id" value="<?= $item['id']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Envoyer mon avis</button>
                                            </div>
                                            </form>
                                            <!--Fin du formulaire-->
                                        </div>
                                    </div>
                                </div>
                                <!--fin de la modal-->
                                    <!-- si l'utilisateur n'est pas connecté ouvre une modal pour l'inviter à se connecter-->
                                <?php } else {?>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Laisser un avis sur <?=ucfirst($item['item_name'])?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                    <div class="modal-body">
                                                        Merci de vous connecter pour laisser un commentaire
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <a href="<?=base_url('/login')?>"><button type="button" class="btn btn-primary">Connexion / Inscription</button></a>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--fin de la modal-->
                                <?php }?>
                            </div>
                            <!--AFFICHAGE DES COMMENTAIRES-->
                            <div class="card-body">
                                <?php if (isset($comments) && !empty($comments)): ?>
                                    <?php foreach ($comments as $C): ?>
                                        <div class="border border-secondary-subtle rounded-1 mb-3 p-2">
                                            <div class="d-flex justify-content-between">
                                                <?=$C['content']?>
                                                <span>
                                                    <?php if(isset($user)){
                                                        if($user->id == $C['id_user']){ ?>
                                                            <span>J'aime <?=$C["nb_likes"]?></span>
                                                         <?php } else
                                                         {?>
                                                            <!--Bouton pour répondre/commenter le commentaire de quelqu'un d'autre -->
                                                             <i class="fa-regular fa-comment-dots text-primary" type="button" data-bs-toggle="modal" data-bs-target="#commentcomment" title="Commenter"></i>
                                                             <!-- Modal ouverte par le bouton-->
                                                             <div class="modal fade" id="commentcomment" tabindex="-1" aria-labelledby="commentcomment" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="commentcomment">Répondre à <?=ucfirst($C['username'])?></h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <!--FORMULAIRE POUR LES COMMENTAIRES-->
                                                                        <form action="<?= base_url('/comment/createitemcomment');?>" method="post">
                                                                            <div class="modal-body">
                                                                            <!--Le commentaire-->
                                                                                <textarea class="form-control mt-3" placeholder="Entrez votre avis (max 250 caractères)" id="avis" name="content" size="250" maxlength="250" minlength="3" required></textarea>
                                                                                 <!--Champs cachés pour envoyer l'id_item et l'entity_type-->
                                                                                <input type="hidden" name="entity_id" value="<?= $item['id']; ?>">
                                                                                <input type="hidden" name="id_comment_parent" value="<?= $C['id']; ?>">
                                                                            </div>
                                                                                <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                                <button type="submit" class="btn btn-primary">Envoyer mon avis</button>
                                                                                </div>
                                                                             </form>
                                                                             <!--Fin du formulaire-->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <!--fin de la modal-->


                                                                <!-- bouton pour les likes-->

                                                               <i class="fa-solid fa-thumbs-up text-primary"  id="like-button" type="button" data-item-id="<?= $C['id'] ?>" title="J'aime"></i>

                                                             <!--Affichage du nombre de like par commentaire-->
                                                             <span id="likes_display">| J'aime <?=$C["nb_likes"]?></span>
                                                          <?php }
                                                    } ?>
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between ">
                                                <span>
                                                   <?php if($C['profile_file_path'] == null){?>
                                                       <b><i class="fa-solid fa-user text-primary-emphasis me-2"></i><?=ucfirst($C['username'])?></b>
                                                 <?php } else { ?>
                                                    <img src="<?= base_url($C['profile_file_path']) ?>" alt="Avatar" style="max-width: 25px; height: auto;"><b></i><?=ucfirst($C['username'])?></b>
                                                   <?php } ?>
                                                </span>
                                                <span>
                                                    <small>
                                                        Avis posté le :
                                                         <?php
                                                            // Créer un objet DateTime à partir de la date au format année-mois-jour
                                                            $date = new DateTime($C['date']);
                                                            // Afficher la date au format jour-mois-année
                                                            echo $date->format('d-m-Y');
                                                        ?>
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Pas encore d'avis sur cet objet, soyez le premier !!</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--fin zone d'affichage de gauche-->
    <!--Début zone d'affichage de droite-->
    <div class="col-md-3">
        <div class="row">
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-grid">
                        <!--boutons pour gerer l'ajout ou la suppression à la collection-->
                            <?php if($possede == false){?>
                                <a href="<?=base_url("/collection/addcollection/".$item['id'])?>" class="btn btn-primary mb-3">
                                    <i class="fa-solid fa-plus"></i>
                                    Ajouter à ma collection
                                </a>
                               <?php }  else {?>
                            <a href="<?=base_url("/collection/removecollection/".$item['id'])?>" class="btn btn-danger mb-3">
                                <i class="fa-solid fa-minus"></i>
                                Retirer de ma collection
                            </a> <?php } ?>
                            <!--AFFICHAGE DE LA DATE DE SORTIE DE L'ITEM-->
                            <small>Date de Sortie :
                                <?php if($item['release_date']=='0000-00-00'):?>
                                    Non renseignée
                                <?php else :?>
                                    <?php
                                    // Créer un objet DateTime à partir de la date au format année-mois-jour
                                    $date = new DateTime($item['release_date']);
                                    // Afficher la date au format jour-mois-année
                                    echo $date->format('d-m-Y');
                                    ?>
                                <?php endif; ?>
                            </small>
                            <!--AFFICHAGE DU PRIX DE L'ITEM-->
                            <small>Prix : <?= number_format($item['price'], 2, ',', ' ') ?>€</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!--Affichage de la LICENSE-->
                        <div class="mb-1"><a class="link-offset-2 link-dark link-underline link-underline-opacity-0" href="<?= base_url('item?license[slug]=' . $item['license_slug']); ?>">Licence : <?=ucfirst($item["license_name"])?></a>
                        </div>
                       <hr>
                        <!--Affichage de la MARQUE-->
                        <div class="mb-1"><a class="link-offset-2 link-dark link-underline link-underline-opacity-0" href="<?= base_url('item?brand[slug]=' . $item['brand_slug']); ?>">Marque : <?=ucfirst($item["brand_name"])?> </a>
                        </div>
                        <hr>
                        <!--Affichage des GENRES-->
                        <div class="mb-1">
                            Genre :
                            <?php if(isset($item['AllGenreNames'])):
                                foreach ($item['AllGenreNames'] as $agn)
                                    { ?>
                                        <span class="badge text-bg-light border border-secondary"><?=ucfirst($agn["AllGenreNames"])?></span>
                                <?php }; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--fin zone d'affichage de droite-->

<script>
    //Gestion du carroussel en JS
    var splide = new Splide( '#main-carousel', {
        width: '600px',
        height: '600px',
        pagination: true,
        arrows: true,
        cover: true,
        rewind:true
    } );

    var thumbnails = document.getElementsByClassName( 'thumbnail' );
    var current;

    for ( var i = 0; i < thumbnails.length; i++ ) {
        initThumbnail( thumbnails[ i ], i );
    }

    function initThumbnail( thumbnail, index ) {
        thumbnail.addEventListener( 'click', function () {
            splide.go( index );
        } );
    }

    splide.on( 'mounted move', function () {
        var thumbnail = thumbnails[ splide.index ];

        if ( thumbnail ) {
            if ( current ) {
                current.classList.remove( 'is-active' );
            }

            thumbnail.classList.add( 'is-active' );
            current = thumbnail;
        }
    } );
    splide.mount();
</script>
<script>
    $(document).ready(function() {
        //declaration des variables
        let nblikes = 0;

        function updateDisplay() {
            $('#likes_display').text(`| J'aime ${nblikes}`);
        }

        $('#like-button').click(function() {
            nblikes += 1;  // Incrémente le nombre de likes
            updateDisplay();  // Met à jour l'affichage
        });
        updateDisplay();
    });
</script>







<!--RECUPERE LES DONNEES DE $ITEM POUR LES AFFFICHER LORSQUE L'ON CLICK SUR LE POINT D'INTERROGATION-->
<?php if (isset($user) && $user->isAdmin()) : ?>
    <a class="link-underline-opacity-0 position-fixed bottom-0 end-0 m-4" data-bs-toggle="offcanvas" href="<?=base_url('#offcanvasItem')?>" role="button" aria-controls="offcanvasExample">
        <i class="fa-solid fa-circle-question fa-2xl"></i>
    </a>

    <div class="offcanvas offcanvas-end" style="width:600px" data-bs-backdrop="static" tabindex="-1" id="offcanvasItem" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Mon Objet</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <pre>
                  <?php
                  if (isset($item)) {
                      print_r($item);
                  }?>
                </pre>
                <pre>
                  <?php
                  if (isset($user)) {
                      print_r($user);
                  }?>
                </pre>

            </div>
        </div>
    </div>
<?php endif; ?>

<?php

function renderStars($rating) {
    $fullStars = floor($rating);// Étoiles pleines
    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0; // Demi-étoile si nécessaire
    $emptyStars = 5 - ($fullStars + $halfStar); // Étoiles vides
        // Afficher les étoiles pleines
    for ($i = 0; $i < $fullStars; $i++) {
        echo '<i class="fa fa-star text-warning"></i>';
    }
        // Afficher la demi-étoile si applicable
    if ($halfStar) {
        echo '<i class="fa fa-star-half-alt text-warning"></i>';
    }
        // Afficher les étoiles vides
    for ($i = 0; $i < $emptyStars; $i++) {
        echo '<i class="fa-regular fa-star text-body-tertiary"></i>';
    }
}
?>