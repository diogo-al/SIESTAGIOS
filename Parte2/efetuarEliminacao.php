<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="efetuarRegisto.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Document</title>
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
    $pesquisa->apagarEstagio($_GET["estabelecimento_empresa_id"],$_GET["estabelecimento_id"],$_GET["aluno_id"]);
    $pesquisa->fecharPesquisa();
    ?>
    </div>
    </center> 
    <div class="botoes">
        <input class = "butao" type="button" value="Nova Remocao" onclick = "window.location = 'edita.php'">
        <input class = "butao" type="button" value="Menu Principal" onclick = "window.location = 'administrativo.php'">
    </div>
</body>
</html>