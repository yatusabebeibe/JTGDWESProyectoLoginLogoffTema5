<?php
if (isset($_REQUEST["login"])) {
    $sArchivoLogin = "./codigoPHP/login.php";
    header("Location: $sArchivoLogin");
    exit;
}
if (!empty($_REQUEST["idioma"])) {
    setcookie("idioma", $_REQUEST["idioma"], time() + 60*60);
    header("Location: .");
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
    <title>Jesús Temprano Gallego - Login Logoff Tema 5 - inicio</title>
    <link rel="stylesheet" href="./webroot/css/style.css">
    <link rel="stylesheet" href="./webroot/css/forms.css">
</head>
<body>
    <!-- 😼 -->
    <header>
        <h1>Login Logoff Tema 5</h1>
        <h2>Inicio Publico</h2>
        <div style="text-align: center;">
            <form id="idiomas" method="post">
                <label for="ES"><img src="./webroot/images/flags/ES.png" alt="Español"></label>
                <input type="radio" name="idioma" id="ES" value="ES">

                <label for="EN"><img src="./webroot/images/flags/EN.png" alt="Inglés"></label>
                <input type="radio" name="idioma" id="EN" value="EN">

                <label for="JP"><img src="./webroot/images/flags/JP.png" alt="Japonés"></label>
                <input type="radio" name="idioma" id="JP" value="JP">
            </form>
            <script>
                const form = document.getElementById('idiomas');
                document.querySelectorAll('input[name="idioma"]').forEach(radio => {
                    radio.addEventListener('change', () => form.submit());
                });
            </script>
            <form id="login" action=<?= $_SERVER["PHP_SELF"];?> method="post">
                <input type="submit" value="Iniciar Sesion" name="login">
            </form>
        </div>
    </header>
    <!-- 😼 -->
    <main>
    </main>
    <!-- 😼 -->
    <footer>
        <span><a href="https://github.com/yatusabebeibe/JTGDWESProyectoLoginLogoff/" target="_blank">
            <img src="./webroot/images/github.svg">
        </a></span>
        <p><a href="../../" target="_self">Jesús Temprano Gallego</a> | 20/11/2025</p>
    </footer>
    <!-- 😼 -->
    <!-- muxixima glasia alvelto pol el marivilliosiximo achetemeele que te paxo chatgepete -->
</body>
</html>
