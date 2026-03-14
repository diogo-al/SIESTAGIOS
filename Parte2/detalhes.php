<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="detalhes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Informacao Estagio</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-graduation-cap"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <a href="pesquisa_empresa.php"><i class="fa-solid fa-right-to-bracket"></i> Back</a>
            </li>
        </div>
    </div>
    <center>
    <?php
    require("bdestagios.php");

    $pesquisa = new pesquisaEmpresa();
    $pesquisa->pesquisaEmpresa();
    $id = $_GET["id"] ?? "";
    $pesquisa->consultaEstagios($id);
    $pesquisa->fecharPesquisa();
    ?>
    <p class = "info" >* <i class="fa-solid fa-hourglass-start"></i> -> Contacte o Responsavel para mais informações sobre os transportes e datas</p>
</body>
</html>