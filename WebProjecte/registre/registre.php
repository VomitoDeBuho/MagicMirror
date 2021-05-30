<?php

function afegirusuaris($password2, $usuari){
    echo "</br>"."$password2";
    require('connexio.php');
    $statement = $connexio->prepare("INSERT INTO usuaris(user,hash_password) VALUES (?, ?)");
    $statement -> execute(array($usuari, $password2));
}

function contingutbasedades(){
    require ('connexio.php');
    $sentenciaSelect = "SELECT * FROM usuaris";
    $query = $connexio->query($sentenciaSelect);
    while ( $fila = $query->fetch(PDO::FETCH_ASSOC)){
        $arraybasededades[]=$fila;
    }
    if (isset($arraybasededades)){
        return $arraybasededades;
    }
}

function comprovarusuariiafegir()
{
    $usuari = $_POST['name'];
    $passwordFromPost = $_POST['pass'];

    $llista = contingutbasedades();
    if (isset($llista[0]['user'])) {
        $comprobacions = 0;#Faig una variable per veure si hi hauran models per notificar si existeix
        #Realitzo un for per recorre la llista i comparar l'usuari per veure si existeix
        for ($i = 0; $i <= (count($llista) - 1); $i++) {
            if (($llista[$i]['user'] == $usuari)) {
                $comprobacions++;

            }
        }
        if ($comprobacions == 0) {
            $options = ['cost' => 11];
            $hash = password_hash($passwordFromPost, PASSWORD_BCRYPT, $options);
            afegirusuaris($hash, $usuari);
            header('Location: ../index.html');
            exit;
        } else {
            echo "Ja ha estat afegit un Usuari amb aquest nom :c";
        }
    } else {
        $options = ['cost' => 11];
        $hash = password_hash($passwordFromPost, PASSWORD_BCRYPT, $options);
        afegirusuaris($hash, $usuari);
        header('Location: ../projecte/index.html');
        exit;
    }
}
comprovarusuariiafegir();
?>