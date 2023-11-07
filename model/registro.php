<?php 

if (isset($_POST["submit"])) {
    require_once("../connection/Connection.php");
    session_start();

    //Recoger los datos
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $username = isset($_POST["username"]) ? $_POST["username"] : false;
    $mail = isset($_POST["mail"]) ? trim($_POST["mail"]) : false;
    $pass = isset($_POST["password"]) ? $_POST["password"] : false;
    //var_dump($_POST);

    $arrayErrores = array();
    //Hacemos validadores necesarios
    if (!empty($username) && !is_numeric($username)) {
        $usernameValidado = true;
    } else {
        $usernameValidado = false;
        $arrayErrores["username"] = "El username no es valido";
    }

    

    $sql = "SELECT Count(*) FROM users WHERE username= '$username'";
    $stmt= $pdo->prepare($sql);
    //$res = $stmt->fetch();

    if ($usernameValidado && $stmt->rowCount() > 0){
        $usernameValidado = false;
        $arrayErrores["username"] = "Este username ya está en uso";
    }

    if (!empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $mailValidado = true;
    } else {
        $mailValidado = false;
        $arrayErrores["mail"] = "El mail no es valido";
    }

    $sql = "SELECT Count(*) FROM users WHERE username= '$mail";
    $stmt= $pdo->prepare($sql);

    if ($mailValidado && ($stmt->rowCount() > 0)) {
        $mailValidado = false;
        $arrayErrores["mail"] = "Este mail ya ha sido registrado";
    }

    if (!empty($pass)) {
        $passValidado = true;
    } else {
        $passValidado = false;
        $arrayErrores["password"] = "El password no es valido";
    }

    $guardarUsuario = false;
    if(count($arrayErrores) === 0) {
        $guardarUsuario = true;
        
        $passSegura = password_hash($pass, PASSWORD_BCRYPT, ["cost" => 4]);
        //password_verify($pass, $passSegura);
        
        $sql = "INSERT INTO users VALUES(?, ?, ?, ?, NULL,CURDATE());";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([0, $username, $mail, $passSegura]);

        if ($stmt) {
            $_SESSION["completado"] = "Registro completado";
        } else {
            $_SESSION["errores"]["general"] = "Fallo en el registro";
        }
    } else {
        $_SESSION["errores"] = $arrayErrores;
    }
    $pdo=null;
    header("Location: ../controller/LoginFormController.php");
}
?>