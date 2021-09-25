<?php require_once("connections.php"); ?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <?php require_once("includes.php"); ?>
</head>
<body>
<div class="container">
        <?php require_once("design-parts/meniu.php"); ?>
        <?php require_once("design-parts/jumbotron.php"); ?>
        <?php showJumbotron("Admin", "Admin page"); ?>

        <?php
        if(!isset($_COOKIE["prisijungti"])) { 
            header("Location: index.php");    
        } else {
            $cookie_text = $_COOKIE["prisijungti"];
            $cookie_array = explode("|", $cookie_text );
            $cookie_vardas = $cookie_array[1];
            $cookie_teises = $cookie_array[3];
            echo "Sveikas prisijunges: ".$cookie_vardas.'<br>';
        
            if($cookie_teises == 2) {
                header('Location: index.php');
            }
        }
            ?>
        

        <h2>Sidebar atvaizdavimas </h2>
        <form action="admin.php">
            <?php 
                $sql = "SELECT reiksme FROM nustatymai WHERE ID = 1 "; // 1 irasas
                $result = $conn->query($sql);

                $selected_value = mysqli_fetch_array($result);


                $checked = array(0,0,0);
                
                if($selected_value[0] == 0) {
                    $checked[0] = "checked";
                } else if ($selected_value[0] == 1) {
                    $checked[1] = "checked";
                } else if ($selected_value[0] == 2) {
                    $checked[2] = "checked";
                }  


            
            ?>
            <input type="radio" name="sidebar" value="0" <?php echo $checked[0]; ?>/> Sidebar neatvaizduojamas </br>
            <input type="radio" name="sidebar" value="1" <?php echo $checked[1]; ?>/> Sidebar kaireje </br>
            <input type="radio" name="sidebar" value="2" <?php echo $checked[2]; ?>/> Sidebar desineje </br>
            <input class="btn btn-primary" type="submit" name="submit" value="Išsaugoti">
        </form>
        
        <?php 
        // 0 reiks kad sidebar neatvaizduojamas
        // 1 reiks kad sidebar yra kaireje puseje
        // 2 reiks kad sidebar yra desineje puseje
        if(isset($_GET["submit"])) {
            
            $sidebar = $_GET["sidebar"];

            $sql = "UPDATE `nustatymai` SET `reiksme`='$sidebar' WHERE ID = 1";
            $result = $conn->query($sql);

            if($result) {
                echo "Nustatymas pakeistas sėkmingai";
                header("Location: admin.php");
            } else {
                echo "Kažkas įvyko negerai";
            }
        
        }

        ?>
         <a class='btn btn-primary' href='index.php'>Į pagrindinį puslapį</a>

        <h2>Kategoriju atvaizdavimas</h2>
        <form action="admin.php" method="get">
       
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Pavadinimas</th>
                    <th>Aprasymas</th>
                    <th>Rodyti</th>
                    <th>Veiksmai</th>

                </tr>
            <?php
            $sql = "SELECT * FROM kategorijos"; //kuri kategorija yra tevine/ kuri vaikine
            $result = $conn->query($sql);

            while($category = mysqli_fetch_array($result)) {
                $categoryID = $category["ID"];
                echo "<tr>";
                    echo "<td>".$category["ID"]."</td>";
                    echo "<td>".$category["pavadinimas"]."</td>";
                    echo "<td>".$category["aprasymas"]."</td>";

                    if($category["rodyti"] == 0) {
                        echo "<td>
                            <input type='checkbox' value='$categoryID' name='category[]'/> 
                        </td>";
                    } else {
                        echo "<td><input type='checkbox' value='$categoryID' name='category[]' checked='true'/> 
                        </td>";
                        
                    }
                    
                    echo "<td><a style='color:red;' href='categoryedit.php?ID=".$category["ID"]."'>Edit</a></td>";

                    
                echo "</tr>";

            }
        
        ?>
    </table>
    <input class="btn btn-primary"  type='submit' name='submit1'><br>
    
    </div>
    </form>
            <?php 
                if(isset($_GET['submit1'])) {
                        //1 atvaizduoja 0 paslepia
                        //jeigu egzistuoja masyve, vadinas checkbox pazymeta, vadinasi turi buti 1
                        //Jei masyve neegzistuoja, vadinas checkbox kategorija nepazymeta, vadinasi tb 0


                    $reiksmes = $_GET['category'];
                    // var_dump($reiksmes);


                    $sql = "UPDATE `kategorijos` SET `rodyti`= 0";
                    $result = $conn->query($sql);
        
                    foreach ($reiksmes as $reiksme) {
                        $sql = "UPDATE `kategorijos` SET `rodyti`= 1 WHERE ID=$reiksme";
                        $result = $conn->query($sql);
                    }
                        // header('Location: admin.php');

                        echo "<script type='text/javasscript'>window.top.location='admin.php';</script>";

                }
            
            ?>



</body>
</html>






<?php 

//1. Sonines juostos atvaizdavimas
// Sonine juosta kaireje puseje
// Sonine juosta desineje puseje
// Sonines juostos neatvaizduoti

//2. Kategoriju matomumas
// Kad mes galetume pasirinkti, kurias kategorijas norime matyti, kuriu ne



?>