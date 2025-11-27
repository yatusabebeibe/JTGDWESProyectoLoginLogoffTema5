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

$decirSaludo="Bienvenido _";
$decirConexiones = "Esta el la _ vez que se conecta";
$decirFechaUltConex = "Usted se conectó por última vez el {día} de {mes} de {año} a las {horas:minutos}";
if (!empty($_COOKIE["idioma"])) {
    $numConexiones = $_SESSION["numConexiones"];
    $fechaUltConex = $_SESSION["ultimaConexion"] ?? null;
    $timestamp = strtotime($fechaUltConex);

    switch ($_COOKIE["idioma"]) {
        case 'ES':
            setlocale(LC_TIME, 'es_ES.UTF-8');
            $decirSaludo = "Bienvenido " . $_SESSION["descripcion"];
            $decirConexiones = "Esta es la " . $numConexiones . " vez que se conecta";
            $decirFechaUltConex = $timestamp 
                ? "Usted se conectó por última vez el " . strftime("%d de %B de %Y a las %H:%M", $timestamp)
                : "Usted no se había conectado antes";
            break;
        case 'EN':
            setlocale(LC_TIME, 'en_US.UTF-8');
            $decirSaludo = "Welcome " . $_SESSION["descripcion"];
            $decirConexiones = "This is the " . $numConexiones . "th time you have logged in.";
            $decirFechaUltConex = $timestamp 
                ? "Your last login was on " . strftime("%d %B %Y at %H:%M", $timestamp)
                : "You have not logged in before";
            break;
        case 'JP':
            setlocale(LC_TIME, 'ja_JP.UTF-8');
            $decirSaludo = "ようこそ " . $_SESSION["descripcion"];
            $decirConexiones = $numConexiones . "回目のログインです";
            $decirFechaUltConex = $timestamp 
                ? "最後の接続は " . strftime("%d日%B%Y年 %H:%M", $timestamp) . " です" // si no esta instalado el japonés en el sistema, el mes se muestra en inglés por defecto
                : "以前に接続したことはありません";
            break;
    }
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
            <h2><?= $decirSaludo ?></h2>
            <h3><?= $decirConexiones ?></h3>
            <h3><?= $decirFechaUltConex ?></h3>
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
