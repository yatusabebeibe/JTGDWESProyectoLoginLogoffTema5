<?php

/** @author Jesús Temprano Gallego
 *  @since 20/11/2025
 */

if (isset($_REQUEST["entrar"])) {
    header("Location: ./programa.php");
    exit;
}
if (isset($_REQUEST["cancelar"])) {
    header("Location: ../");
    exit;
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Jesús Temprano Gallego - Login Logoff Tema 5 - login</title>
    <link rel="stylesheet" href="../webroot/css/style.css">
    <link rel="stylesheet" href="../webroot/css/forms.css">
</head>
<body>
    <!-- 😼 -->
    <header>
        <h1>Login Logoff Tema 5</h1><h2>Login</h2>
    </header>
    <!-- 😼 -->
    <main>
        <form action=<?php echo $_SERVER["PHP_SELF"];?> method="post">
            <input type="submit" value="Entrar" name="entrar">
            <input type="submit" value="Cancelar" name="cancelar">
            </form>
    </main>
    <!-- 😼 -->
    <footer>
        <span><a href="https://github.com/yatusabebeibe/JTGDWESProyectoLoginLogoff/" target="_blank">
            <img src="../webroot/images/github.svg">
        </a></span>
        <p><a href="/" target="_self">Jesús Temprano Gallego</a> | 20/11/2025</p>
    </footer>
    <!-- 😼 -->
    <!-- muxixima glasia alvelto pol el marivilliosiximo achetemeele que te paxo chatgepete -->
</body>
</html>
