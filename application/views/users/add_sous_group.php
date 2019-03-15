<div class="row row-cards">
    <div class="card col-sm-10 offset-1">
        <div class="card-header">
            <h3 class="card-title">Enregistrer un sous groupe</h3>
        </div>
        <div class="col-sm-12 offset-2">
            <form  method="post">
                <div class="form-group row">

                    <b>Choisir le groupe </b>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="col-sm-12  ">
                                    <div class="input-group">
                                        <select class="form-control" name="groupe">
                                           <?php
                                           foreach($groupes as $groupe){
                                               ?>
                                               <option value="<?php echo $groupe->id?>"><?php echo $groupe->name?></option>
                                               <?php
                                           }
                                           ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    <b>Entrez le sous-groupe </b>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-12  ">
                                    <div class="input-group">
                                        <input type="text" id="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-success" id="addSGroup">Ajouter</button>
                            </div>
                        </div>
                </div>
                <b>Sous groupes Ajoutés</b>
                <div class=" row">
                    <br>
                    <div class="col-sm-8 ">
                        <table class="table table-bordered  table-striped table-hover table-sm" width="100%"  cellspacing="0">
                            <thead>
                            <tr>
                                <th style="width: 70%" class="bold">Sous-groupe</th>
                                <th class="bold">Option</th>
                            </tr>
                            </thead>
                            <tbody id="displaySGroup">


                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" name="save">Enregistrer</button>
                    </div>
                </div>
                <input type="hidden"  id="nombreChamp" name="nombreChamp">
            </form>
        </div>
    </div>
</div>
<script>
    require([ 'jquery'], function() {
        var nombre = 0;
        $("#addSGroup").click(function() {
            var sgroupe = $("#text").val();
            if(sgroupe != ''){
                nombre++;
                var html = '<tr id="ligne' + nombre + '">' +
                    '<td>' + sgroupe + '</td>' +
                    '<input type="hidden"  name="sgroupe_' + nombre + '"  value="' + sgroupe + '">' +
                    '<td><i class="fa fa-close close" data-id="' + nombre + '"></i></td>' +
                    '</tr>';
                $("#displaySGroup").append(html);
                $("#nombreChamp").val(nombre);
                $("#text").val('');
                $(".close").click(function () {
                    var id = $(this).attr('data-id');
                    $("#ligne" + id).remove();
                });
            }


        });
    });


</script>