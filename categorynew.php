<?php 
require_once('connections.php');
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naujos kategorijos pridėjimas</title>

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


if(isset($_GET["prideti"])) {
    if(isset($_GET["pavadinimas"]) && isset($_GET["nuoroda"]) && isset($_GET["aprasymas"]) && isset($_GET['tevinis_id']) && !empty($_GET["pavadinimas"]) && !empty($_GET["nuoroda"]) && !empty($_GET["aprasymas"])) {
        $pavadinimas = $_GET["pavadinimas"];
        $nuoroda = $_GET["nuoroda"];
        $aprasymas = $_GET['aprasymas'];
        $tevinis_id = $_GET['tevinis_id'];
        $rodyti = 1;


        // $sql = "INSERT INTO `kategorijos`(`pavadinimas`, `nuoroda`, `aprasymas`, `tevinis_id`, `rodyti`) VALUES ('emm','emmm','emm','1',1)
        // ";

        $sql = "INSERT INTO `kategorijos` (`pavadinimas`, `nuoroda`, `aprasymas`, `tevinis_id`, `rodyti`)
        VALUES ('$pavadinimas', '$nuoroda', '$aprasymas', '$tevinis_id', $rodyti)
        ";

            if(mysqli_query($conn, $sql)) {
            $message =  "Kategorija sukurta sėkmingai";
            $class = "success";
            echo 'Kategorija: '.$pavadinimas.', sukurta sėkmingai'.'<br>';
            // echo $nuoroda;
            // echo 'Kategorija: '.$kategorijos_id;

        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }

         } else {
        $message = 'Užpildikyte visus laukelius';
        $class = 'danger';

    }
}
?>
      
     
   
    <h1>Kategorijos pildymo forma</h1>

      
 <form action='categorynew.php' method='get'>

    <div class='form-group'>
        <label for='pavadinimas'>Pavadinimas</label>
        <input  class='form-control' required='true' type='text' name='pavadinimas' placeholder='Įveskite pavadinimą' value = ""/>
       
</div>
<div class='form-group'>
        <label for='nuoroda'>Nuoroda</label>
        <input class='form-control' type='text' required='true' name='nuoroda'  placeholder='Įveskite nuorodą' />
</div>
<div class='form-group'>
        <label for='aprasymas'>Aprašymas</label>
        <textarea class='form-control summernote-aprasymas' name="aprasymas" type='text' required='true' placeholder='Įveskite aprašymą' >
</textarea> 
        
</div>
<div class='form-group'>
        <label for='tevinis_id'>Tėvinis_id</label>
        <select class='form-control' type='text' required='true' name='tevinis_id'  >
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
<button class='btn btn-primary' type='submit' name='prideti'>Pridėti naują kategoriją</button>
   
</form>
    <?php if(isset($message)) { ?>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
        <?php echo $message; ?>
    </div>
    <?php }
    
     ?>
   
<script>
    $(document).ready(function() {
          $(".summernote-aprasymas").summernote();
    });
</script>
    
</body>
</html>