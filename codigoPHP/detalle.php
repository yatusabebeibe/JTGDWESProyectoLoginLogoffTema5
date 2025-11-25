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
if (isset($_REQUEST["volver"])) {
    header("Location: ./programa.php");
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Jesús Temprano Gallego - Login Logoff Tema 5 - detalle</title>
    <link rel="stylesheet" href="../webroot/css/style.css">
    <link rel="stylesheet" href="../webroot/css/forms.css">
    <style>
        .center {max-width: 100%;}
    </style>
</head>
<body>
    <!-- 😼 -->
    <header>
        <h1>Login Logoff Tema 5</h1>
        <h2>Detalle</h2>
        <div>
            <form id="login" action=<?php echo $_SERVER["PHP_SELF"];?> method="post">
                <input type="submit" value="Cerrar Sesion" name="cerrarSesion">
            </form>
        </div>
    </header>
    <!-- 😼 -->
    <main>
        <form action=<?php echo $_SERVER["PHP_SELF"];?> method="post">
            <div>
                <input type="submit" value="Volver" name="volver">
            </div>
        </form>
        <?php
            $variablesSuperglobales = [
                '_SESSION' => $_SESSION ?? [], // Lo crea si no esta creado
                '_COOKIE' => $_COOKIE,
                '_SERVER' => $_SERVER,
                '_REQUEST' => $_REQUEST,
                '_GET' => $_GET,
                '_POST' => $_POST,
                '_FILES' => $_FILES,
                '_ENV' => $_ENV
            ];
            foreach ($variablesSuperglobales as $nombresVariables=>$variables) {
                echo "<div class='center $nombresVariables'>";
                echo "<h2>" . $nombresVariables . "</h2>";
                echo "<table><tr>";
                foreach ($variables as $valor => $datos) {
                    echo '<tr><td class="e">'.$valor.'</td><td class="v">'.$datos.'</td></tr>';
                }
                echo "</tr></table>";
                echo "</div>";
            }
            echo "<div>".phpinfo()."</div>";
        ?>
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
     <script>
         document.body.getElementsByTagName("style")[0].remove();
         window.addEventListener("DOMContentLoaded", () => {
            document.body.getElementsByTagName("style")[0].remove();
        });
     </script>
</body>
</html>
