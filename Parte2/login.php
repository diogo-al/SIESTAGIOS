<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIESTAGIOS</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class = "infoBar">
        <h1><a href="login.php"><i class="fa-solid fa-candy-cane"></i> SIESTAGIOS</a></h1>
        <div class="links">
            <li>
                <a href="moreinfo.html"><i class="fa-solid fa-circle-info"></i> More Info</a>
            </li>
        </div>
    </div>
    <center>
        <form action="valida_login.php" method="post">
            <center>
                <h3>Login</h3>
                <p><i class="fa-solid fa-user"></i> Username</p>
                <input class="input" type="text" name="login">
                <p><i class="fa-solid fa-lock"></i> Password</p>
                <input class="input" type="password" name="password">
                <br><br>
                <input class="accept" type="submit" value="Login">
                <?php if(!empty($_GET['erro']) && $_GET['erro'] == 1): ?>
                    <p class="Error"><i class="fa-solid fa-triangle-exclamation"></i> Username ou password inválidos</p>
                <?php endif; ?>
            </center>
        </form>
    </center>
</body>
</html>