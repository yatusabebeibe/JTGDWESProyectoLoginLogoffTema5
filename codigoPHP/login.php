<?php

/** @author Jesús Temprano Gallego
 *  @since 20/11/2025
 */

session_start();

if (isset($_REQUEST["cancelar"])) {
    header("Location: ../");
    exit;
}
if (empty($_COOKIE["idioma"])) {
    setcookie("idioma", "ES");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}
if (!empty($_SESSION["usuario"])) {
    header("Location: ./programa.php");
    exit;
}

$encontrado = false;
$aRespuestas = ["usuario"=>"","contraseña"=>""];
$aErrores = ["login"=>""];
if (isset($_REQUEST["entrar"])) {
    require_once("../config/confDBPDO.php");

    $aRespuestas["usuario"] = $_REQUEST["usuario"];
    $aRespuestas["contraseña"] = $_REQUEST["contraseña"];

    try {
        $miDB = new PDO(DSN, DBUser, DBPass);

        $aColABuscar = [
            aColumnasUsuario["Codigo"],
            aColumnasUsuario["Password"],
            aColumnasUsuario["Descripcion"],
            aColumnasUsuario["NumConexiones"],
            aColumnasUsuario["UltimaConexion"],
            "NOW() as conexionActual"
        ];
        $sColABuscar = implode(",",$aColABuscar);
        $sColUsuario = aColumnasUsuario["Codigo"];
        $sColContraseña = aColumnasUsuario["Password"];

        $query = <<<EOF
        SELECT $sColABuscar FROM T01_Usuario
        WHERE
            $sColUsuario = :usuario
            AND
            $sColContraseña = SHA2(:contrasenia, 256);
        EOF;

        $consulta = $miDB->prepare($query);

        $parametros = [
            ":usuario" => $aRespuestas["usuario"] ?? "",
            ":contrasenia" => ($aRespuestas["usuario"].$aRespuestas["contraseña"]) ?? ""
        ];

        $consulta->execute($parametros);

        if ($consulta->rowCount() >= 1) {
            $encontrado = true;
            $usuario = $consulta->fetchObject();

            session_start();

            $_SESSION["usuario"] = $usuario->{aColumnasUsuario["Codigo"]};
            $_SESSION["descripcion"] = $usuario->{aColumnasUsuario["Descripcion"]};
            $_SESSION["numConexiones"] = $usuario->{aColumnasUsuario["NumConexiones"]}+1;
            $_SESSION["ultimaConexion"] = $usuario->{aColumnasUsuario["UltimaConexion"]};
            $_SESSION["conexionActual"] = $usuario->{"conexionActual"};

            $actualizacion = <<<EOF
            UPDATE T01_Usuario
            SET
                T01_FechaHoraUltimaConexion = NOW(),
                T01_NumConexiones = T01_NumConexiones + 1
            WHERE T01_CodUsuario = :usuario ;
            EOF;

            $consulta = $miDB->prepare($actualizacion);
            $consulta->execute([":usuario" => $aRespuestas["usuario"] ?? ""]);
            
            header("Location: ./programa.php");
            exit;
        } else {
            $aErrores["login"] = "Usuario o contraseña incorrectos.";
        }

    } catch (PDOException $error) {
        unset($miDB);
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
