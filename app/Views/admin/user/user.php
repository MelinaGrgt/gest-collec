<div class="row">
    <div class="col">
        <!--Début du formulaire-->
        <form action="<?= isset($utilisateur) ? "/admin/user/update" : "/admin/user/create" ?>" method="POST"  enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <?= isset($utilisateur) ? "Editer l'utilisateur: " . $utilisateur['username'] : "Créer un utilisateur" ?>
                    </h4>
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="profil">
                        <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil-pane" type="button" role="tab" aria-controls="profil" aria-selected="true">Profil</button>
                    </li>
                    <?php if(isset($utilisateur)){?>
                        <li class="nav-item" role="Commentaires">
                            <button class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment-pane" type="button" role="tab" aria-controls="comment" aria-selected="false">Commentaires</button>
                        </li>
                   <?php } ?>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane fade show active" id="profil-pane" role="tabpanel" aria-labelledby="profil-tab" tabindex="0">
                        <div class="row">
                            <div class="col">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Nom d'utilisateur</label>
                                        <input type="text" class="form-control" id="username" placeholder="Nom d'utilisateur" value="<?= isset($utilisateur) ? $utilisateur['username'] : ""; ?>" name="username">
                                    </div>
                                    <div class="mb-3">
                                        <label for="mail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="mail" placeholder="Email" value="<?= isset($utilisateur) ? $utilisateur['email'] : "" ?>" name="email" <?= isset($utilisateur) ? "readonly" : "" ?> >
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Mot de passe</label>
                                        <input type="password" class="form-control" id="password" placeholder="Mot de Passe" value="" name="password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_permission" class="form-label">Rôle</label>
                                        <select class="form-select" id="id_permission" name="id_permission">
                                            <option disabled <?= !isset($utilisateur) ? "selected":""; ?> >Selectionner un role</option>
                                            <?php foreach($permissions as $p): ?>
                                                <option value="<?= $p['id']; ?>" <?= ( isset($utilisateur) && $p['id'] == $utilisateur['id_permission']) ? "selected" : "" ?> >
                                                    <?= $p['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Avatar</label>
                                        <input class="form-control" type="file" name="profile_image" id="image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="comment-pane" role="tabpanel" aria-labelledby="comment-tab" tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-sm table-hover" id="tableComments" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%;">ID</th>
                                        <th style="width: 5%;">Commentaire Parent</th>
                                        <th style="width: 15%;">Objet</th>
                                        <th style="width: 50%;">Commentaires</th>
                                        <th style="width: 15%;">Date d'édition</th>
                                        <th style="width: 5%;">Editer</th>
                                        <th style="width: 5%;">Actif</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                     </div>
                </div>
                <!--Footer avec le bouton pour valider le formulaire-->
                <div class="card-footer text-end">
                    <?php if (isset($utilisateur)): ?>
                        <input type="hidden" name="id" value="<?= $utilisateur['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($utilisateur) ? "Sauvegarder les modifications" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>
        <!--Fin du formulaire-->
    </div>
</div>
<script>
    $(document).ready(function () {
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
                "data" : { 'model' : 'CommentModel', 'filter':'user','filter_value':'<?=$utilisateur['id'];?>'}
            },
            "columns": [
                {"data": "id"},
                {"data": "id_comment_parent"},
                {"data": "name"},
                {"data" : 'content'},
                {"data" : 'updated_at'},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a id="${data}" href="<?= base_url('/admin/comment/'); ?>${data}"><i class="fa-solid fa-pencil text-success"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver le commentaire" href="/admin/comment/deactivatecomment/${row.id}"><i class="fa-solid fa-xl
                            fa-toggle-on text-success"></i></a>`: `<a title="Activer" href="/admin/comment/activatecomment/${row.id}"><i class="fa-solid fa-toggle-off fa-xl text-danger"></i></a>`);
                    }
                }
            ]
        });
    });
</script>