<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';

$idClie = consultasSQL::clean_string($_POST['id-clie']);
$cons = ejecutarSQL::consultar("SELECT * FROM clientes WHERE id_clie='$idClie'");
if (mysqli_num_rows($cons) <= 0) {
	if (consultasSQL::DeleteSQL('clientes', "id_clie='" . $idClie
		. "'")) {
		echo '<script>
				swal({
					title: "Cliente eliminado",
					text: "Los datos del cliente se eliminaron exitosamente",
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
	echo '<script>swal("ERROR", "Lo sentimos no podemos eliminar el cliente ya que existen productos asociados a este cliente", "error");</script>';
}
mysqli_free_result($cons);