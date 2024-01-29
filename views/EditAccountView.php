<?php
use Bank\App\App;
use Bank\App\Services\Accounts;
use Bank\App\Services\Message;
$msgOBJ = Message::get();
$msg = null;
$type = null;
if($msgOBJ){
  $msg = $msgOBJ[0];
  $type = $msgOBJ[1];
  Message::reset();
}
?>

        <div class="workArea" id="wa">
            <div class="msgCont" data-remove-after="3" data-removable>
                <p class="<?=$type?> msg"><?=$msg?></p>
            </div>
            <div class="editCont">
                <div>
                    <p class="edit_title">Editing amount of an account: #<?= $id ?></p>
                    <p class="edit_title">Account holder:  <?= $name." ".$surname ?></p>
                    <p class="edit_title">Balance:  <?= $balance ?></p>
                </div>
                <form class="edit_form" action="<?=URL."acc/$action/$id/$db"?>" method="post">
                    <label for="ammount">Please, enter an ammount to <?= $action == 'plus' ? "add" : "take away"  ?>:</label>
                    <input type="text" id="ammount" name="ammount"/>
                    <button class="submitBtn btn btn-secondary btn-lg" type="submit" >SUBMIT</button>
                </form>
            </div>
        </div>
    </body>
</html>