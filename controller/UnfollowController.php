<?php 
require_once("../model/UserImp.php");

session_start();
if(!isset($_SESSION["usuario"])){
    header("Location: LoginFormController.php");
}
$userToUnFollowId=$_GET["id"];
$userLogged= $_SESSION['usuario'];

$query = unfollow($pdo, $userToUnFollowId);
$pdo = null;
if($query){
    Header("Location: ProfileController.php?id=$userToUnFollowId");
}

?>