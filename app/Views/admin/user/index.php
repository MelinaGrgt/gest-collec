<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des utilisateurs</h4>
        <a href="/admin/user/new"><i class="fa-solid fa-user-plus"></i></a>
    </div>
    <div class="card-body">
        <table id="tableUsers" class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Modifier</th>
                <th>Actif</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function () {
        var dataTable = $('#tableUsers').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: '<?= base_url("/js/datatable/datatable-2.1.4-fr-FR.json") ?>',
            },
            "ajax": {
                "url": "<?= base_url('/admin/user/SearchUser'); ?>",
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {"data": "username"},
                {"data": "email"},
                {"data": "permission_name"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a href="/admin/user/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver l'utilisateur" href="/admin/user/deactivate/${row.id}"><i class="fa-solid fa-xl fa-toggle-off text-success"></i></a>`: `<a title="Activer un utilisateur"href="/admin/user/activate/${row.id}"><i class="fa-solid fa-toggle-on fa-xl text-danger"></i></a>`);
                    }
                }
            ]
        });
    });

</script>