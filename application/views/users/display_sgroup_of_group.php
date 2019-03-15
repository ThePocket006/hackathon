<option value="<?php echo 'none'?>">...</option>
<?php

foreach($sgroupes as $sgroupe){
    ?>
    <option value="<?php echo $sgroupe->id?>"><?php echo $sgroupe->nom?></option>
    <?php
}