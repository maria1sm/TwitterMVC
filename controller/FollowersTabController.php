<?php 
require_once("../model/UserImp.php");

session_start();
if(!isset($_SESSION["usuario"])){
    header("Location: LoginFormController.php");
}
$profileUser=selectUserById($pdo,$_GET["id"]);
$userLogged= $_SESSION['usuario'];
//$query = follow($pdo, $userToFollowId);

include_once("../view/followersTab.php");
$pdo=null;
?>