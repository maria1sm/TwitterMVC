<?php 
require_once("../model/TweetImp.php");

session_start();
if(!isset($_SESSION["usuario"])){
    header("Location: ../LoginFormController.php");
}
$idTweet=$_GET["id"];
$query = deleteTweet($pdo, $idTweet);
$user=$_SESSION['usuario'];
$userID = $user->getId();
$pdo = null;
if($query){
    Header("Location: ProfileController.php?id=$userID");
} else {
    $_SESSION["errorDelete"] = "Error al borrar el tweet";
    Header("Location: ProfileController.php?id=$userID");
}

?>