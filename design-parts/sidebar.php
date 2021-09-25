<div class="col-lg-3 sidebar">
        <h3>Šoninė juosta/Sidebar</h3>
    <?php

function kategorijuMedis($tevinis_id = 0, $kategorijos_medis_masyvas = '') {

    require("connections.php"); 

    if(!is_array($kategorijos_medis_masyvas)) {
        $kategorijos_medis_masyvas = array();
    }

    $sql = "SELECT * FROM kategorijos WHERE tevinis_id = $tevinis_id AND rodyti = 1"; // grazins paciu pirmu rekursijos veikmo momentu
    
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $kategorijos_medis_masyvas[] = "<ul>";
        while($category = mysqli_fetch_array($result)) {
            $categoryID = $category["ID"];
            $sql1 = "SELECT COUNT(ID) AS viso_irasu FROM `puslapiai` WHERE kategorijos_id = $categoryID ";
            $result1 = $conn->query($sql1);
            $totalPages = mysqli_fetch_array($result1);
            // $kategorijos_medis_masyvas[] = "<li>".$category["pavadinimas"]."</li>";
            $kategorijos_medis_masyvas[] = "<li>";
            $kategorijos_medis_masyvas[] = "<a href='index.php?catID=".$categoryID."'>";
            $kategorijos_medis_masyvas[] = $category["pavadinimas"]." (".$totalPages["viso_irasu"].")" ;
            $kategorijos_medis_masyvas[] = "</a>";
            $kategorijos_medis_masyvas[] = "</li>";
            $kategorijos_medis_masyvas = kategorijuMedis($category["ID"], $kategorijos_medis_masyvas); //1
        }
        $kategorijos_medis_masyvas[] = "</ul>";
    }
    


    return $kategorijos_medis_masyvas; //kaupiasi visos kategorijos
}

$kategorijos = kategorijuMedis();

foreach($kategorijos as $kategorija) {
    echo $kategorija;
}

        // $sql = "SELECT * FROM kategorijos ORDER BY pavadinimas ASC";

        // $result = $conn->query($sql);

        // echo "<ul>";

        // while($category = mysqli_fetch_array($result)) {
        //    //kiek kategorija turi irasu?
        //    // atlikti uzklausa i puslapiai duomenu bazes lenteleje
           
        //    //kategorijos ID. $catID - jis ateina is nuorodos
           
        //    $categoryID = $category["ID"];
           
        //    $sql1 = "SELECT COUNT(ID) AS viso_irasu FROM `puslapiai` WHERE kategorijos_id = $categoryID "; //10

        //    $result1 = $conn->query($sql1);
           
        //    $totalPages = mysqli_fetch_array($result1); //masyva su skaiciumi kiek yra is viso puslapiu

        //    echo "<li>";

        //         echo "<a href='index.php?catID=".$categoryID."'>";
        //             echo $category["pavadinimas"]." (".$totalPages["viso_irasu"].")" ;
        //         echo "</a>";
        //    echo "</li>";
        // }

        // echo "</ul>"
    ?>

    </div>