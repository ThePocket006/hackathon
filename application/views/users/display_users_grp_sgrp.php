<?php
$k = 0;
foreach($users as $user){
    $k++;
    ?>
    <tr>
        <td><?php echo $k;?></td>
        <td>
            <?php
            echo "Nom : <b>$user->name</b> <br>";
            echo "Login : <b>$user->login</b> <br>";
            echo "Email : <b>$user->email</b> <br>";
            echo "Date d'enregistrement : <b>".moment($user->register_date)->format('d-m-Y');
            ?>
        </td>
        <td>
            <?php  echo $user->grpName?>
        </td>
        <td>
            <?php  echo ($user->sgrpName == NULL)? "Aucun sous groupe" : $user->sgrpName;?>
        </td>
        <td><?php echo $user->rName?></td>
        <td><?php  echo ($user->status == COMPTE_BLOQUE)? "Compte bloqué" : "Compte actif"?></td>
        <td class="text-right">
            <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle">Actions</button>
            <div class="dropdown-menu dropdown-menu-right">
                <?php if($user->status == COMPTE_BLOQUE){
                    ?>
                    <a class="dropdown-item" href="<?php echo site_url('utilisateur/listUsers/unlocked/'.$user->id) ?>">
                        Activer
                    </a>
                    <?php
                }else{
                    ?>
                    <a class="dropdown-item" href="<?php echo site_url('utilisateur/listUsers/locked/'.$user->id) ?>">
                        Bloquer
                    </a>
                    <?php
                }?>

                <a class="dropdown-item" href="javascript:void(0)">
                    Voir les logs
                </a>

            </div>
        </td>
    </tr>
    <?php
}
?>