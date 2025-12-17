<?php

/** @author Jesús Temprano Gallego
 *  @since 20/11/2025
 */

// Iniciamos la sesión
session_start();

// Incluimos la configuración de la base de datos para poder acceder al nombre de las colummnas
require_once("../config/confDBPDO.php");

// Comprobamos si no hay usuario en sesión
if (empty($_SESSION["usuarioDAWJTGProyectoLoginLogoffTema5"])) {

    // Redirigimos al login
    header("Location: ./login.php");
    exit;
}

// Comprobamos si se ha pulsado el botón 'detalle'
if (isset($_REQUEST["detalle"])) {

    // Redirigimos a la página de detalle
    header("Location: ./detalle.php");
    exit;
}

// Comprobamos si se ha pulsado el botón 'cerrarSesion'
if (isset($_REQUEST["cerrarSesion"])) {

    // Destruimos la sesión
    session_destroy();

    // Redirigimos a la página principal
    header("Location: ../");
    exit;
}

// Comprobamos si no existe la cookie de idioma
if (empty($_COOKIE["idioma"])) {

    // Creamos la cookie 'idioma' con valor 'ES' y duración de 1 hora
    setcookie("idioma", "ES", time() + 60*60);

    // Recargamos la página para que la cookie esté disponible
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

// Mensajes por defecto antes de personalizar según idioma
$decirSaludo="Bienvenido _";
$decirConexiones = "Esta el la _ vez que se conecta";
$decirFechaUltConex = "Usted se conectó por última vez el {día} de {mes} de {año} a las {horas:minutos}";

// Si existe la cookie de idioma, personalizamos los mensajes
if (!empty($_COOKIE["idioma"])) {

    // Número de conexiones y fecha de última conexión desde la sesión
    $numConexiones = $_SESSION["usuarioDAWJTGProyectoLoginLogoffTema5"][ltrim(aColumnasUsuario["NumConexiones"], "T01_")];
    $fechaUltConex = $_SESSION["usuarioDAWJTGProyectoLoginLogoffTema5"][ltrim(aColumnasUsuario["UltimaConexion"], "T01_")] ?? null;

    // Convertimos la fecha a timestamp para usar con strftime
    $timestamp = $fechaUltConex ? $fechaUltConex->getTimestamp() : false;

    // Elegimos el idioma según la cookie
    switch ($_COOKIE["idioma"]) {
        case 'ES':
            setlocale(LC_TIME, 'es_ES.UTF-8'); // Configuramos el locale en español
            $decirSaludo = "Bienvenido " . $_SESSION["usuarioDAWJTGProyectoLoginLogoffTema5"][ltrim(aColumnasUsuario["Descripcion"], "T01_")];
            $decirConexiones = "Esta es la " . $numConexiones . "ª vez que se conecta";
            $decirFechaUltConex = $timestamp
                ? "Usted se conectó por última vez el " . strftime("%d de %B de %Y a las %H:%M", $timestamp)
                : "Usted no se había conectado antes";
            break;
        case 'EN':
            setlocale(LC_TIME, 'en_US.UTF-8'); // Configuramos el locale en inglés
            $decirSaludo = "Welcome " . $_SESSION["usuarioDAWJTGProyectoLoginLogoffTema5"][ltrim(aColumnasUsuario["Descripcion"], "T01_")];
            $decirConexiones = "This is the " . $numConexiones . "th time you have logged in.";
            $decirFechaUltConex = $timestamp
                ? "Your last login was on " . strftime("%d %B %Y at %H:%M", $timestamp)
                : "You have not logged in before";
            break;
        case 'JP':
            setlocale(LC_TIME, 'ja_JP.UTF-8'); // Configuramos locale en japonés
            $decirSaludo = "ようこそ " . $_SESSION["usuarioDAWJTGProyectoLoginLogoffTema5"][ltrim(aColumnasUsuario["Descripcion"], "T01_")];
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
