<?php
include '../library/configServer.php';
include '../library/consulSQL.php';

$idUsuario = consultasSQL::clean_string($_POST['usu_di']);
// $nameCliente = consultasSQL::clean_string($_POST['clie-nomb']);
// $fullnameCliente = consultasSQL::clean_string($_POST['clien-fullname']);
// $apeCliente = consultasSQL::clean_string($_POST['clie-apel']);
$passUsuario = consultasSQL::clean_string(md5($_POST['usu-pass']));
$passUsuario2 = consultasSQL::clean_string(md5($_POST['usu-pass2']));
// $dirCliente = consultasSQL::clean_string($_POST['clien-dir']);
// $phoneCliente = consultasSQL::clean_string($_POST['clien-phone']);
// $emailUsuario = consultasSQL::clean_string($_POST['usu-email']);

if (!$idUsuario == "") {
	if ($passUsuario == $passUsuario2) {
		$verificar = ejecutarSQL::consultar("SELECT * FROM usuario WHERE usu_di='" . $idUsuario . "'");
		$verificaltotal = mysqli_num_rows($verificar);
		if ($verificaltotal <= 0) {
			if (consultasSQL::InsertSQL("usuario", "usu_di, usu-pass, usu_estado, ", "'$idUsuario','$passUsuario'")) {
				echo '<script>
						swal({
							title: "Registro completado",
							text: "El registro se completó con éxito, ya puedes iniciar sesión en el sistema",
							type: "success",
							showCancelButton: true,
							confirmButtonClass: "btn-danger",
							confirmButtonText: "Aceptar",
							cancelButtonText: "Cancelar",
							closeOnConfirm: false,
							closeOnCancel: false
						},
						function(isConfirm) {
							if (isConfirm) {
								location.reload();
							} else {
								location.reload();
							}
						});
					</script>';
			} else {
				echo '<script>swal("ERROR", "Ocurrió un error inesperado, por favor intente nuevamente", "error");</script>';
			}
		} else {
			echo '<script>swal("ERROR", "El correo que ha ingresado ya está registrado en el sistema, por favor ingrese otro número de correo", "error");</script>';
		}
		mysqli_free_result($verificar);
	} else {
		echo '<script>swal("ERROR", "Las contraseñas no coinciden, por favor verifique e intente nuevamente", "error");</script>';
	}
} else {
	echo '<script>swal("ERROR", "Los campos no pueden estar vacíos", "error");</script>';
}