<?php
    session_start();
    error_reporting(E_PARSE);
    include '../library/configServer.php';
    include '../library/consulSQL.php';
    date_default_timezone_set('America/Bogota');
    function llenarRepCliente()
    {
        consultasSQL::InsertSQL("reporte", "fecha, tipo", "'" . date('d-m-Y / g:i:a') . "', 'cliente'");
    }
    llenarRepCliente();
?>