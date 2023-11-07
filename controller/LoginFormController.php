<?php

session_start();
if(isset($_SESSION["usuario"])){
    header("Location: IndexController.php");
}
$pdo = null;
require_once("../view/LoginForm.php");

?>