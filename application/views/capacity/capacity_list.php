<div class="row row-cards">
    <div class="card col-sm-12">
        <div class="card-header">
            <h3 class="card-title">Liste des droits</h3>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-wrap" id="test">
                <thead>
                <tr>
                    <th class="w-1">No.</th>
                    <th>Titre</th>
                    <th>Lien</th>
                    <th>Description</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $k = 0;
                foreach($capacities as $capacity){
                    $k++;
                    ?>
                    <tr>
                        <td><?php echo $k;?></td>
                        <td>
                            <?php
                            echo $capacity->name."<br>";
                            echo "Crée le: ".moment($capacity->creation_date)->format('d-m-Y');
                            ?>
                        </td>
                        <td><?php echo $capacity->link?></td>
                        <td><?php  echo $capacity->description ?></td>
                        <td><a href="<?php echo site_url('capacity/editCapacity/'.$capacity->id) ?>" class="btn btn-success "> <i class="fa fa-edit"></i>Modifier</a> </td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
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

