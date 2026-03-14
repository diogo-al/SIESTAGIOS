<?php
session_start();
if(!isset($_SESSION["user"]) || $_SESSION["tipo"] != "administrativo"){
    header("Location: login.php"); 
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Registar Estagio</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-user-tie"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <a href="administrativo.php"><i class="fa-solid fa-right-to-bracket"></i> Back</a>
            </li>
        </div>
    </div>
    <center>
    <h2 class = "userText">Registar Estagio Novo <br><span class = "NomeAdmin"><?php echo $_SESSION["nome"] ?></h2>
    <form action="efetuarRegisto.php" method="get">
        <div class = "formContainer">
            <?php
                require("bdestagios.php");

                $pesquisa = new pesquisaEstagio();
                $pesquisa->pesquisaEstagio();
                $pesquisa->inputEmpresa((isset($_GET['empresa']) && $_GET['empresa']!=0) ? $_GET['empresa'] : "NAN");
                $empresa = $_GET['empresa'] ?? " ";
                $pesquisa->inputEstabelecimento($empresa);
                $pesquisa->inputAluno();
                $pesquisa->inputFormador();
                $pesquisa->fecharPesquisa();
            ?>
            <input class = "data" type="date" name="data_inicio" id="data_inicio">
        </div>
        <input class = "butao" type="submit" value="Submit">
    </form> 
    <input class = "butao" type="submit" value="RESET" onclick = "window.location = 'registar.php'">
    </center>
</body>
</html>