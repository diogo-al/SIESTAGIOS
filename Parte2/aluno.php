<?php
session_start();
if(!isset($_SESSION["user"]) || $_SESSION["tipo"] != "aluno"){
    header("Location: login.php"); 
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="aluno.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Bem vindo</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-graduation-cap"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <div class = "perfil">
                <a class = "contaAluno" href="contaAluno.php"><i class="fa-solid fa-circle-user"></i></a>

                <div class = "menu">
                    <a class = "opcoes" href="contaAluno.php">Conta</a>
                    <a class = "opcoes" href="Ajuda.php">Ajuda</a>
                    <a class = "opcoes" href="logout.php">Logout</a>
                </div>
                </div>
            </li>
        </div>
    </div>    
    <center>
    <h2 class = "userText">Bem Vindo estudante: <br> <span class = "NomeAluno"><?php echo $_SESSION["nome"] ?></span></h2>
    <h2 class = "h2Nome">Os Meus Estagios</h2>
    <div class = "tabelaContainer">
        <?php
            require("bdestagios.php");
            $estagios = new pesquisaEstagio();
            $estagios->pesquisaEstagio();
            $estagios->consultaEstagioAluno($_SESSION["user"]);
            $estagios->fecharPesquisa();
            
        ?>
        <input class="accept" type="button" value="Pesquisar um novo Estagio" onclick="window.location.href='filtraEmpresa.php'">
    </div>
    </center>
</body>
</html>