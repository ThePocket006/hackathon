<div class="row row-cards">
    <div class="card col-sm-12">
        <div class="card-header">
            <h3 class="card-title">Liste des Profils</h3>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-wrap">
                <thead>
                <tr>
                    <th class="w-1">No.</th>
                    <th>Titre</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $k = 0;
                foreach($roles as $role){
                    $k++;
                    ?>
                    <tr>
                        <td><?php echo $k;?></td>
                        <td>   <h4 class="mb-0"><?php echo mb_strtoupper($role->nom) ?></h4><br>
                            <?php
                            if(isset($caps[$role->id]))
                            {
                                foreach($caps[$role->id] as $c){
                                    echo mb_strtoupper($c)." | ";
                                }
                            }
                            ?>
                        </td>
                        <td><a href="<?php echo site_url('utilisateur/editRole/'.$role->id) ?>" class="btn btn-success "> <i class="fa fa-edit"></i> Modifier</a> </td>
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
