<?php
use Bank\App\App;
use Bank\App\Services\Accounts;
use Bank\App\Services\Message;

$accounts = Accounts::getAllAccounts($sortBy ?? 'surname', $ascending ?? true);
$len = count($accounts);
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

        <div class="workArea acc-area" id="wa">
            <div class="chkDB">
                <p>Please select which DATABASE to use:</p>
                <form id="dbForm" action="<?= URL ?>Acc" method="post">
                    <div class="chkDB2" data-db="<?=$_SESSION['use_db']?>" db-phone>
                        <input type="checkbox" class="check-with-label" name="db_use[]" value="File" id="fb" />
                        <label class="label-for-check" for="fb">FileBase</label>
                        <input type="checkbox" class="check-with-label" name="db_use[]" value="Maria" id="mb" />
                        <label class="label-for-check" for="mb">MariaBase</label>
                    </div>
                    <input class="submitBtn" type="submit" value="Submit">
                </form>
            </div>
            <div class="msgCont" data-remove-after="3" data-removable>
                <p class="<?=$type?> msg"><?=$msg?></p>
            </div>
            <div class="cont">
                <table class="table table-hover table-no-bg">
                    <thead>
                        <tr>
                            <th scope="col">ID 
                                <a href="http://bank.meh:8080/acc/sort/id">&#9661</a> 
                                <a href="http://bank.meh:8080/acc/sort/Id">&#9651</a> 
                            </th>
                            <th scope="col">Database 
                                <a href="http://bank.meh:8080/acc/sort/database">&#9661</a> 
                                <a href="http://bank.meh:8080/acc/sort/Database">&#9651</a> 
                            </th>
                            <th scope="col">Name
                                <a href="http://bank.meh:8080/acc/sort/name">&#9661</a> 
                                <a href="http://bank.meh:8080/acc/sort/Name">&#9651</a> 
                            </th>
                            <th scope="col">Surname
                                <a href="http://bank.meh:8080/acc/sort/surname">&#9661</a> 
                                <a href="http://bank.meh:8080/acc/sort/Surname">&#9651</a>     
                            </th>
                            <th scope="col">ID Code
                                <a href="http://bank.meh:8080/acc/sort/id_code">&#9661</a> 
                                <a href="http://bank.meh:8080/acc/sort/Id_code">&#9651</a> 
                            </th>
                            <th scope="col">Iban
                                <a href="http://bank.meh:8080/acc/sort/iban">&#9661</a> 
                                <a href="http://bank.meh:8080/acc/sort/Iban">&#9651</a> 
                            </th>
                            <th scope="col">Balance
                                <a href="http://bank.meh:8080/acc/sort/balance">&#9661</a> 
                                <a href="http://bank.meh:8080/acc/sort/Balance">&#9651</a> 
                            </th>
                            <th colspan="3" scope="col">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i < $len; $i++): ?>
                        <tr class="listing">
                            <td><?= $accounts[$i] -> id      ?></td>
                            <td><?= $accounts[$i] -> database  ?></td>
                            <td><?= $accounts[$i] -> name    ?></td>
                            <td><?= $accounts[$i] -> surname ?></td>
                            <td><?= $accounts[$i] -> id_code ?></td>
                            <td><?= $accounts[$i] -> iban    ?></td>
                            <td><?= $accounts[$i] -> balance ?> EUR</td>
                            <td class="controls"><a href="http://bank.meh:8080/acc/plus/<?=$accounts[$i] -> id?>/<?=$accounts[$i] -> database?>">+</a></td>
                            <td class="controls"><a href="http://bank.meh:8080/acc/minus/<?=$accounts[$i] -> id?>/<?=$accounts[$i] -> database?>">-</a></td>
                            <td class="controls"><a href="http://bank.meh:8080/acc/delete/<?=$accounts[$i] -> id?>/<?=$accounts[$i] -> database?>">x</a></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>