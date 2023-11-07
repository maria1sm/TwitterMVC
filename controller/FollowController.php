<?php 
require_once("../model/UserImp.php");

session_start();
if(!isset($_SESSION["usuario"])){
    header("Location: LoginFormController.php");
}
$userToFollowId=$_GET["id"];
$userLogged= $_SESSION['usuario'];
$query = follow($pdo, $userToFollowId);
$pdo=null;

if($query){
    Header("Location: ../controller/ProfileController.php?id=$userToFollowId");
}

?>