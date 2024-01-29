<?php
use Bank\App\App;
use Bank\App\Services\Accounts;
use Bank\App\Services\AccountInfo;
use Bank\App\Services\Message;

$accounts = Accounts::getAllAccounts('surname');
$lens = null;
if(isset($_SESSION['lens'])){
    $lens = $_SESSION['lens'];
}
$newIBAN = AccountInfo::getIBAN();

$msgOBJ = Message::get();
$msg = null;
$type = null;
if($msgOBJ){
  $msg = $msgOBJ[0];
  $type = $msgOBJ[1];
  Message::reset();
}
if(!isset($_SESSION['use_db'])){
    $_SESSION['use_db'] = "both";
}
?>

        <div class="workArea crt-acc" id="wa">
            <div class="chkDB">
                <p>Please select which DATABASE to use:</p>
                <form id="dbForm" action="<?= URL ?>Create" method="post">
                    <div class="chkDB2" data-db="<?=$_SESSION['use_db']?>" db-phone>
                        <input type="checkbox" class="check-with-label" name="db_use[]" value="File" id="fb" />
                        <label class="label-for-check" for="fb">FileBase</label>
                        <input type="checkbox" class="check-with-label" name="db_use[]" value="Maria" id="mb" />
                        <label class="label-for-check" for="mb">MariaBase</label>
                    </div>
                    <input class="submitBtn" type="submit" value="Submit">
                </form>
            </div>
            <div class="editCont deleteCont createCont">
                <div class="msgCont" data-remove-after="3" data-removable>
                    <p class="<?=$type?> msg msg-create"><?=$msg?></p>
                </div>
                <div>
                    <p class="edit_title">You're goint to create a new account.</p>
                    <p class="edit_title">Please fill out the form carefully!</p>
                </div>
                <div class="buttons">
                    <form class="delete_form" action="<?= URL ?>create" method="post">
                        <input type="hidden" name="id1" value="<?= $lens[0] ?>" style="display: none;">
                        <input type="hidden" name="id2" value="<?= $lens[1] ?? null ?>" style="display: none;">
                        <label for="uname">First Name:</label>
                        <input type="text" placeholder="Enter First Name" name="name" required>
                        <label for="psw">Last Name:</label>
                        <input type="text" placeholder="Enter Last Name" name="surname" required>
                        <label for="psw">Identification Code:</label>
                        <input type="text" placeholder="Enter Your Identification Code" name="id_code" required>
                        <label for="psw">Account Number:</label>
                        <input type="text" name="iban" value="<?= $newIBAN ?>"required readonly>
                        <input type="hidden" name="db" value="<?= $_SESSION['use_db'] ?>">
                        <button class="submitBtn" type="submit">SUBMIT</button>
                    </form>     
                </div>        
            </div>
        </div>
    </body>
</html>