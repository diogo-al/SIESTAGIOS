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
    <link rel="stylesheet" href="efetuarRegisto.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>A Editar</title>
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
    <div class="textBox">
    <?php
    require("bdestagios.php");

    $pesquisa = new editaEstagio();
    $pesquisa->editaEstagio();
    $pesquisa->editarEstagio($_GET["estabelecimento_empresa_id"],$_GET["estabelecimento_id"],$_GET["aluno_id"],$_GET["empresa"],$_GET["estabelecimento"],$_GET["aluno"],$_GET["formador"],$_GET["data_inicio"]);
    $pesquisa->fecharPesquisa();
    ?>
    </div>
    </center> 
    <div class="botoes">
        <input class = "butao" type="button" value="Nova Edicao" onclick = "window.location = 'edita.php'">
        <input class = "butao" type="button" value="Menu Principal" onclick = "window.location = 'administrativo.php'">
    </div>
</body>
</html>