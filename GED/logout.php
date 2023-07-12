<?php
session_start();
$_SESSION=array();
$_SESSION['message']=array("succes","Vous avez été déconnecté");
header('location:index.php');
?>