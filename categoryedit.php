<?php 
require_once('connections.php');
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorijos redagavimas</title>

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

<?php 

// $teises_id=0;

if(isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $sql = "SELECT * FROM `kategorijos` WHERE ID = $id"; 

    $result = $conn->query($sql);

    if($result->num_rows == 1) {

        $category = mysqli_fetch_array($result);
        $hideForm = false;
    
    } else {
        $hideForm = true;
      
    }

}

if(isset($_GET["submit"])) {
    if(isset($_GET["pavadinimas"]) && isset($_GET["nuoroda"]) && isset($_GET["aprasymas"]) && isset($_GET["kategorijos_id"]) && !empty($_GET["pavadinimas"]) && !empty($_GET["nuoroda"]) && !empty($_GET["kategorijos_id"])) {
        $id = $_GET["ID"];
        $pavadinimas = $_GET["pavadinimas"];
        $nuoroda = $_GET["nuoroda"];
        $aprasymas = $_GET['aprasymas'];
        $tevinis_id = $_GET['kategorijos_id'];
//        $rodyti = $_GET["rodyti"];


        $sql = "UPDATE `kategorijos` 
        SET `pavadinimas` = '$pavadinimas', `nuoroda`='$nuoroda', `aprasymas`='$aprasymas', `tevinis_id`='$tevinis_id'
        WHERE ID = $id";

        // $sql = 'UPDATE kategorijos SET pavadinimas="$pavadinimas",nuoroda="$nuoroda",aprasymas="$aprasymas",tevinis_id="$tevinis_id",rodyti=1 WHERE ID=$id';
    

            if(mysqli_query($conn, $sql)) {
            $message =  "Kategorija redaguota sėkmingai";
            $class = "success";
            echo 'Kategorija: '.$pavadinimas.', redaguota sėkmingai'.'<br>';
            // echo $nuoroda;
            echo 'Kategorija: '.$tevinis_id;

        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    } else {
        $id = $category["ID"];
        $pavadinimas = $category["pavadinimas"];
        $nuoroda = $category["nuoroda"];
        $aprasymas = $category["aprasymas"];
        $tevinis_id = $category["tevinis_id"];
        

        $sql = "UPDATE `kategorijos`
        SET `pavadinimas` = '$pavadinimas', `nuoroda`='$nuoroda', `aprasymas`='$aprasymas', `tevinis_id`='$tevinis_id'
        WHERE ID = $id";

        // $sql = 'UPDATE kategorijos SET pavadinimas="$pavadinimas",nuoroda="$nuoroda",aprasymas="$aprasymas",tevinis_id="$tevinis_id",rodyti=1 WHERE ID=$id';
    
        if(mysqli_query($conn, $sql)) {
            $message =  "Kategorija redaguota sėkmingai";
            $class = "success";
            // echo $pavadinimas;
            // echo $nuoroda;
            // echo $tevinis_id;
        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    }
}


?>


  <?php //require_once("menu/includes.php"); ?> 
    <h1>Kategorijos redagavimas</h1>

    <?php if(true) { ?>

   
 <form action='categoryedit.php' method='get'>

    <input class="hide" type="text" name="ID" value ="<?php echo $category['ID']; ?>" />

 <div class='form-group'>
        <label for='pavadinimas'>Pavadinimas</label>
        <input  class='form-control' required='true' type='text' name='pavadinimas' value="<?php echo $category['pavadinimas']; ?>" />
</div>
<div class='form-group'>
        <label for='nuoroda'>Nuoroda</label>
        <input class='form-control' type='text' required='true' name='nuoroda'  value="<?php echo $category['nuoroda']; ?>" />
</div>

<div class='form-group'>
        <label for='aprasymas'>Aprasymas</label>
        <textarea class='form-control summernote-aprasymas' type='text' required='true' name='aprasymas'  >
        <?php echo $category['aprasymas']; ?>
    </textarea>
</div>
<div class='form-group'>
        <label for='kategorijos_id'>Tevinis_id</label>
       
                    <select class="form-control" name="kategorijos_id">
                        <?php 
                         $sql = "SELECT * FROM kategorijos";
                         $result = $conn->query($sql);
                     
                         while($category = mysqli_fetch_array($result)) {

                            if($category['tevinis_id']== $category["ID"] ) {
                                echo "<option value='".$category["ID"]."' selected='true'>";
                            }  else {
                                echo "<option value='".$category["ID"]."'>";
                            }  
                                
                                echo $category["pavadinimas"];
                            echo "</option>";
                        }
                        ?>
                    </select>
    </div>

<a href='admin.php'>Atgal</a><br>
<button class='btn btn-primary' type='submit' name='submit'>Issaugoti naujus duomenis</button>
   
</form>
    <?php if(isset($message)) { ?>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
        <?php echo $message; ?>
    </div>
    <?php } ?>

<?php } else { ?>
    <h2>Tokios kategorijos nera</h2>
    <a href='admin.php'>Atgal</a>

    <?php } ?>

</div>

<script>
    $(document).ready(function() {
        $(".summernote-aprasymas").summernote();
       
    });
</script>
    
</body>
</html>