<?php
include '../library/configServer.php';
include '../library/consulSQL.php';

$nitCliente = consultasSQL::clean_string($_POST['clien-nit']);
$userCliente = consultasSQL::clean_string($_POST['clien-user']);
$nameCliente = consultasSQL::clean_string($_POST['clien-name']);
$apeCliente = consultasSQL::clean_string($_POST['clien-lastname']);
$passCliente = consultasSQL::clean_string(md5($_POST['clien-pass']));
$passCliente2 = consultasSQL::clean_string(md5($_POST['clien-pass2']));
$dirCliente = consultasSQL::clean_string($_POST['clien-dir']);
$phoneCliente = consultasSQL::clean_string($_POST['clien-phone']);
$emailCliente = consultasSQL::clean_string($_POST['clien-email']);

if (!$nitCliente == "" && !$nameCliente == "" && !$apeCliente == "" && !$dirCliente == "" && !$phoneCliente == "" && !$emailCliente == "" && !$userCliente == "") {
	if ($passCliente == $passCliente2) {
		$verificar = ejecutarSQL::consultar("SELECT * FROM cliente WHERE NIT='" . $nitCliente . "'");
		$verificaltotal = mysqli_num_rows($verificar);
		if ($verificaltotal <= 0) {
			if (consultasSQL::InsertSQL("cliente", "NIT, NombreUsuario, Nombre, Apellido, Direccion, Clave, Telefono, Email", "'$nitCliente','$userCliente','$nameCliente','$apeCliente','$dirCliente', '$passCliente','$phoneCliente','$emailCliente'")) {
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
			echo '<script>swal("ERROR", "La cédula que ha intentado registrar ya está registrada en el sistema, por favor ingrese otro número de cédula", "error");</script>';
		}
		mysqli_free_result($verificar);
	} else {
		echo '<script>swal("ERROR", "Las contraseñas no coinciden, por favor verifique e intente nuevamente", "error");</script>';
	}
} else {
	echo '<script>swal("ERROR", "Los campos no pueden estar vacíos", "error");</script>';
}
