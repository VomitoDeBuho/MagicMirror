
<?php
if (!(isset($_POST['q']))){
    header('Location: ../index.html');
}
?>
<!DOCTYPE html>
<html lang="es" >
<head>
    <meta charset="UTF-8">
    <title>Resultat</title>
    <link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Table Style</title>
    <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
</head>

<body>
<div id="gradient" />
<div class="table-title">
    <h3>Resultats</h3>
</div>
<?php
function contingutbasedades(){
    require ('connexio.php');
    $nom="%" . $_POST['q'] . "%";
    $sentenciaSelect = "SELECT * FROM main WHERE nom LIKE :name ORDER BY temps desc";
    $sentence = $connexio->prepare($sentenciaSelect);
    $sentence->execute(array(":name" => $nom));
    while ( $fila = $sentence->fetch(PDO::FETCH_ASSOC)){
        $arraybasededades[]=$fila;
    }
    if (isset($arraybasededades)){
        return $arraybasededades;
    }
}
function mostrarllista(&$llista){
    echo "<table class='table-fill''>";
    echo "<thead>";
    echo "<tr>";
    echo "<th class='text-left'>Nom</th>";
    echo "<th class='text-left'>Temperatura</th>";
    echo "<th class='text-left'>Temps d'entrada</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody class='table-hover'>";
    if (isset($llista[0]['nom'])){
        foreach ( $llista as $key => $var ) {
            echo "<tr>";
            echo "<td class='text-left'>".$var['nom']."</td>";
            echo "<td class='text-left'>".$var['temp']."</td>";
            echo "<td class='text-left'>".$var['temps']."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
}
$basededades=contingutbasedades();
mostrarllista($basededades);
?>



</body>
<!-- partial -->
<script  src="./script.js"></script>
</body>
</html>

