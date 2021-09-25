<?php require_once("connections.php"); ?>

<?php 

$sql = "SELECT reiksme FROM nustatymai WHERE ID = 1 "; // 1 irasas
$result = $conn->query($sql);
$selected_value = mysqli_fetch_array($result);

// 0 reiks kad sidebar neatvaizduojamas
        // 1 reiks kad sidebar yra kaireje puseje
        // 2 reiks kad sidebar yra desineje puseje

?>

<div class="row">


    <?php if ($selected_value[0] == 1) {
        require("sidebar.php");
    } ?>
    
    <?php if($selected_value[0] == 0) { ?>
        <div class="col-lg-12">
    <?php } else {?>
        <div class="col-lg-9">
    <?php } ?>

    <?php   if(!isset($_COOKIE["prisijungti"])) { 
    header("Location: login.php");    
} else {
    $cookie_text = $_COOKIE["prisijungti"];
    $cookie_array = explode("|", $cookie_text );
    $cookie_vardas = $cookie_array[1];
    $cookie_teises_id = $cookie_array[3];
}

?>
        <div class="row">
        <?php 

            if(isset($_GET["catID"]) && !empty($_GET["catID"])) { //egzistuoja
                $catID = $_GET["catID"];
                
                $sql = "SELECT puslapiai.pavadinimas, 
                puslapiai.nuoroda, 
                puslapiai.santrauka, 
                kategorijos.pavadinimas AS kategorijos_pavadinimas,
                kategorijos.ID
                FROM puslapiai 
                LEFT JOIN kategorijos
                ON puslapiai.kategorijos_id = kategorijos.ID
                WHERE puslapiai.kategorijos_id = $catID
                ORDER BY puslapiai.ID DESC";    
            } else {
                $sql = "SELECT puslapiai.pavadinimas, 
                puslapiai.nuoroda, 
                puslapiai.santrauka, 
                kategorijos.pavadinimas AS kategorijos_pavadinimas,
                kategorijos.ID
                FROM puslapiai 
                LEFT JOIN kategorijos
                ON puslapiai.kategorijos_id = kategorijos.ID
                ORDER BY puslapiai.ID DESC";
            }

            $result = $conn->query($sql);

            while($pages = mysqli_fetch_array($result)) {
            ?>
            <div class="card col-lg-4" style="width: 18rem;">
                <img class="card-img-top" src="https://media.istockphoto.com/photos/camera-and-lens-zoom-closeup-picture-id1152344841?s=612x612" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $pages["pavadinimas"]; ?></h5>
                    <p class="card-text"><?php echo $pages["santrauka"]; ?></p>
                    <p class="catd-text"><a  href="index.php?catID=<?php echo $pages["ID"] ?>" ><?php echo $pages["kategorijos_pavadinimas"]; ?></a>  </p>
                    <a href="puslapiai.php?href=<?php echo $pages["nuoroda"]; ?>" class="btn btn-primary">Go somewhere</a>
                    <?php if ($cookie_teises_id==1) { 
                    echo "<a style='color:red;' href='puslapisedit.php?ID=".$pages["ID"]."'>Edit</a>";
                    } ?>
                </div>
            </div>

            <?php } ?>    
        </div>
    </div>
    
    <?php if ($selected_value[0] == 2) {
        require("sidebar.php");
    } ?>
</div>