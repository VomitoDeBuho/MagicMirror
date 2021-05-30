<?php
$user = "ublazquez";
$password = "Lexcreeper123";
$server = "mysql-5705.dinaserver.com";
$bdd = "usuaris";
try {
    $connexioUsuaris = new PDO("mysql:host=$server;dbname=$bdd",$user,$password);
}
catch (PDOException $e){
    echo $e->getMessage();
}
finally {
    $DBH = null;
}
?>
