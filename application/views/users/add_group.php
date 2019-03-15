<div class="row row-cards">
    <div class="card col-sm-10 offset-1">
        <div class="card-header">
            <h3 class="card-title">Enregistrer un établissement ou service</h3>
        </div>
        <div class="col-sm-12 offset-2">
            <form  method="post">
                <div class="form-group row">
                    <br>
                    <b>Entrez le service ou l'établissement</b>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-12  ">
                                <div class="input-group">
                                    <input type="text" id="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-success" id="addGroup">Ajouter</button>
                        </div>
                    </div>
                </div>

                <b>Groupes Ajoutés</b>
                <div class=" row">
                    <br>
                    <div class="col-sm-8 ">
                        <table class="table table-bordered  table-striped table-hover table-sm" width="100%"  cellspacing="0">
                            <thead>
                            <tr>
                                <th style="width: 70%" class="bold">Groupe</th>
                                <th class="bold">Option</th>
                            </tr>
                            </thead>
                            <tbody id="displayGroup">


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
        $("#addGroup").click(function() {
            var groupe = $("#text").val();
            if(groupe != ''){
                nombre++;
                var html = '<tr id="ligne' + nombre + '">' +
                    '<td>' + groupe + '</td>' +
                    '<input type="hidden"  name="groupe_' + nombre + '"  value="' + groupe + '">' +
                    '<td class="text-center"><i class="fa fa-remove close" data-id="' + nombre + '"></i></td>' +
                    '</tr>';
                $("#displayGroup").append(html);
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