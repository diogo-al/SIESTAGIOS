<?php
require('bdestagios.php');
session_start();

$login = new Login();
$login->Login();
$output = $login->verify($_POST['login'], $_POST['password']);
$login->fecharLogin();
$_SESSION["user"] = $output["user"];
$_SESSION["tipo"] = $output["tipo"];
$_SESSION["nome"] = $output["nome"];

if($output){
    if($_SESSION["tipo"] == "aluno")
        header("Location: aluno.php");
    elseif($_SESSION["tipo"] == "administrativo")
        header("Location: administrativo.php");
    elseif($_SESSION["tipo"] == "formador")
        header("Location: formador.php");
}
else{
    header("Location: login.php?erro=1");
    exit();
}

?>