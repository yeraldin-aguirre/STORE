<?php
session_start();
error_reporting(E_PARSE);
if ($_SESSION['documentoAdmin'] == "") {
    header("Location: index.php");
}
