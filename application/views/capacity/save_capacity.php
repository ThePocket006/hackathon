<div class="row row-cards">
    <div class="card col-sm-10 offset-1">
        <div class="card-header">
            <h3 class="card-title">Enregistrer un droit</h3>
        </div>
        <div class="col-sm-12 offset-2">
            <form method="post">
                <div class="form-group row">
                    <label for="Ncap" class="col-sm-2 col-lg-2 col-form-label">Ordre </label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="number" class="form-control" id="ordre" name="ordre" placeholder="Ordre de la capacité" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Ncap" class="col-sm-2 col-lg-2 col-form-label">Nom du droit</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" class="form-control" id="Ncap" name="Ncap" placeholder="Nom de la capacité" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Lcap" class="col-sm-2 col-lg-2 col-form-label">Lien du droit</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" class="form-control" id="Lcap" name="Lcap" placeholder="Lien de la capacité" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Num" class="col-sm-2 col-lg-2 col-form-label">Description</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" name="Dcap" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Num" class="col-sm-2 col-lg-2 col-form-label">Icone du droit</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" name="Icap" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Num" class="col-sm-2 col-lg-2 col-form-label">Catégorie</label>
                    <div class="col-sm-8 col-lg-8">
                        <select name="Ccap" class="form-control">
                            <?php foreach($categories as $category){
                                ?>
                                <option value="<?php echo $category->id?>"><?php echo $category->name?></option>
                                <?php
                            }?>
                        </select>
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
