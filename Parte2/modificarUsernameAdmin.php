<?php
session_start();
if(!isset($_SESSION["user"]) || $_SESSION["tipo"] != "administrativo"){
    header("Location: login.php"); 
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="contaadministrativo.css">
    <title>Conta Admin</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-user-tie"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <a href="contaAdmin.php"><i class="fa-solid fa-right-to-bracket"></i> Back</a>
            </li>
        </div>
    </div> 
    <center>
        <h2 class="userText">Aviso Importante<br><span class="NomeAdmin"><?php echo $_SESSION["nome"] ?></span><br>
        As alterações realizadas à sua conta terão efeito <span class = "Atencao">imediato</span> <br> e <span class = "Atencao">não</span> poderão ser desfeitas.
        </h2>

        <form action="mudarConta.php" method="post">
            <input type="hidden" name="opcao" value="username">
            <p>Novo Username</p>
            <input class = "input" type="text" name = "newUsername">
            <br><br>
            <input class = "accept" type="submit" value="Alterar">
        </form>
    </div>
    </center>  
</body>
</html>