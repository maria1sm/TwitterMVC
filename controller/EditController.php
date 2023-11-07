<?php 

if (isset($_POST["submit"])) {
    require_once("../model/UserImp.php");
    session_start();

    if(isset($_POST["texto-bio"])) {
        $user = $_SESSION['usuario'];
        $userId = $user->getId();
        $description = trim($_POST["texto-bio"]);

        $setBio = editDescription($pdo, $user, $description);
        if ($setBio) {
            $_SESSION["bio"] = "Perfil cambiado";
        } else {
            $_SESSION["errorBio"] = "Fallo en el cambio de perfil";
        }
    } else {
        $_SESSION["errorEnvio"] = "El perfil no se pudo editar";
    }
}
$pdo=null;
header("Location: ProfileController.php?id=$userId");
?>