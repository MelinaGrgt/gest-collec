<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3>Types d'objet</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <form action="/admin/item/createtype" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5>Ajouter un type</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Nom du type</label>
                    <input type="text" class="form-control" name="name">
                    <label class="form-label">Type parent</label>
                    <select class="form-select" name="id_type_parent">
                        <option value="" selected>Aucun</option>
                        <?php foreach ($all_types as $type) { ?>
                            <option value="<?= $type['id']; ?>">
                                <?= $type['name']; ?>
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
                <h5>Liste des types</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover" id="tableTypes">
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
</div>
<script>
    $(document).ready(function () {
        var dataTable = $('#tableTypes').DataTable({
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
                "data" : { 'model' : 'ItemTypeModel'}

            },
            "columns": [
                {"data": "id"},
                {"data": "id_type_parent"},
                {"data": "name"},
                {"data": "slug"},
                {"data": "slug"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-type" id="${data}" href="<?= base_url('/admin/item/deletetype/');
                        ?>${data}"><i class="fa-solid fa-trash text-danger"></i></a>`;
                    }
                }
            ]
        });
        $("body").on('click', '.swal2-type', function(event) {
            event.preventDefault();
            let title = $(this).attr("swal2-title");
            let text = $(this).attr("swal2-text");
            let link = $(this).attr('href');
            let id = $(this).attr("id");
            if (id == 1) {
                Swal.fire("On ne peut pas supprimer \"Non classé\" !");
            } else {
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('/admin/item/totalitembytype'); ?>",
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        let json = JSON.parse(data);
                        let title = "Supprimer un type"
                        let text = `Cet type est attribué à <b class="text-danger">${json.total}</b> objets.
                        Êtes-vous sûr de vouloir continuer ?`;
                        warningswal2(title,text,link);
                    }
                })
            }
        });
    })
</script>