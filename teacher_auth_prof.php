<?php
session_start();
if(!isset($_SESSION["username"])){
header("Location: Teachers Login_prof.php");
exit(); }
?>