<?php require_once("connections.php"); ?>

<?php

$url = $_GET["href"]; // kontaktai , apie-mus, paslaugos

$sql = "SELECT * FROM puslapiai 
WHERE nuoroda='$url'";

$result = $conn->query($sql);

//Kiek irasu grazins? 1
if($result->num_rows !=0) {
    $page = mysqli_fetch_array($result);

} else {
    echo "Tokio puslapio nera";
    header('Location:404.php');
}


?>



<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page["pavadinimas"]; ?></title>
    <?php require_once("includes.php"); ?>
</head>
<body>
    <div class="container">
        <?php require_once('design-parts/meniu.php'); ?>
        <?php require_once('design-parts/jumbotron.php'); ?>

        <?php showJumbotron($page["pavadinimas"], $page["santrauka"] ); ?>


        <?php echo $page["turinys"]; ?>
        <?php echo $page["kategorijos_id"]; ?>
     </div>
    
</body>
</html>