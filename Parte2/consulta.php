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
    <link rel="stylesheet" href="consulta.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Consulta Estagios</title>
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
    <center><h2 class = "userText">Consultar Estagios Existentes<br><span class = "NomeAdmin"><?php echo $_SESSION["nome"] ?></h2>
    <div class="tabelaContainer">
        <?php
            require("bdestagios.php");

            $pesquisa = new pesquisaEstagio();
            $pesquisa->pesquisaEstagio();
            $pesquisa->consultaEstagio();
            $pesquisa->fecharPesquisa();
        ?>
    </div>
</body>
</html>