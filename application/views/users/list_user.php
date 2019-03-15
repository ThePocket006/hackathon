<div class="row row-cards">
    <div class="card col-sm-12">
        <div class="card-header">
            <h3 class="card-title">Liste des utilisateurs</h3>
        </div>


        <div class="table-responsive">
            <div style="padding: 10px" class="col-sm-12 " >
                <div class="card card-no-border">
                    <div class="card-block" >
                        <?php
                        if (!isChefDepartement()) {
                            ?>
                        
                                <div class="row p-2">
                                <h4 class="col-sm-12 col-md-12">Effectuer un filtre</h4>
                                    <?php if (isGeneralAdmin()) {
                                        ?>
                                        <div class="col-sm-12 col-md-6 mb-1">
                                            <div class="input-group">
                                                <label style="margin-right: 3%">Groupe :</label>
                                                <select class="form-control" id="groupe">
                                                    <?php foreach ($groupes as $groupe) {
                                                        ?>
                                                        <option value="<?php echo $groupe->id ?>"><?php echo $groupe->name ?></option>
                                                        <?php

                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php

                                    } else {
                                        ?>
                                        <input type="hidden" name="group" id="groupe" value="<?php echo session_data('groupId') ?>">
                                        <?php

                                    } ?>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="input-group" >
                                            <label style="margin-right: 3%">Sous Groupe :</label>
                                            <select class="form-control" id="sgroupe">

                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-md-12 p-2 mb-1">
                                            <div class="row">
                                                <div class="input-group col-md-4 col-md-offset-4">
                                                    <button class="btn btn-primary" id="filtrer">Filtrer</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                        
                            <?php

                        }
                        ?>


                    </div>
                </div>
            </div>
            <table class="table card-table table-vcenter text-wrap">
                <thead>
                <tr>
                    <th class="w-1">No.</th>
                    <th>Détails utilisateur</th>
                    <th>Groupe</th>
                    <th>Sous groupe</th>
                    <th>Role</th>
                    <th>Statut</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody id="display">
                <?php
                $k = 0;
                foreach ($users as $user) {
                    $k++;
                    ?>
                    <tr>
                        <td><?php echo $k; ?></td>
                        <td>
                            <?php
                            echo "Nom : <b>$user->name</b> <br>";
                            echo "Login : <b>$user->login</b> <br>";
                            echo "Email : <b>$user->email</b> <br>";
                            echo "Date d'enregistrement : <b>" . moment($user->register_date)->format('d-m-Y');
                            ?>
                        </td>
                        <td>
                            <?php echo $user->grpName ?>
                        </td>
                        <td>
                            <?php echo ($user->sgrpName == null) ? "Aucun sous groupe" : $user->sgrpName; ?>
                        </td>
                        <td><?php echo $user->rName ?></td>
                        <td><?php echo ($user->status == COMPTE_BLOQUE) ? "<span class='status-icon bg-danger'></span> Compte bloqué" : "<span class='status-icon bg-success'></span> Compte actif" ?></td>
                        <td class="text-right">
                            <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle">Actions</button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if ($user->status == COMPTE_BLOQUE) {
                                    ?>
                                    <a class="dropdown-item" href="<?php echo site_url('utilisateur/listUsers/unlocked/' . $user->id) ?>">
                                        Activer
                                    </a>
                                    <?php

                                } else {
                                    ?>
                                    <a class="dropdown-item" href="<?php echo site_url('utilisateur/listUsers/locked/' . $user->id) ?>">
                                        Bloquer
                                    </a>
                                    <?php

                                } ?>

                                <a class="dropdown-item" href="javascript:void(0)">
                                    Voir les logs
                                </a>

                            </div>
                        </td>
                    </tr>
                    <?php

                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    require([ 'jquery'], function() {
        var groupe = $("#groupe").val();
        $.post("<?php echo site_url('utilisateur/displaySgroupofGroup') ?>",{groupe:groupe},function(data){
            $("#sgroupe").html(data);
        });
        $("#groupe").change(function() {
            var groupe = $("#groupe").val();
            $.post("<?php echo site_url('utilisateur/displaySgroupofGroup') ?>",{groupe:groupe},function(data){
                $("#sgroupe").html(data);
            });


        });
        $("#filtrer").click(function(){
           var groupe = $("#groupe").val();
            var sgroupe = $("#sgroupe").val();
            $.post("<?php echo site_url('utilisateur/usersGroupSgroup') ?>",{groupe:groupe ,sgroupe:sgroupe},function(data){
                $("#display").html(data);
            });
        });
    });
    require(['dataTables.net-bs4-responsive', 'select2', 'ckeditor-jquery'], function(){

            $('table').DataTable({
                ordering:false,
            });


    });

</script>

