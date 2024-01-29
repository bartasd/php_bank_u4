<?php
use Bank\App\App;
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
    <div class="navi">
      <a class="logo" href="<?=URL?>acc">PIGS&PIGGIES BANKING LTD</a>
      <p class="welcome">You're welcome, <?= ucfirst($_SESSION['user']) ?></p>
      <div class="links">
            <a href="<?=URL?>acc">Accounts</a>
            <a href="<?=URL?>create">Add Account</a>
            <a href="<?=URL?>logout">Logout</a>
      </div>
    </div>