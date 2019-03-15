<div class="row row-cards">
    <div class="card col-sm-10 offset-1">
        <div class="card-header">
            <h3 class="card-title">Enregistrer un Service externe</h3>
        </div>
        <div class="col-sm-12 offset-2">
            <form method="post">
                <div class="form-group row">
                    <label for="Uname" class="col-sm-2 col-lg-2 col-form-label">Nom du service</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" class="form-control" id="Uname" name="name" placeholder="Nom  du service" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Uname" class="col-sm-2 col-lg-2 col-form-label">Email  du service</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="email" class="form-control" id="mail" name="email" placeholder="Email  du service">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Num" class="col-sm-2 col-lg-2 col-form-label" >téléphone</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" name="tel" class="form-control" placeholder="téléphone du service">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" name="save">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    require([ 'jquery'], function() {
        var groupe = $("#groupe").val();
        $.post("<?php echo site_url('utilisateur/displaySgroupofGroup')?>",{groupe:groupe},function(data){
            $("#sgroupe").html(data);
        });
        $("#groupe").change(function() {
          var groupe = $("#groupe").val();
            $.post("<?php echo site_url('utilisateur/displaySgroupofGroup')?>",{groupe:groupe},function(data){
                $("#sgroupe").html(data);
            });


        });
    });


</script>