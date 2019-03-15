<div class="row row-cards">
    <div class="card col-sm-9">
        <div class="card-header">
            <h3 class="card-title col-sm-9">Liste des groupes d'utilisateurs</h3>
            <a href="<?php echo site_url('utilisateur/add-group') ?>" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary pull-right"><i class="fe fe-users"></i> Enregistrer Un Groupe</a>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-wrap">
                <thead>
                <tr>
                    <th class="w-1">No.</th>
                    <th>Nom du groupe</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><span class="text-muted">1</span></td>
                    <td>Division des stages</td>
                    <td class="text-right">
                        <a href="<?php echo site_url('Utilisateur/detailGroupe') ?>" class="btn btn-primary">Détails</a>
                    </td>
                </tr>
                <tr>
                    <td><span class="text-muted">2</span></td>
                    <td>Division de la formation initiale</td>
                    <td class="text-right">
                        <a href="<?php echo site_url('Utilisateur/detailGroupe') ?>" class="btn btn-primary">Détails</a>
                    </td>
                </tr>
                <tr>
                    <td><span class="text-muted">3</span></td>
                    <td>Départements</td>
                    <td class="text-right">
                        <a href="<?php echo site_url('Utilisateur/detailGroupe') ?>" class="btn btn-primary">Détails</a>
                    </td>
                </tr>
                <tr>
                    <td><span class="text-muted">4</span></td>
                    <td>Département de Genie Informatique</td>
                    <td class="text-right">
                        <a href="<?php echo site_url('Utilisateur/detailGroupe') ?>" class="btn btn-primary">Détails</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-3 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-yellow mr-3">
                    <i class="fe fe-user"></i>
                </span>
                <div>
                    <h4 class="m-0"><a href="javascript:void(0)">132 <small>Liste des utilisateurs</small></a></h4>
                </div>
            </div>
        </div>
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-purple mr-3">
                    <i class="fe fe-users"></i>
                </span>
                <div>
                    <h4 class="m-0"><a href="javascript:void(0)">13 <small>liste des groupes</small></a></h4>
                </div>
            </div>
        </div>
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-green mr-3">
                    <i class="fe fe-folder"></i>
                </span>
                <div>
                    <h4 class="m-0"><a href="javascript:void(0)">132 <small>Courriers traités</small></a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enregistrement du groupe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('save/saveCourrier') ?>">
                    <div class="form-group row">
                        <label for="Num" class="col-sm-6 col-lg-6 col-form-label">Nom du groupe</label>
                        <div class="">
                            <input type="text" class="form-control" value="<?php echo set_value("nom") ?>" name="numero" id="Num" placeholder="Nom du groupe">
                            <?php echo form_error("nom") ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="NumRef" class="col-sm-6 col-lg-6 col-form-label">Selectionnez des personnes</label>
                        <div class="">
                            <select name="destinataire[]" class="select2 form-control" multiple>
                                <option <?php echo set_select("destinataire", "1") ?>>tout le monde</option>
                                <option <?php echo set_select("destinataire", "2") ?>>tout le monde sauf toi</option>
                                <option <?php echo set_select("destinataire", "3") ?>>tout le monde</option>
                                <option <?php echo set_select("destinataire", "4") ?>>tout le monde</option>
                            </select>
                            <?php echo form_error("destinataire") ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>