<div class="row row-cards">
    <div class="card col-sm-12">
        <div class="card-header">
            <h3 class="card-title">Liste des groupes</h3>
        </div>

<div class="card-body">
<div class="table-responsive">
            <table class="table card-table table-vcenter text-wrap">
                <thead>
                <tr>
                    <th class="w-1">No.</th>
                    <th>Groupe</th>
                    <th>Etat</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody id="display">
                <?php
                $k = 0;
                foreach($groupes as $groupe){
                    $k++;
                    ?>
                    <tr>
                        <td><?php echo $k;?></td>
                        <td>
                            <?php
                            echo "Nom : " .$groupe->name."<br>";
                            echo "Date de création : ".moment($groupe->creation_date)->format('d-m-Y');
                            ?>
                        </td>
                        <td><?php  echo ($groupe->status == GROUPE_BLOQUE)? "<span class='status-icon bg-danger'></span> Groupe Bloqué" : "<span class='status-icon bg-success'></span> Groupe Actif"?></td>
                        <td class="text-right">
                            <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle">Actions</button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if($groupe->status == GROUPE_BLOQUE){
                                    ?>
                                    <a class="dropdown-item" href="<?php echo site_url('utilisateur/listGroup/unlocked/'.$groupe->id) ?>">
                                        Activer
                                    </a>
                                    <?php
                                }else{
                                    ?>
                                    <a class="dropdown-item" href="<?php echo site_url('utilisateur/listGroup/locked/'.$groupe->id) ?>">
                                        Bloquer
                                    </a>
                                    <?php
                                }?>

                                <a class="dropdown-item" href="<?php echo site_url('utilisateur/listSousGroupe/'.$groupe->id) ?>">
                                    Voir les sous groupes
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
</div>
<script>
require(['dataTables.net-bs4-responsive', 'select2', 'ckeditor-jquery'], function(){
$(document).ready(function() {
$('table').DataTable();

});
});
</script>