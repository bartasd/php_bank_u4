<?php
use Bank\App\App;
use Bank\App\Services\Accounts;
use Bank\App\Services\Message;

if($balance > 0){
    Message::set("You cannot delete account which has funds inside it." , 'error');
    return App::redirect('acc');
    die;
}

?>

        <div class="workArea" id="wa">
            <div class="editCont deleteCont">
                <div>
                    <p class="edit_title">Are you sure to delete an account: #<?= $id ?></p>
                    <p class="edit_title">Account holder:  <?= $name." ".$surname ?></p>
                    <p class="edit_title">Balance:  <?= $balance ?></p>
                </div>
                <div class="buttons">
                        <form class="delete_form" action="<?=URL."acc/delete/$id/$db"?>" method="post">
                            <input type="hidden" name="id" value="<?= $id ?>" style="display: none;">
                            <button type="submit" class="submitBtn btn btn-secondary btn-lg">YES</button>
                        </form>
                    <button type="button" class="submitBtn btn btn-secondary btn-lg"><a href="http://bank.meh:8080/acc/">NO</a></button>
                </div>        
            </div>
        </div>
    </body>
</html>