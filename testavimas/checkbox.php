<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>heckbox</title>
</head>
<body>

    <!-- Pasirinkti tik viena is galimu, checkbox nereiketu naudoti,  
        naudoti radiobutton -->
    <!-- Pasirinkti lyti -->
    <!-- Input turi tureti varda -->

    <form action='checkbox.php' method='get'>
        <input type='radio' name='lytis' checked='true' value='Vyras'/>Vyras
        <input type='radio' name='lytis' value='Moteris'/>Moteris
        <input type='radio' name='lytis' value='nenoriu_nurodyti'/>Nenoriu nurodyti
        <input type='submit' name='submit' value='submit' />

    </form>

    <?php 
        if(isset($_GET['submit'])) {
            $lytis = $_GET['lytis'];
            echo $lytis;
        }
    ?>


    <!-- Kelis pasirinkimus -->
    <form action='checkbox.php' method='get'>
    <input type='checkbox' name='reiksme[]' value='Reiksme1' checked='true'/>Reiksme1
    <input type='checkbox' name='reiksme[]' value='Reiksme2'/>Reiksme2
    <input type='checkbox' name='reiksme[]' value='Reiksme3'/>Reiksme3
    <input type='checkbox' name='reiksme[]' value='Reiksme4'/>Reiksme4
    <input type='checkbox' name='reiksme[]' value='Reiksme5' checked='true'/>Reiksme5
    <input type='checkbox' name='reiksme[]' value='Reiksme6' />Reiksme6
    <input type='checkbox' name='reiksme[]' value='Reiksme7' />Reiksme7
    <input type='submit' name='submit1' value='submit' />
    </form>
    
    <?php 
        if(isset($_GET['submit1'])) {
            $reiksme = $_GET['reiksme']; //gauname ne teksta, o masyva
            
            foreach($reiksme as $reiksmes ) {
                echo $reiksmes;
                echo '<br>';
            }


        }
    ?>

    
</body>
</html>