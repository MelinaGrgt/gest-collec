<form action="<?= base_url('/admin/item/' . (isset($item['id']) ? 'updateitem' : 'createitem')) ?>" method="POST" enctype="multipart/form-data">
    <?php if (isset($item['id'])): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex  align-items-center">
                    <input type="text" class="form-control me-4" placeholder="Titre de l'objet" name="name" value="<?= isset
                    ($item['name']) ? htmlspecialchars($item['name']) : '' ?>" required>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchActif" name="active" value="1" <?= (isset($item['active']) && $item['active'] == 1) ? "checked" : ""; ?> >
                        <label class="form-check-label" for="switchActif">Actif</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($item)) { ?>
    <div class="row">
        <div class="col">
            <a class="ms-4" target="_blank" href="<?= base_url("item/" . $item['slug']); ?>" title="Voir l'objet"><?= base_url("item/" . $item['slug']); ?>
            </a>
        </div>
    </div>
    <?php } ?>
    <div class="row mt-3">
        <!-- START: Central -->
        <div class="col-md-9">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-pane" type="button" role="tab" aria-controls="general" aria-selected="true">Général</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-pane" type="button" role="tab" aria-controls="image" aria-selected="false">Image</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="infos-tab" data-bs-toggle="tab" data-bs-target="#infos-pane" type="button" role="tab" aria-controls="infos" aria-selected="false">Infos</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="genre-tab" data-bs-toggle="tab" data-bs-target="#genre-pane" type="button" role="tab" aria-controls="genre" aria-selected="false">Genre</button>
                                </li>
                                <?php if (isset($item)) { ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment-pane" type="button" role="tab" aria-controls="comment" aria-selected="false">Commentaires</button>
                                </li>
                                <?php } ?>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content p-3">
                                <div class="tab-pane fade show active" id="general-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label" for="description">Description de l'objet</label>
                                            <textarea class="form-control" placeholder="Entrez une description pour l'objet" id="description" name="description"><?= isset($item['description']) ? htmlspecialchars($item['description']) : '' ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="image-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                                    <?php if (isset($medias)) : ?>
                                        <div class="row medias">
                                            <?php foreach ($medias as $media):?>
                                                <div class="col-4 col-md-2 mb-4 d-flex align-items-center position-relative media" data-id="<?=$media['id']; ?>">
                                                    <div class="media-mask bg-black bg-opacity-75 d-none rounded">
                                                        <div class="d-flex flex-column justify-content-center h-100 text-center p-2">
                                                            <div class="btn btn-danger mb-3 media-delete <?=($media['id'] == $item['id_default_img']) ? 'd-none':'';?>">
                                                                <i class="fa fa-solid fa-trash"></i> Supprimer
                                                            </div>
                                                            <div class="btn btn-warning media-default-img <?=($media['id'] == $item['id_default_img']) ? 'd-none':'';?>">
                                                                <i class="fa fa-solid fa-crown"></i> Définir comme image principale
                                                            </div>
                                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                                                <?= $media['entity_type'] ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <img class="img-thumbnail" src="<?= base_url($media['file_path']) ?>"?>
                                                        <span class="position-absolute top-0 start-5 translate-middle badge rounded-pill bg-warning  <?=($media['id'] == $item['id_default_img'])? '': 'd-none';?> ">
                                                            <i class="fa-solid fa-crown"></i>
                                                        </span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <input type="hidden" value="<?= $item['id_default_img'];?>" name="id_default_img">
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col">
                                            <input class="form-control" type='file' name='images[]' multiple>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="infos-pane" role="tabpanel" aria-labelledby="infos-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label">Prix</label>
                                            <input class="form-control" type="text" name="price" value="<?= isset($item['price']) ? htmlspecialchars($item['price']) : '' ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label">Date de sortie</label>
                                            <input class="form-control" type="date" name="release_date" value="<?= isset($item['release_date']) ? htmlspecialchars($item['release_date']) : '' ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="genre-pane" role="tabpanel" aria-labelledby="genre-tab" tabindex="0">
                                    <div class="row">
                                        <!-- Champ de recherche -->
                                        <div class="col">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
                                                <input type="text" id="search-genre" class="form-control" placeholder="Rechercher un genre">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-cols-4" id="genre-list">
                                        <?php
                                        foreach ($genres as $genre) {
                                            if (isset($genre_item)) {
                                                $genre_ids = array_column($genre_item, 'id_genre');
                                            }
                                            $isChecked = isset($genre_ids) && in_array($genre['id'], $genre_ids) ? 'checked' : '';
                                            ?>
                                            <div class="col genre-item">
                                                <input class="form-check-input" type="checkbox" value="<?= htmlspecialchars($genre['id']) ?>" id="chk-<?= htmlspecialchars($genre['slug']) ?>" name="genres[]" <?= $isChecked ?>>
                                                <label class="form-check-label" for="chk-<?= htmlspecialchars($genre['slug']) ?>">
                                                    <?= htmlspecialchars($genre['name']) ?>
                                                </label>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="comment-pane" role="tabpanel" aria-labelledby="comment-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col">
                                            <table class="table table-sm table-hover table-auto w-100" id="tableComments">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Reponse</th>
                                                    <th>Commentaire</th>
                                                    <th>Auteur</th>
                                                    <th>Date d'édition</th>
                                                    <th>Editer</th>
                                                    <th>Actif</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Central -->
        <!-- START: Sidebar -->
        <div class="col-md-3">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary">Valider</button>
                                            </div>
                                        </div>
                                        <?php if(isset($item)) : ?>
                                            <div class="card-footer">
                                                <small>Date de création : <?= date('d/m/Y h:i',strtotime($item['created_at'])); ?></small><br>
                                                <small>Date de modification : <?= date('d/m/Y h:i',strtotime($item['updated_at'])); ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="accordion" id="accordionType">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseType" aria-expanded="true" aria-controls="collapseType">
                                                    Type de l'objet
                                                </button>
                                            </h2>
                                            <div id="collapseType" class="accordion-collapse collapse" data-bs-parent="#accordionType">
                                                <div class="accordion-body">
                                                    <?php $treeTypes = buildTree($types, 'id_type_parent'); ?>
                                                    <?php displayTreeAsRadios($treeTypes, 'type', isset($item['id_type']) ? $item['id_type'] : null); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label" for="brand">Marque</label>
                                    <select class="form-control" id="brand" name="id_brand">
                                        <?php foreach($brands as $brand) {
                                            $selected = isset($item['id_brand']) && $brand['id'] == $item['id_brand'] ? 'selected' : '';
                                            ?>
                                            <option value="<?= htmlspecialchars($brand['id']) ?>" <?= $selected ?>><?= htmlspecialchars($brand['name']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label" for="license">Licenses</label>
                                    <select class="form-control" id="license" name="id_license">
                                        <?php foreach($licenses as $license) {
                                            $selected = isset($item['id_license']) && $license['id'] == $item['id_license'] ? 'selected' : '';
                                            ?>
                                            <option value="<?= htmlspecialchars($license['id']) ?>" <?= $selected ?>><?= htmlspecialchars($license['name']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Sidebar -->
    </div>
</form>
<?php
function buildTree(array $elements, $column_parent_name, $parentId = null) {
    $branch = [];
    foreach ($elements as $element) {
        if ($element['id_type_parent'] == $parentId) {
            $children = buildTree($elements, $column_parent_name, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

function displayTreeAsRadios(array $tree, $contextId, $selectedId = null) {
    foreach ($tree as $node) {
        // Créer un ID unique pour chaque catégorie pour relier le bouton radio et la div collapsible
        $uniqueId = $contextId . '_category_' . $node['id'];
        $collapseId = $contextId . '_collapse_' . $node['id'];

        // Déterminer si cet élément est sélectionné
        $isSelected = ($node['id'] == $selectedId) ? 'checked' : '';
        $isExpanded = ($node['id'] == $selectedId || hasSelectedChild($node, $selectedId)) ? 'show' : '';

        // Créer l'input radio
        echo '<div class="form-check">';
        echo '<input class="form-check-input" type="radio" name="id_' . $contextId . '" id="' . $uniqueId . '" value="' . $node['id'] . '" ' . $isSelected . ' data-bs-toggle="collapse" data-bs-target="#' . $collapseId . '" aria-expanded="false" aria-controls="' . $collapseId . '">';
        echo '<label class="form-check-label" for="' . $uniqueId . '">' . $node['name'] . '</label>';

        // Si la catégorie a des enfants, on les affiche dans une section collapsible
        if (isset($node['children'])) {
            echo '<div id="' . $collapseId . '" class="collapse ' . $isExpanded . '">';
            displayTreeAsRadios($node['children'], $contextId, $selectedId);
            echo '</div>';
        }

        echo '</div>';
    }
}

// Fonction pour vérifier si un enfant ou un descendant est sélectionné
function hasSelectedChild($node, $selectedId) {
    if ($node['id'] == $selectedId) {
        return true;
    }
    if (isset($node['children'])) {
        foreach ($node['children'] as $child) {
            if (hasSelectedChild($child, $selectedId)) {
                return true;
            }
        }
    }
    return false;
}

?>
<script>
    $(document).ready(function () {
        document.getElementById('search-genre').addEventListener('input', function () {
            var searchValue = this.value.toLowerCase();
            var genreItems = document.querySelectorAll('.genre-item');

            genreItems.forEach(function (item) {
                var genreName = item.querySelector('label').textContent.toLowerCase();

                // Affiche ou masque les genres en fonction de la recherche
                if (genreName.includes(searchValue)) {
                    item.style.display = 'block'; // Afficher l'élément
                } else {
                    item.style.display = 'none'; // Masquer l'élément
                }
            });
        });

        tinymce.init({
            selector: '#description',
            height: "300",
            language: 'fr_FR',
            menubar: false,
            plugins: [
                'preview', 'code', 'fullscreen', 'wordcount', 'link', 'lists',
            ],
            skin: 'oxide',
            content_encoding: 'text',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic link forecolor backcolor removeformat | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' + ' fullscreen  preview code'
        });

        $('.medias').on('mouseenter mouseleave', '.media', function () {
            $(this).find('.media-mask').toggleClass('d-none');
        });
        $('.medias').on('click', '.media-delete', function (e) {
            let media = $(this).closest('.media');
            let id = media.data("id");
            let url = "<?= base_url('/admin/media/delete/') ?>";
            url = url + id;
            Swal.fire({
                title: "Êtes-vous sûr?",
                text: "L'image sera définitivement supprimée !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui !",
                cancelButtonText: "Annuler"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function (data) {
                            if (data == "true") {
                                media.remove();
                                Swal.fire({
                                    title: "Supprimé!",
                                    text: "Le fichier à bien été supprimé.",
                                    icon: "success"
                                });
                            } else {
                                Swal.fire({
                                    title: "Pas supprimé!",
                                    text: "Le fichier n'a pas été supprimé.",
                                    icon: "error"
                                });
                            }
                        }
                    });
                }
            });
        });

        //Changement de l'image par défaut
        $('.medias').on('click', '.media-default-img', function (e) {
            // Empêche l'action par défaut de l'événement
            e.preventDefault();

            // Sélectionne l'élément parent avec la classe "media" le plus proche de l'élément cliqué
            let new_default = $(this).closest('.media');

            // Récupère l'ID de la nouvelle image par défaut à partir de l'attribut "data-id" de l'élément "media"
            let new_default_id = new_default.data('id');

            // Récupère l'ID de l'image actuellement définie comme par défaut depuis l'input caché "id_default_img"
            let old_default_id = $('input[name="id_default_img"]').val();

            // Trouve l'élément "media" correspondant à l'ancienne image par défaut
            let old_default = $('.media[data-id="' + old_default_id + '"]');

            // Si l'ID de la nouvelle image par défaut est différent de l'ancienne
            if (new_default_id != old_default_id) {
                // Met à jour la valeur de l'input caché "id_default_img" avec l'ID de la nouvelle image par défaut
                $('input[name="id_default_img"]').val(new_default_id);

                // Cache le bouton "media-default-img" et le bouton "media-delete" pour la nouvelle image par défaut
                new_default.find('.media-default-img').addClass('d-none');
                new_default.find('.media-delete').addClass('d-none');

                // Affiche le badge de couronne pour la nouvelle image par défaut
                new_default.find('.badge.bg-warning').removeClass('d-none');

                // Pour l'ancienne image par défaut, on fait l'inverse : on affiche les boutons "media-default-img" et "media-delete"
                old_default.find('.media-default-img').removeClass('d-none');
                old_default.find('.media-delete').removeClass('d-none');

                // Et on cache le badge de couronne pour l'ancienne image par défaut
                old_default.find('.badge.bg-warning').addClass('d-none');
            }
        });

        var baseUrl = "<?= base_url(); ?>";
        var dataTable = $('#tableComments').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: '<?= base_url("/js/datatable/datatable-2.1.4-fr-FR.json") ?>',
            },
            "ajax": {
                "url": "<?= base_url('/admin/item/searchdatatable'); ?>",
                "type": "POST",
                "data" : { 'model' : 'CommentModel', 'filter':'item','filter_value':'<?= isset($item['id']) ?? $item['id']; ?>'}
            },
            "columns": [
                {"data": "id"},
                {"data": "id_comment_parent"},
                {"data" : 'content'},
                {"data":'username'},
                {"data" : 'updated_at'},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a id="${data}" href="<?= base_url('/admin/comment/');?>${data}"><i class="fa-solid fa-pencil text-success"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver le commentaire" href="<?=base_url('/admin/comment/deactivatecomment/');?>${row.id}"><i class="fa-solid fa-xl
                            fa-toggle-on text-success"></i></a>`: `<a title="Activer" href="<?=base_url('/admin/comment/activatecomment/');?>${row.id}"><i class="fa-solid fa-toggle-off fa-xl text-danger"></i></a>`);
                    }
                }
            ]
        });
    });
</script>
