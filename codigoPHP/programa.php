<?php

/** @author Jesús Temprano Gallego
 *  @since 20/11/2025
 */

session_start();

if (empty($_SESSION["usuario"])) {
    session_destroy();
    header("Location: ./login.php");
    exit;
}
if (isset($_REQUEST["detalle"])) {
    header("Location: ./detalle.php");
    exit;
}
if (isset($_REQUEST["cerrarSesion"])) {
    session_destroy();
    header("Location: ../");
    exit;
}

if (empty($_COOKIE["idioma"])) {
    setcookie("idioma", "ES", time() + 60*60);
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

$bienvenido="";
if (!empty($_COOKIE["idioma"])) {
    switch ($_COOKIE["idioma"]) {
        case 'ES':
            $bienvenido="Bienvenido";
            break;
        case 'EN':
            $bienvenido="Welcome";
            break;
        case 'JP':
            $bienvenido="ようこそ";
            break;
        default:
            $bienvenido="Bienvenido";
            break;
    }
    $bienvenido .= " ".$_SESSION["descripcion"];
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
        <h1>Login Logoff Tema 5</h1>
        <h2>Programa</h2>
        <div>
            <form id="login" action=<?php echo $_SERVER["PHP_SELF"];?> method="post">
                <input type="submit" value="Cerrar Sesion" name="cerrarSesion">
            </form>
        </div>
    </header>
    <!-- 😼 -->
    <main>
        <form action=<?php echo $_SERVER["PHP_SELF"];?> method="post">
            <h2><?= $bienvenido ?></h2>
            <div>
                <input type="submit" value="Detalle" name="detalle">
            </div>
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
