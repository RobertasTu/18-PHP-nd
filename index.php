<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>18 paskaita</title>
    <?php require_once("includes.php"); ?>
    <style>
        .edit {
            color: red;
        }
        </style>
</head>
<body>
    <div class="container">
        <?php require_once("design-parts/meniu.php"); ?>
        <?php require_once("design-parts/jumbotron.php"); ?>
        
        <?php showJumbotron('Index', 'Welcome'); ?>
        <?php if(isset($_COOKIE["prisijungti"])) { ?>
        <?php require_once("design-parts/main.php"); ?>

<?php } ?>
    </div>


    <?php
    //Meniu, dinaminiai puslapiai, blogo sistema
    
    ?>
</body>
</html>