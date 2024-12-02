<?php
//starter session, tømmer arrayen, og ødelegger session
session_start();


$_SESSION = [];


session_destroy();


header("Location: ../index.php");
exit();

?>