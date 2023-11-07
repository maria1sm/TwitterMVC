<?php 
require_once("../model/TweetImp.php");
if (isset($_POST["submit"])) {
    
    session_start();

    if(isset($_POST["texto"])) {
        $text = $_POST["texto"];
        $enviar = insertTweet($pdo, $text);
        if ($enviar) {
            $_SESSION["enviado"] = "Tweet publicado";
        } else {
            $_SESSION["errorEnvio"] = "Fallo en el envío del tweet";
        }
    } else {
        $_SESSION["errorEnvio"] = "El tweet no se pudo enviar";
    }
}
$pdo = null;
header("Location: IndexController.php");
?>