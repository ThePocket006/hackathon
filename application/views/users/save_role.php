<div class="row row-cards">
    <div class="card col-sm-10 offset-1">
        <div class="card-header">
            <h3 class="card-title">Enregistrer un Profil</h3>
        </div>
        <div class="col-sm-12 offset-2">
            <form  method="post">
                <div class="form-group row">
                    <label for="Num" class="col-sm-2 col-lg-2 col-form-label">Profil</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" name="role" class="form-control" placeholder="Veuillez entrer le profil" required>
                    </div>
                </div>

                <div class="form-group row">

                    <?php foreach($categories  as $category) {
                        if (isset($caps[$category->id])) {
                            ?>

                            <h4 class="text-green"><?php echo ucfirst($category->name) ?></h4>
                            <div class="row col-10">
                            <?php foreach ($caps[$category->id] as $capacity) {
                                ?>
                                <div class="col-md-4">
                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input class="custom-control-input" name="check<?php echo $capacity->id ?>"
                                               type="checkbox">
                                        <span class="custom-control-label"><?php echo ucfirst($capacity->name) ?></span>
                                    </label>


                                </div>
                                <?php

                            }
                            echo "<br></div>";
                        }
                    }?>
                </div>
                <br>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" name="save">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>