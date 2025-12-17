<?php

/** @author Jesús Temprano Gallego
 *  @since 20/11/2025
 */

// Iniciamos la sesión
session_start();

// Comprobamos si no hay usuario en sesión
if (empty($_SESSION["usuarioDAWJTGProyectoLoginLogoffTema5"])) {

    // Redirigimos al login
    header("Location: ./login.php");
    exit;
}

// Comprobamos si se ha pulsado el botón 'volver'
if (isset($_REQUEST["volver"])) {

    // Redirigimos al programa principal
    header("Location: ./programa.php");
    exit;
}

// Comprobamos si se ha pulsado el botón para cerrar sesion
if (isset($_REQUEST["cerrarSesion"])) {

    // Destruimos la sesión
    session_destroy();

    // Redirigimos a la página principal
    header("Location: ../");
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
            // Creamos un array con las superglobales para recorrerlas fácilmente
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

            // Recorremos cada superglobal
            foreach ($variablesSuperglobales as $nombresVariables=>$variables) {
                echo "<div class='center $nombresVariables'>";
                echo "<h2>" . $nombresVariables . "</h2>"; // Mostramos el nombre de la superglobal
                echo "<table><tr>"; // Creamos la tabla para mostrar sus valores
                foreach ($variables as $valor => $datos) {

                    // Si el valor no es string, lo convertimos a string usando print_r
                    if (is_array($datos) || is_object($datos)) {
                        // Usamos nl2br para convertir los `/n` en `<br>` y que haya saltos de linea
                        $datos = "<pre>" . print_r($datos, true) . "</pre>"; 
                    }

                    // Mostramos cada clave y su valor en la tabla
                    echo '<tr><td class="e">' . $valor . '</td><td class="v">' . $datos . '</pre></td></tr>';
                }
                echo "</tr></table>";
                echo "</div>";
            }
            // Mostramos la información completa de PHP
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
