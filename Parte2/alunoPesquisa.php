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
    <link rel="stylesheet" href="alunoPesquisa.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Bem vido</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-graduation-cap"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <a href="logout.php"><i class="fa-solid fa-circle-info"></i> Logout</a>
            </li>
        </div>
    </div>    
    <center>
        <h2 class = "userText">Bem Vindo estudante: <br> <span class = "NomeAluno"><?php echo $_SESSION["nome"] ?></span></h2>
        <form action="pesquisa_empresa.php" method="get">
            <h2>Pesquisar Empresas</h2>
            <p>Ramo de Atividade: </p>
            <input class = "input" type="text" name="ramoAtividade">
            <br><br>
            <p>Localidade: </p>
            <input class = "input" type="text" name="localidade">
            <br><br>
            <input class = "accept" type="submit" value="Search">
        </form>
    </center>
</body>
</html>