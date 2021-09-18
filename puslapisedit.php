<?php 
require_once('connections.php');
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puslapio redagavimas</title>

    <?php require_once("includes.php"); ?>
    
    <style>
        h1 {
            text-align: center;
        }

        /* .container {
            position:absolute;
            top:50%;
            left:50%;
            transform: translateY(-50%) translateX(-50%);
        } */

        .hide {
            display:none;
        }
    </style>

</head>
<body>
<div class='container'>
<?php require_once('design-parts/meniu.php'); ?>
<?php 
if(!isset($_COOKIE["prisijungti"])) { 
    header("Location: login.php");    
} else {
    $cookie_text = $_COOKIE["prisijungti"];
    $cookie_array = explode("|", $cookie_text );
    $cookie_vardas = $cookie_array[1];
    echo "Sveikas prisijunges: ".$cookie_vardas;
    // echo "<form action='klientai.php' method ='get'>";
    // // echo "<button class='btn btn-primary' type='submit' name='vartotojai'>Vartotojų duomenų bazė</button>";
    // // echo "<button class='btn btn-primary' type='submit' name='imones'>Imonių duomenų bazė</button>";
    // echo "<button class='btn btn-primary' type='submit' name='logout'>Logout</button>";
    // echo "</form>";
    // // if(isset($_GET['vartotojai'])) {
    // //   header('Location: vartotojai.php');
    // // }
    // // if(isset($_GET['imones'])) {
    // //   header('Location: imones.php');
    // // }

    // if(isset($_GET["logout"])) {
    //     setcookie("prisijungti", "", time() - 3600, "/");
    //     header("Location: login.php");
    // }
}    
?>

<?php 

// $teises_id=0;

if(isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $sql = "SELECT * FROM `puslapiai` WHERE ID = $id"; 

    $result = $conn->query($sql);

    if($result->num_rows == 1) {

        $page = mysqli_fetch_array($result);
        $hideForm = false;
    
    } else {
        $hideForm = true;
      
    }

}

if(isset($_GET["submit"])) {
    if(isset($_GET["pavadinimas"]) && isset($_GET["nuoroda"]) && isset($_GET["kategorijos_id"]) && !empty($_GET["pavadinimas"]) && !empty($_GET["nuoroda"]) && !empty($_GET["kategorijos_id"])) {
        $id = $_GET["ID"];
        $pavadinimas = $_GET["pavadinimas"];
        $nuoroda = $_GET["nuoroda"];
        $turinys = $_GET['turinys'];
        $santrauka = $_GET['santrauka'];
        $kategorijos_id = $_GET["kategorijos_id"];

        $sql = "UPDATE `puslapiai` 
        SET `pavadinimas`='$pavadinimas',`nuoroda`='$nuoroda',`turinys`='$turinys', `santrauka`='$santrauka', `kategorijos_id`='$kategorijos_id' 
        WHERE ID = $id";

        if(mysqli_query($conn, $sql)) {
            $message =  "Puslapis redaguotas sėkmingai";
            $class = "success";
            echo $pavadinimas;
            echo $nuoroda;
            echo $kategorijos_id;

        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    } else {
        $id = $page["ID"];
        $pavadinimas = $page["pavadinimas"];
        $nuoroda = $page["nuoroda"];
        $turinys = $page["turinys"];
        $santrauka = $page["santrauka"];
        $kategorijos_id = $page['kategorijos_id'];

        $sql = "UPDATE `puslapiai`
        SET `pavadinimas`='$pavadinimas',`nuoroda`='$nuoroda',`turinys`=$turinys, `santrauka`='$santrauka', `kategorijos_id`='$kategorijos_id',
        WHERE ID = $id";
        if(mysqli_query($conn, $sql)) {
            $message =  "Puslapis redaguotas sėkmingai";
            $class = "success";
            echo $pavadinimas;
            echo $nuoroda;
            echo $kategorijos_id;
        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    }
}


?>


  <?php //require_once("menu/includes.php"); ?> 
    <h1>Puslapio redagavimas</h1>

    <?php if(true) { ?>

   
 <form action='puslapisedit.php' method='get'>

    <input class="hide" type="text" name="ID" value ="<?php echo $page['ID']; ?>" />

 <div class='form-group'>
        <label for='pavadinimas'>Pavadinimas</label>
        <input  class='form-control' required='true' type='text' name='pavadinimas' value="<?php echo $page['pavadinimas']; ?>" />
</div>
<div class='form-group'>
        <label for='nuoroda'>Nuoroda</label>
        <input class='form-control' type='text' required='true' name='nuoroda'  value="<?php echo $page['nuoroda']; ?>" />
</div>
<div class='form-group'>
        <label for='turinys'>Turinys</label>
        <textarea class='form-control summernote-turinys' type='text' required='true' name='turinys'>
            <?php  echo $page['turinys']; ?>

        </textarea>
</div>
<div class='form-group'>
        <label for='santrauka'>Santrauka</label>
        <textarea class='form-control summernote-santrauka' type='text' required='true' name='santrauka'  >
        <?php echo $page['santrauka']; ?>
    </textarea>
</div>
<div class='form-group'>
        <label for='kategorijos_id'>Kategorijos_id</label>
       
                    <select class="form-control" name="kategorijos_id">
                        <?php 
                         $sql = "SELECT * FROM kategorijos";
                         $result = $conn->query($sql);
                     
                         while($kategorijos = mysqli_fetch_array($result)) {

                            if($puslapiai['kategorijos_id']== $kategorijos["pavadinimas"] ) {
                                echo "<option value='".$kategorijos["pavadinimas"]."' selected='true'>";
                            }  else {
                                echo "<option value='".$kategorijos["pavadinimas"]."'>";
                            }  
                                
                                echo $kategorijos["pavadinimas"];
                            echo "</option>";
                        }
                        ?>
                    </select>
    </div>

<a href='index.php'>Atgal</a><br>
<button class='btn btn-primary' type='submit' name='submit'>Issaugoti naujus duomenis</button>
   
</form>
    <?php if(isset($message)) { ?>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
        <?php echo $message; ?>
    </div>
    <?php } ?>

<?php } else { ?>
    <h2>Tokio puslapio nera</h2>
    <a href='index.php'>Atgal</a>

    <?php } ?>

</div>

<script>
    $(document).ready(function() {
        $(".summernote-santrauka").summernote();
        $(".summernote-turinys").summernote();
    });
</script>
    
</body>
</html>