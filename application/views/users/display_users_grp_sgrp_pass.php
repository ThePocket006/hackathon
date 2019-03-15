
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
        <td><b><?php echo isset($pass[$user->id])? $pass[$user->id] : "Pas défini"; ?></b></td>

    </tr>
    <?php
}
?>

