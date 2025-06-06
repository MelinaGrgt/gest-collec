<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3>Gestion des Licences d'objets</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <form action="<?=base_url('/admin/item/createlicense')?>" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5>Ajouter une licence</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Nom de la licence</label>
                    <input type="text" class="form-control" name="name">
                    <label class="form-label">Licence parente</label>
                    <select class="form-select" name="id_license_parent">
                        <option value="" selected>Aucun</option>
                        <?php foreach ($all_licenses as $license) { ?>
                            <option value="<?= $license['id']; ?>">
                                <?= $license['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Liste des licences</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover" id="tableLicenses">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Parent</th>
                        <th>Nom</th>
                        <th>Slug</th>
                        <th>Modif.</th>
                        <th>Supp.</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="modalLicense">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier License</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?=base_url('/admin/item/updatelicense')?>">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">
                        <label class="form-label" for="nom">Modifier le nom</label>
                        <input type="text" name="name" id="nom" class="form-control">
                        <label class="form-label">Licence parente</label>
                        <select class="form-select" name="id_license_parent">
                            <option value="" selected>Aucun</option>
                            <?php foreach ($all_licenses as $license) { ?>
                                <option value="<?= $license['id']; ?>">
                                    <?= $license['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" value="Valider">Sauvegarder les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var dataTable = $('#tableLicenses').DataTable({
            "responsive": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "language": {
                url: '<?= base_url("/js/datatable/datatable-2.1.4-fr-FR.json") ?>',
            },
            "ajax" : {
                "url" : "<?= base_url('/admin/item/searchdatatable'); ?>",
                "type" : "POST",
                "data" : { 'model' : 'ItemLicenseModel'}

            },
            "columns": [
                {"data": "id"},
                {"data": "id_license_parent"},
                { data: "name",
                    render : function(data){
                        return `<span class="name-license">${data}</span>`;
                    }
                },
                {"data": "slug"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-license-update" id="${data}" swal2-title="Êtes-vous sûr de vouloir modifier cette license" swal2-text=""href="<?= base_url('/admin/item/updatelicense/'); ?>${data}"><i class="fa-solid
                        fa-pencil text-primary"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-license-delete" id="${data}" swal2-title="Êtes-vous sûr de vouloir supprimer cette license" swal2-text=""href="<?= base_url('/admin/item/deletelicense/'); ?>${data}"><i class="fa-solid
                        fa-trash text-danger"></i></a>`;
                    }
                }
            ]
        });
        $("body").on('click','.swal2-license-delete', function(event){
            event.preventDefault();
            let title = $(this).attr("swal2-title");
            let text = $(this).attr("swal2-text");
            let link = $(this).attr('href');
            let id = $(this).attr("id");
            if (id == 1){
                Swal.fire('Impossible de supprimer "Aucune-License"!');
            } else {
                $.ajax({
                    type: "GET" ,
                    url: "<?=base_url('/admin/item/totalitemlicense');?>",
                    data: {
                        id: id,
                    },
                    success: function (data){
                        let json =JSON.parse(data);
                        console.log(json.total);
                        let title = "Supprimer une licence";
                        let text =`Cette licence est attribué à <b class="text-danger">${json.total}</b> objets. Êtes-vous sûr de vouloir continuer?`;
                        warningswal2(title,text,link);
                    }
                })
            }
        });
        $("body").on('click','.swal2-license-update',function (event){
            event.preventDefault();
            const modalLicense = new bootstrap.Modal('#modalLicense');
            modalLicense.show();
            let id_license = $(this).attr("id");
            let name = $(this).closest('tr').find('.name-license').html();
            console.log('name');
            $('.modal input[name="id"]').val(id_license);
            $('.modal input[name="name"]').val(name);
        })
    })
</script>