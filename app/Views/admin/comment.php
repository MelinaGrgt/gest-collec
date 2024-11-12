<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>Editer le commentaire n° <strong> <?= $comment['id']?></strong> pour l'objet <strong><?=ucfirst($comment['itemname'])?></strong></span>

                <i class="fa-solid fa-xl fa-toggle-on text-success"></i>
                <i class="fa-solid fa-toggle-off fa-xl text-danger"></i>


            </div>
            <div class="card-body">
                Commentaire posté par : <strong><?= ucfirst($comment['username']) ?></strong> le <?= $comment['updated_at'] ?>
                <form method="post" action="<?=base_url('/admin/comment/updatecomment')?>">
                        <textarea name="content" class="form-control mt-3"><?=$comment['content']?></textarea>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm mt-3 ">Valider les modifications</button>
                    </div>
                    <input type="hidden" name="id" value="<?=$comment['id']?>">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(e){
        var baseUrl = "<?= base_url(); ?>";
        $("card-header").on('click','.fa-toggle',function (event){
            <!--TODO-->
        }
    })
</script>


