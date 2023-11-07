<?php 
require("../model/UserImp.php");
require("../model/TweetImp.php");

session_start();
if(!isset($_SESSION["usuario"])){
    header("Location: ../controller/LoginFormController.php");
}
$user = $_SESSION['usuario'];
$threadLine = $user->getTweets();
foreach($user->getFollowingId() as $followed){
    foreach(selectUserById($pdo, $followed)->getTweets() as $tweets){
        array_push($threadLine, $tweets);
    }
}

orderTweets($threadLine);

$pdo = null;
include_once("../view/index.php");

?>