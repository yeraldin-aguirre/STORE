<?php
    session_start();
    error_reporting(E_PARSE);
    include '../library/configServer.php';
    include '../library/consulSQL.php';
    date_default_timezone_set('America/Bogota');
    function llenarRepVenta()
    {
        consultasSQL::InsertSQL("reporte", "fecha, tipo", "'" . date('d-m-Y / g:i:a') . "', 'venta'");
    }
    llenarRepVenta();
?>
