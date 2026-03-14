<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php"); 
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="conta<?php echo $_SESSION["tipo"]?>.css">
    <title>A Efetuar Alterações</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-graduation-cap"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <?php
                if($_SESSION["tipo"] == "aluno")
                    echo "<a href=\"contaAluno.php\"><i class=\"fa-solid fa-right-to-bracket\"></i> Back</a>";
                else if($_SESSION["tipo"] == "formador")
                    echo "<a href=\"contaFormador.php\"><i class=\"fa-solid fa-right-to-bracket\"></i> Back</a>";
                else if($_SESSION["tipo"] == "administrativo")
                    echo "<a href=\"contaAdmin.php\"><i class=\"fa-solid fa-right-to-bracket\"></i> Back</a>";
                ?>
            </li>
        </div>
    </div> 
    <center>
    <div class = "info">
    <?php
        require("bdestagios.php");
        $output;
        $alterar = new AlterarConta();
        $alterar->alterarConta();
        if($_POST["opcao"] == "username"){
            $output = $alterar->alterarUsername($_SESSION["user"],$_POST["newUsername"]);
            if($output == 0){
                $_SESSION["user"] = $_POST["newUsername"];
            }
        } 
        else if($_POST["opcao"] == "name"){
            $output = $alterar->alterarName($_SESSION["user"],$_POST["newName"]);
            if($output == 0){
                $_SESSION["nome"] = $_POST["newName"];
            }
        }
        else if($_POST["opcao"] == "pass"){
            $output = $alterar->alterarPassword($_SESSION["user"],$_POST["oldPass"], $_POST["newPass"]);
            if($output == 3){
                if($_SESSION["tipo"] == "aluno")
                    header("Location: modificarPassword.php?erro=1");
                else if($_SESSION["tipo"] == "formador")
                    header("Location: modificarPasswordFormador.php?erro=1");
                else if($_SESSION["tipo"] == "administrativo")
                    header("Location: modificarPasswordAdmin.php?erro=1");
                exit;
            }
        } 

    ?>
    </div>
</body>
</html>