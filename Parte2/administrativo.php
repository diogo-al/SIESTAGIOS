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
    <link rel="stylesheet" href="administrativo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>ADMIN</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-user-tie"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <div class = "perfil">
                <a class = "contaAdmin" href="contaAdmin.php"><i class="fa-solid fa-circle-user"></i></a>

                <div class = "menu">
                    <a class = "opcoes" href="contaAdmin.php">Conta</a>
                    <a class = "opcoes" href="Ajuda.php">Ajuda</a>
                    <a class = "opcoes" href="logout.php">Logout</a>
                </div>
                </div>
            </li>
        </div>
    </div> 
    <center>
    <h2 class = "userText">Bem Vindo Admin: <br> <span class = "NomeAdmin"><?php echo $_SESSION["nome"] ?></span></h2>
    
    <div class = "DashBoard">
        <div class="adminChoice" onclick="window.location='consulta.php'">
            <p><i class="fa-solid fa-magnifying-glass"></i> Consultar Estagios</p>
        </div>
        <span class = "linha"></span>
        <div class="adminChoice" onclick="window.location='registar.php'">
            <p><i class="fa-solid fa-circle-plus"></i> Registar Estagio</p>
        </div>
        <span class = "linha"></span>
        <div class="adminChoice" onclick="window.location='edita.php'">
            <p><i class="fa-solid fa-pen-to-square"></i> Editar Estagio</p>
        </div>
        <span class = "linha"></span>
        <div class="adminChoice" onclick="window.location='apaga.php'">
            <p><i class="fa-solid fa-trash"></i> Apagar Estagio</p>
        </div>
        <span class = "linha"></span>
        <div class="adminChoice" onclick="window.location='adiciona.php'">
            <p><i class="fa-solid fa-user-plus"></i> Adicionar Aluno</p>
        </div>
    </div>
    </center>
</body>
</html>