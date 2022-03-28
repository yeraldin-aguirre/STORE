<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';

$nitClie = consultasSQL::clean_string($_POST['nit-clie']);
$cons = ejecutarSQL::consultar("SELECT * FROM venta WHERE NIT='$nitClie'");
if (mysqli_num_rows($cons) <= 0) {
	if (consultasSQL::DeleteSQL('cliente', "NIT='" . $nitClie
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