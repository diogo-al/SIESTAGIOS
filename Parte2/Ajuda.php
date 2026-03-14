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
    <link rel="stylesheet" href="Ajuda.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Ajuda</title>
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-user-tie"></i></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <?php
                if($_SESSION["tipo"] == "aluno")
                    echo "<a href=\"aluno.php\"><i class=\"fa-solid fa-right-to-bracket\"></i> Back</a>";
                else if($_SESSION["tipo"] == "formador")
                    echo "<a href=\"formador.php\"><i class=\"fa-solid fa-right-to-bracket\"></i> Back</a>";
                else if($_SESSION["tipo"] == "administrativo")
                    echo "<a href=\"administrativo.php\"><i class=\"fa-solid fa-right-to-bracket\"></i> Back</a>";
                ?>
            </li>
        </div>
    </div> 
    <center>
    <div class = "infoContainer">
        <p>
        Na vida académica e tecnológica, cada dúvida ou obstáculo é uma oportunidade de aprender.  
        Sempre que encontrares uma incerteza, o caminho mais seguro é procurar orientação.  
        No contexto da SIESTÁGIOS, os administradores e a sede de informática estão disponíveis para esclarecer e guiar, ajudando a compreender a essência de cada situação.  
        Consultar quem entende é um ato de sabedoria, não de fraqueza. Cada questão levantada contribui para um conhecimento mais sólido e profundo.
        <br><br>
        <i><u>Os Administradores</u></i>
        </p>
    </div>
</body>
</html>