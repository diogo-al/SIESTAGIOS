<?php
session_start();
if(!isset($_SESSION["user"]) || $_SESSION["tipo"] != "formador"){
    header("Location: login.php"); 
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formador.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Formador</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-file-pen"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <div class = "perfil">
                <a class = "contaFormador" href="contaFormador.php"><i class="fa-solid fa-circle-user"></i></a>

                <div class = "menu">
                    <a class = "opcoes" href="contaFormador.php">Conta</a>
                    <a class = "opcoes" href="Ajuda.php">Ajuda</a>
                    <a class = "opcoes" href="logout.php">Logout</a>
                </div>
                </div>
            </li>
        </div>
    </div> 
    <center>
    <h2 class = "userText">Bem Vindo Formador: <br> <span class = "NomeFormador"><?php echo $_SESSION["nome"] ?></span></h2>
    <p class = "ideaPrincipal">Estagios Finalizados:<br>Selecione o Aluno <br> para alterar a sua Nota</p>
    <?php
    require("bdestagios.php");

    $alunos = new modificarAluno();
    $alunos->modificarAluno();
    $alunos->mostraAlunos($_SESSION["user"]);
    $alunos->fecharPesquisa();
    ?>
</body>
</html>