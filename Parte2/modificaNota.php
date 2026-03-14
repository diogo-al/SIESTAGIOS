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
    <link rel="stylesheet" href="modificaNota.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Modificar Nota</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-file-pen"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <a href="formador.php"><i class="fa-solid fa-right-to-bracket"></i> Back</a>
            </li>
        </div>
    </div> 
    <center>
    <h2 class = "userText">Bem Vindo Formador: <br> <span class = "NomeFormador"><?php echo $_SESSION["nome"] ?></span></h2>
    <form action="aplicaNota.php" method="post">
        <input type="hidden" name="empId" value=<?php echo $_GET["emp"] ?>>
        <input type="hidden" name="estId" value=<?php echo $_GET["est"] ?>>
        <input type="hidden" name="alnId" value=<?php echo $_GET["aln"] ?>>
        <div class = "notasContainer" >
            <?php 
            require("bdestagios.php");
            $info = new modificarAluno();
            $info->modificarAluno();
            $info->mostrarNotas($_GET["emp"],$_GET["est"],$_GET["aln"]);
            $info->fecharPesquisa();
            ?>
        </div>
        <input type="submit" value="Atribuir Notas" class = "accept">
    </form>
</body>
</html>