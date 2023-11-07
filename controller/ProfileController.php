<?php
require_once("../model/UserImp.php");
require_once("../model/TweetImp.php");
session_start();

$profileUser = selectUserById($pdo, $_GET['id']);
$userLogged = $_SESSION['usuario'];
$follows = searchFollowing($profileUser->getId());
orderTweets($profileUser->getTweets());
setUserTweets($pdo, $profileUser);
require_once("../view/profile.php");
$pdo = null;
?>