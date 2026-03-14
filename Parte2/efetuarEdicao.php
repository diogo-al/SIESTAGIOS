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
    <title>Efetuar Edicao</title>
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
    <form action="edicaoRealizada.php" method="get">
        <input type="hidden" name="estabelecimento_empresa_id" value="<?php echo $_GET['estabelecimento_empresa_id']; ?>">
        <input type="hidden" name="estabelecimento_id" value="<?php echo $_GET['estabelecimento_id']; ?>">
        <input type="hidden" name="aluno_id" value="<?php echo $_GET['aluno_id']; ?>">
        <input type="hidden" name="formador_id" value="<?php echo $_GET['formador_id']; ?>">        
    <div class = "formContainer">
            <?php
                require("bdestagios.php");

                $pesquisa = new editaEstagio();
                $pesquisa->editaEstagio();
                $pesquisa->inputEmpresa((isset($_GET['estabelecimento_empresa_id']) && $_GET['estabelecimento_empresa_id']!=0) ? $_GET['estabelecimento_empresa_id'] : "NAN");
                $empresa = $_GET['estabelecimento_empresa_id'] ?? " ";
                $pesquisa->inputEstabelecimento($empresa, $_GET["estabelecimento_id"]);
                $pesquisa->inputAluno($_GET["aluno_id"]);
                $pesquisa->inputFormador($_GET["formador_id"]);
                $pesquisa->fecharPesquisa();
            ?>
            <input class="data" type="date" name="data_inicio" id="data_inicio" value="<?php echo $_GET['data_inicio']; ?>">
        </div>
        <input class = "butao" type="submit" value="Submit">
    </form> 
    <input class = "butao" type="submit" value="RESET" onclick = "window.location = 'registar.php'">
    </center>
</body>
</html>