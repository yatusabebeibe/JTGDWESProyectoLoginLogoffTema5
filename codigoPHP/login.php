<?php

/** @author Jesús Temprano Gallego
 *  @since 20/11/2025
 */

// Iniciamos la sesión
session_start();

// Comprobamos si se ha pulsado el botón 'cancelar'
if (isset($_REQUEST["cancelar"])) {

    // Redirigimos a la página principal
    header("Location: ../");
    exit;
}

// Comprobamos si no existe la cookie de idioma
if (empty($_COOKIE["idioma"])) {

    // Iniciamos la cookie 'idioma' con valor 'ES' y duración de 1 hora (3600 segundos)
    setcookie("idioma", "ES", time() + 60*60);

    // Recargamos la página para que la cookie esté disponible
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

// Comprobamos si ya hay un usuario en sesión
if (!empty($_SESSION["usuarioDAWJTGProyectoLoginLogoffTema5"])) {

    // Si ya hay sesión iniciada, redirigimos al programa principal
    header("Location: ./programa.php");
    exit;
} else {
    // Si no hay sesión, abortamos la sesión actual para evitar problemas al crearla más tarde
    session_abort();
}

$encontrado = false; // Variable que indicará si se ha encontrado el usuario
$aRespuestas = ["usuario"=>"","contraseña"=>""]; // Array para almacenar los datos del usuario
$aErrores = ["login"=>""]; // Array para almacenar el mensaje errores en el login

// Comprobamos si se ha enviado el formulario (botón 'entrar')
if (isset($_REQUEST["entrar"])) {

    // Incluimos la configuración de la base de datos (DSN, usuario, contraseña)
    require_once("../config/confDBPDO.php");

    // Guardamos los datos enviados en el formulario en el array de respuestas
    $aRespuestas["usuario"] = $_REQUEST["usuario"];
    $aRespuestas["contraseña"] = $_REQUEST["contraseña"];

    try {
        // Creamos la conexión PDO a la base de datos
        $miDB = new PDO(DSN, DBUser, DBPass);

        // Array con las columnas que queremos seleccionar de la tabla T01_Usuario
        $aColABuscar = [
            aColumnasUsuario["Codigo"],         // Código de usuario
            aColumnasUsuario["Password"],       // Contraseña
            aColumnasUsuario["Descripcion"],    // Descripción o nombre
            aColumnasUsuario["NumConexiones"],  // Número de conexiones
            aColumnasUsuario["UltimaConexion"], // Fecha de última conexión
            "NOW() as FechaHoraConexionActual"           // Fecha/hora actual
        ];

        // Convertimos el array de columnas en un string separado por comas
        $sColABuscar = implode(",",$aColABuscar);

        // Variables con el nombre de las columnas de usuario y contraseña
        $sColUsuario = aColumnasUsuario["Codigo"];
        $sColContraseña = aColumnasUsuario["Password"];

        // Creamos la consulta SQL para seleccionar al usuario con la contraseña correcta
        $query = <<<EOF
        SELECT $sColABuscar FROM T01_Usuario
        WHERE
            $sColUsuario = :usuario
            AND
            $sColContraseña = SHA2(:contrasenia, 256);
        EOF;

        // Preparamos la consulta para evitar inyección SQL
        $consulta = $miDB->prepare($query);

        // Array de parámetros para la consulta preparada
        $parametros = [
            ":usuario" => $aRespuestas["usuario"] ?? "",
            ":contrasenia" => ( $aRespuestas["usuario"].$aRespuestas["contraseña"] ) ?? "" // contraseña combinada con el usuario
        ];

        // Ejecutamos la consulta con los parámetros
        $consulta->execute($parametros);

        // Comprobamos si se ha encontrado al usuario
        if ($consulta->rowCount() >= 1) {
            $encontrado = true; // Indicamos que el usuario ha sido encontrado

            // Obtenemos los datos del usuario como objeto
            $usuario = $consulta->fetchObject();

            // Iniciamos la sesión
            session_start();

            // Guardamos los datos del usuario en la sesión
            $_SESSION["usuarioDAWJTGProyectoLoginLogoffTema5"] = [
                ltrim(aColumnasUsuario["Codigo"], "T01_") => $usuario->{aColumnasUsuario["Codigo"]},
                ltrim(aColumnasUsuario["Descripcion"], "T01_") => $usuario->{aColumnasUsuario["Descripcion"]},
                ltrim(aColumnasUsuario["NumConexiones"], "T01_") => $usuario->{aColumnasUsuario["NumConexiones"]} + 1,
                ltrim(aColumnasUsuario["UltimaConexion"], "T01_") => $usuario->{aColumnasUsuario["UltimaConexion"]},
                "FechaHoraConexionActual" => $usuario->FechaHoraConexionActual
            ];

            // Creamos la consulta SQL para actualizar el número de conexiones y la fecha de última conexión
            $actualizacion = <<<EOF
            UPDATE T01_Usuario
            SET
                T01_FechaHoraUltimaConexion = NOW(),
                T01_NumConexiones = T01_NumConexiones + 1
            WHERE T01_CodUsuario = :usuario ;
            EOF;

            // Preparamos y ejecutamos la actualización
            $consulta = $miDB->prepare($actualizacion);
            $consulta->execute([":usuario" => $aRespuestas["usuario"] ?? ""]);

            // Redirigimos al programa principal
            header("Location: ./programa.php");
            exit;
        } else { // Si no se encuentra el usuario o contraseña incorrecta
            $aErrores["login"] = "Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $error) { // Si ocurre un error con la base de datos
        unset($miDB); // Cerramos la conexión
        echo '<h3 class="error">ERROR SQL:</h3>';
        echo '<p class="error"><strong>Mensaje:</strong> '.$error->getMessage()."</p>";
        echo '<p class="error"><strong>Codigo:</strong> '.$error->getCode()."</p>";
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
        <h1>Login Logoff Tema 5</h1><h2>Login</h2>
    </header>
    <!-- 😼 -->
    <main>
        <form action=<?php echo $_SERVER["PHP_SELF"];?> method="post">
            <label class="tituloCampo">Usuario:</label>
            <!-- Ponemos los valores del array respuesta para que el usuario no tenga que escribirlo de nuevo en caso de error -->
            <input type="text" name="usuario" value="<?= $encontrado ? "" : $aRespuestas['usuario'] ?>" obligatorio>

            <label class="tituloCampo">Contraseña:</label>
            <!-- Ponemos los valores del array respuesta para que el usuario no tenga que escribirlo de nuevo en caso de error -->
            <input type="password" name="contraseña" value="<?= $encontrado ? "" : $aRespuestas['contraseña'] ?>" obligatorio>

            <span class="error"><?= $aErrores["login"] ?></span>

            <div>
                <input type="submit" value="Entrar" name="entrar">
                <input type="submit" value="Cancelar" name="cancelar">
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
