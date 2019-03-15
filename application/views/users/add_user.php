<div class="row row-cards">
    <div class="card col-sm-10 offset-1">
        <div class="card-header">
            <h3 class="card-title">Enregistrer un utilisateur</h3>
        </div>
        <div class="col-sm-12 offset-2">
            <form method="post">
                <?php if(isGeneralAdmin()){
                    ?>
                    <div class="form-group row">
                        <label for="Num" class="col-sm-2 col-lg-2 col-form-label">Groupe</label>
                        <div class="col-sm-8 col-lg-8">
                            <select name="groupe" class="form-control" id="groupe">
                                <?php foreach($groupes as $groupe){
                                    ?>
                                    <option value="<?php echo  $groupe->id ?>"><?php  echo $groupe->name ?></option>
                                    <?php
                                } ?>
                            </select>

                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <input type="hidden" name="groupe" id="groupe" value="<?php echo  session_data('groupId') ?>">
                    <?php
                } ?>
                <?php if(isGeneralAdmin() || isChefCentral() || isCabinetRectorat() || isChefService()){
                    ?>
                    <div class="form-group row">
                        <label for="Num" class="col-sm-2 col-lg-2 col-form-label">Sous groupe</label>
                        <div class="col-sm-8 col-lg-8">
                            <select name="sgroupe" class="form-control" id="sgroupe">

                            </select>

                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <input type="hidden" name="sgroupe" id="sgroupe" value="<?php echo  session_data('sgroupId') ?>">
                    <?php
                } ?>
                <?php if(!isChefDepartement()){
                ?>
                <div class="form-group row">
                    <label for="Num" class="col-sm-2 col-lg-2 col-form-label">Role </label>
                    <div class="col-sm-8 col-lg-8">
                        <select name="role" class="form-control" name="role">
                            <?php foreach($roles as $role){
                                ?>
                                <option value="<?php echo  $role->id ?>"><?php  echo $role->nom ?></option>
                                <?php
                            } ?>
                        </select>

                    </div>
                </div>
                <?php  } ?>
                <div class="form-group row">
                    <label for="Uname" class="col-sm-2 col-lg-2 col-form-label">Nom de l'utilisateur</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" class="form-control" id="Uname" name="Uname" placeholder="Nom de l'utilisateur" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Uname" class="col-sm-2 col-lg-2 col-form-label">Email de l'utilisateur</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="email" class="form-control" id="Umail" name="Umail" placeholder="Email de l'utilisateur" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Num" class="col-sm-2 col-lg-2 col-form-label" >Login de l'utilisateur</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" name="Ulogin" class="form-control" placeholder="login de l'utilisateur" required>
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