<div class="row row-cards">
    <div class="card col-sm-12">
        <div class="card-header">
            <h3 class="text-center card-title col-sm-7">Nom du groupe: <b>Departement de Genie Informatique</b></h3>
        </div>
        <div>
            <a href="javascript:void()" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary pull-right"><i class="fe fe-user-plus"></i> Enregistrer Un Utilisateur</a>
            <a href="" class="btn btn-green pull-right"><i class="fe fe-edit"></i> Modifier le groupe</a>
            <a href="" class="btn btn-danger pull-right"><i class="fe fe-edit"></i> Supprimer le groupe</a>
        </div>
        <div class="table-responsive">
            <h3 class="card-title">Liste des membres</h3>
            <table class="table card-table table-vcenter text-wrap">
                <thead>
                <tr>
                    <th class="w-1">No.</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Date d'enregistrement</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><span class="text-muted">1</span></td>
                    <td>BATOURI</td>
                    <td>Emmanuel</td>
                    <td>26/12/2017</td>
                    <td class="text-right">
                        <a href="" class="btn btn-primary">Détails</a>
                    </td>
                </tr>
                <tr>
                    <td><span class="text-muted">1</span></td>
                    <td>KAKANOU</td>
                    <td>Albert</td>
                    <td>26/06/2018</td>
                    <td class="text-right">
                        <a href="" class="btn btn-primary">Détails</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enregistrement du groupe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-user" method="post" enctype="multipart/form-data" action="<?php echo site_url('utilisateur/add-user') ?>">
                    <div class="form-group row">
                        <label for="nom" class="form-label">Nom</label>
                        <div class="">
                            <input type="text" class="form-control" value="<?php echo set_value("nom") ?>" name="nom" placeholder="Nom">
                            <?php echo form_error("nom") ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="prenom" class="form-label">Prenom</label>
                        <div class="">
                            <input type="text" class="form-control" value="<?php echo set_value("prenom") ?>" name="prenom" placeholder="Prenom">
                            <?php echo form_error("prenom") ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="groups" class="form-label">Selectionnez le groupe</label>
                        <div class="">
                        <?php if(isset($groups) And is_array($groups)){ ?>
                            <select name="groups" class="select2 form-control" multiple>
                                <option value="" <?php echo set_select("groups", "", true) ?>>Tout les utilisateurs</option>
                                <?php foreach($groups as $group){ ?>
                                <option value="<?php echo $group->id ?>" <?php echo set_select("groups", $group->id) ?>><?php echo $group->name ?></option>
                                <?php } ?>
                            </select>
                            <?php echo form_error("groups") ?>
                        <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary reset" data-dismiss="modal">Fermer</button>
                <button class="btn btn-primary submit">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
<script>
    require(['jquery', 'dataTable4'], function(){
        $(document).ready(function(){
            var dataTable = $('table').dataTable({
                "ordering": true,
                "responsive": true,
                "lengthMenu":[[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
            });
            
            $('#form-add-user > button.submit').on('click', function(){
                $.ajax({
                    url: '<?php echo site_url('utilisateur/add-user') ?>',
                    method: 'POST',
                    data: $('#form-add-user').serializeArray(),
                    success: function(result){
                        if(parseInt(result.error) == 0){
                            dataTable.fnDraw();
                            toast({
                                type: 'success',
                                title: JStranslate('Activation effectué.', 'Turn on.')
                            });
                        }else{
                            toast({
                                type: 'error',
                                html: ''+result.msg
                            });
                        }
                    },
                    error: function(xhr){
                        xhrError(xhr);
                    }
                });
            });
            $('#form-add-user > button.reset').on('click', function(){
                $('#form-add-user').serializeArray().each(function(key, val){
                    $('#form-add-user > [name="'+val.name+'"]').val('');
                });
            });
        });
    });
</script>