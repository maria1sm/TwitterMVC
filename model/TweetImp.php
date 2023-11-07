<?php
require_once("../connection/Connection.php");
require_once("../model/Tweet.php");
require_once("../model/UserImp.php");


/*function selectTweets($pdo) {
    try {
        //Hacemos la query
        $statement = $pdo->query("SELECT CompanyName, Address, City FROM customers");

        $results = [];
        foreach ($statement->fetchAll() as $p) {
            $objectP = new Customer($p["CompanyName"], $p["Address"], $p["City"]);
            array_push($results, $objectP);
        }
        return $results;
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";
    }
}*/
function orderTweets($arrTweets){
    usort($arrTweets, array('Tweet','compareByIdDescending'));
}

function selectTweetById($pdo, $id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM tweets WHERE id = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $tweet = new Tweet($res["id"],$res["userId"],$res["text"],$res["createDate"]);
        return $tweet;
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";
    }
}
function deleteTweet($pdo,$id) {
    try{
        $user = $_SESSION['usuario'];
        $sql = "DELETE FROM publications WHERE id=?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$id]);
        foreach ($user->getTweets() as $tweet) {
            if ($tweet->getId() === $id) {
                unset($user->getTweets()[$tweet->getId()]);
            }
        }
        $_SESSION['usuario'] = selectUserById($pdo, $user->getId());
        return true;
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";
    }
}
function insertTweet($pdo, $text) {
    try{
        //hay que guardar en objeto User en la variable de sesión
        $user = $_SESSION['usuario'];
        //hacemos trim
        $text = trim($text);
            
        $sql = "INSERT INTO publications (id, userId, text, createDate) VALUES (?,?,?,curdate())";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([0, $user->getId(), $text]);
        $tweet = selectTweetById($pdo, $user->getId());
        array_unshift($user->getTweets(), $tweet);
        $_SESSION['usuario'] = selectUserById($pdo, $user->getId());
        return true;
    }catch (PDOException $e) {
        $_SESSION["errorEnvio"] = "El tweet no se pudo enviar";
    }
}
?>