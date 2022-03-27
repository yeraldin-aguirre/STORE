<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';

$documento = consultasSQL::clean_string($_POST['documento-login']);
$clave = consultasSQL::clean_string(md5($_POST['clave-login']));
$radio = consultasSQL::clean_string($_POST['optionsRadios']);
if ($documento != "" && $clave != "") {
    if ($radio == "option2") {
        $verAdmin = ejecutarSQL::consultar("SELECT * FROM usuario WHERE usu_di='$documento' AND usu_pass='$clave'");
        $AdminC = mysqli_num_rows($verAdmin);
        if ($AdminC > 0) {
            $filaU = mysqli_fetch_array($verAdmin, MYSQLI_ASSOC);
            $_SESSION['documentoAdmin'] = $documento;
            $_SESSION['claveAdmin'] = $clave;
            $_SESSION['UserType'] = "Admin";
            $_SESSION['adminID'] = $filaU['usu_id'];
            echo '<script> location.href="index.php"; </script>';
        } else {
            echo 'Error documento o contraseña invalido';
        }
    }
    if ($radio == "option1") {
        $verUser = ejecutarSQL::consultar("SELECT * FROM usuario WHERE usu_di='$documento' AND usu_pass='$clave'");
        $filaU = mysqli_fetch_array($verUser, MYSQLI_ASSOC);
        $UserC = mysqli_num_rows($verUser);
        if ($UserC > 0) {
            $_SESSION['documentoUser'] = $documento;
            $_SESSION['claveUser'] = $clave;
            $_SESSION['UserType'] = "User";
            $_SESSION['UserNIT'] = $filaU['usu_di'];
            echo '<script> location.href="index.php"; </script>';
        } else {
            echo 'Error documento o contraseña invalido';
        }
    }
} else {
    echo 'Error campo vacío<br>Intente nuevamente';
}
