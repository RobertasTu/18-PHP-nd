<?php require_once("connections.php"); ?>



<div class="row">
    <div class="col-lg-3">
        <h3>Šoninė juosta/Sidebar</h3>
    </div>
    <div class="col-lg-9">
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

            $sql = "SELECT * FROM puslapiai
            ORDER BY puslapiai.ID DESC
            ";

            $result = $conn->query($sql);

            while($pages = mysqli_fetch_array($result)) {
               
            ?>
            <div class="card col-lg-4" style="width: 18rem;">
                <img class="card-img-top" src="..." alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $pages["pavadinimas"]; ?></h5>
                    <p class="card-text"><?php echo $pages["santrauka"]; ?></p>
                    <a href="puslapiai.php?href=<?php echo $pages["nuoroda"]; ?>" class="btn btn-primary">Go somewhere</a>
                    <?php if ($cookie_teises_id==1) { 
                    echo "<a style='color:red;' href='puslapisedit.php?ID=".$pages["ID"]."'>Edit</a>";
                    } ?>
                </div>
            </div>

            <?php } ?>    
        </div>
    </div>
</div>