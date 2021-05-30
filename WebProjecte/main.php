<!DOCTYPE html>
<html lang="es" >
<head>
    <meta charset="UTF-8">
    <title>Buscador Smart Mirror</title>
    <link href='https://fonts.googleapis.com/css?family=Raleway:200,400,800' rel='stylesheet' type='text/css'><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/css/demo.css'><link rel="stylesheet" href="./prv.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="./prv.css">

</head>
<body>
<div id="large-header" class="large-header">
<!-- partial:index.partial.html -->
<div class="container">
    <canvas id="demo-canvas"></canvas>
    <form autocomplete="off" action="./visualitzador/visualitzador.php" method="POST">
        <div class="finder">
            <div class="finder__outer">
                <div class="finder__inner">
                    <div class="finder__icon" ref="icon"></div>
                    <input class="finder__input" type="text" name="q" />
                </div>
            </div>
        </div>
    </form>
</div>
</div>
<!-- partial -->
<script src='https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/EasePack.min.js'></script>
<script src='https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/rAF.js'></script>
<script src='https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/TweenLite.min.js'></script><script  src="./prv.js"></script>
<?php
function contingutbasedadesusuaris(){
    require ('connexioUsuaris.php');
    $sentenciaSelect = "SELECT * FROM usuaris";
    $query = $connexioUsuaris->query($sentenciaSelect);
    while ( $fila = $query->fetch(PDO::FETCH_ASSOC)){
        $arraybasededades[]=$fila;
    }
    if (isset($arraybasededades)){
        return $arraybasededades;
    }
}
function comprovarusuariivalidar(){
    $usuari = $_POST['name'];
    $passwordFromPost = $_POST['pass'];
    $options = ['cost' => 11];
    $hash = password_hash($passwordFromPost, PASSWORD_BCRYPT, $options);
    $llista = contingutbasedadesusuaris();
    $comprobacions = 0;
    if (isset($llista[0]['user'])) {
        #Realitzo un for per recorre la llista i comparar l'usuari per veure si existeix
        for ($i = 0; $i <= (count($llista) - 1); $i++) {
            if ($llista[$i]['user'] == $usuari) {
                if (password_verify($passwordFromPost, $llista[$i]['hash_password'])) {
                    $comprobacions++;
                    return True;
                    }
                }
            }
    } elseif ($comprobacions == 0) {
            return False;
    }
    else {
        return False;
    }
}



if(comprovarusuariivalidar()){
}else{
    echo "Credencials Incorrectes :c";
    sleep(5);
    header('Location: ./index.html');
};
?>
</body>
</html>
