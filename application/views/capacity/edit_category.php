<div class="row row-cards">
    <div class="card col-sm-10 offset-1">
        <div class="card-header">
            <h3 class="card-title">Modifier une catégorie</h3>
        </div>
        <div class="col-sm-12 offset-2">
            <form method="post">
                <div class="form-group row">
                    <label for="Ncap" class="col-sm-2 col-lg-2 col-form-label">Ordre </label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="number" class="form-control" id="ordre" name="ordre" placeholder="Ordre de la capacité" value="<?php echo $category->ordre?>"  required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Ncap" class="col-sm-2 col-lg-2 col-form-label">Nom de la catégorie</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" class="form-control" id="Ncap" name="Ncap" placeholder="Nom de la catégorie" value="<?php echo $category->name?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Num" class="col-sm-2 col-lg-2 col-form-label">Icone de la catégorieé</label>
                    <div class="col-sm-8 col-lg-8">
                        <input type="text" name="Icap" class="form-control" value="<?php  echo $category->icone ?>" required>
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
