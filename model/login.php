<?php 
    require ("UserImp.php");
    session_start();

    if (isset($_POST["mail"]) && isset($_POST["pass"])) {
        $mail = trim($_POST["mail"]);
        $pass = $_POST["pass"];
    }
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM users WHERE email = '?'";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$mail]);
        $res = $stmt->fetch();
        if ($res->execute() && $res->rowCount() === 1) {
            $usuario = $res->fetch();

            if (password_verify($pass, $usuario["password"])) {
                $_SESSION["usuario"] = selectUserById($pdo, $usuario["id"]);
                header("Location:  ../controller/IndexController.php");
            } else {
                $_SESSION["error_login"] = "Login incorrecto";
                header("Location: ../controller/LoginFormController.php");
            }
        } else {
            $_SESSION["error_login"] = "Login incorrecto";
            header("Location: ../controller/LoginFormController.php");
        }
    } else {
        //si el email no es válido significa en principio que el formato no es de mail,
        //por lo que chequea con username (se pueden introducir los dos en el mismo campo del form)

        $sql = "SELECT * FROM users WHERE username = '$mail'";
        //prepare te permite hacer fetch_assoc
        $res = $pdo->prepare($sql);
        
        //execute devuelte true o false
        if ($res->execute() && $res->rowCount() === 1) {
            $usuario = $res->fetch();

            if (password_verify($pass, $usuario["password"])) {
                $_SESSION["usuario"] = selectUserById($pdo, $usuario["id"]);
                header("Location: ../controller/IndexController.php");
            } else {
                $_SESSION["error_login"] = "Login incorrecto 1";
                header("Location: ../controller/LoginFormController.php");
            }
        } else {
            $_SESSION["error_login"] = "Login incorrecto 2";
            header("Location: ../controller/LoginFormController.php");
        }
    }
    
?>