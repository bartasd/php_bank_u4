<?php
use Bank\App\App;
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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pigs&Piggies</title>
    <link rel="stylesheet" href="<?= URL ?>/main.css" />
    <script src="<?= URL ?>/main.js" defer></script>
  </head>
  <body>
    <div class="login">
      <div class="msgCont" data-remove-after="3" data-removable>
        <p class="<?=$type?> msg"><?=$msg?></p>
      </div>
        <div class="stabilizer">
            <img class="loginBrand" src="pigs.png" alt="PIGS&PIGGIES">
            <form class="loginForm" action="<?= URL ?>login" method="post">

                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="name" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pass" required>

                <button class="submitBtn" type="submit">Login</button>
            </form>
        </div>
    </div>
    </body>
</html>