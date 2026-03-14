<?php
session_start();
if(!isset($_SESSION["user"]) || $_SESSION["tipo"] != "aluno"){
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
    <link rel="stylesheet" href="contaaluno.css">
    <title>Conta Aluno</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-graduation-cap"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <a href="contaAluno.php"><i class="fa-solid fa-right-to-bracket"></i> Back</a>
            </li>
        </div>
    </div> 
    <center>
        <h2 class="userText">Aviso Importante<br><span class="NomeAluno"><?php echo $_SESSION["nome"] ?></span><br>
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