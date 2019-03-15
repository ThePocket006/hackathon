<div class="row row-cards">
    <div class="card col-sm-12">
        <div class="card-header">
            <h3 class="card-title">Liste des catégories</h3>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-wrap" id="test">
                <thead>
                <tr>
                    <th class="w-1">No.</th>
                    <th>Titre</th>
                    <th>Icone</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $k = 0;
                foreach($categories as $category){
                    $k++;
                    ?>
                    <tr>
                        <td><?php echo $k;?></td>
                        <td>
                            <?php
                            echo $category->name."<br>";
                            ?>
                        </td>
                        <td><?php echo $category->icone?></td>
                        <td class="text-right" ><a href="<?php echo site_url('capacity/editCategory/'.$category->id) ?>"class="btn btn-success "> <i class="fa fa-edit"></i> Modifier</a> </td>
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

