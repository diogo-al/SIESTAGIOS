<?php
session_start();
if(!isset($_SESSION["user"]) || $_SESSION["tipo"] != "aluno"){
    header("Location: login.php"); 
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pesquisa_empresa.css">
    <title>Listagem de Empresas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-graduation-cap"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <a href="filtraEmpresa.php"><i class="fa-solid fa-right-to-bracket"></i> Back</a>
            </li>
        </div>
    </div>
    <center>
        <h2 class = "userText">Bem Vindo estudante: <br> <span class = "NomeAluno"><?php echo $_SESSION["nome"] ?></span></h2>  
        <div class = "h2Nome">
            <h2>Empresas Pareceiras</h2>
            <p><i class="fa-solid fa-ban"></i> Sem Disponibilidade</p>
        </div>
        <div class="tabelaContainer">
        <?php
        require("bdestagios.php");
        
        $empresas = new pesquisaEmpresa();
        $empresas->pesquisaEmpresa();
        $ramo = $_GET["ramoAtividade"] ?? "";
        $loc = $_GET["localidade"] ?? "";
        $empresas->search($ramo, $loc);
        $empresas->fecharPesquisa()
        ?>
        </div>
    </center>
</body>
</html>