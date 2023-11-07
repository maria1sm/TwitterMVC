<?php
require_once("../connection/Connection.php");
require_once("../model/Tweet.php");
require_once("../model/User.php");


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

function selectUserById($pdo, $id){
    try {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        if ($res) {
            $user = new User($res["id"], $res["username"], $res["email"], $res["password"],
            $res["description"], $res["createDate"]);
            setUserTweets($pdo, $user);
            setFollowing($pdo, $user);
            setFollower($pdo, $user);
            return $user;
        }
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";
    }
}
function setUserTweets($pdo, User $user) {
    try {
        $id = $user->getId();
        $sql = "SELECT * FROM publications WHERE userId = ? order By Id";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$id]);
        $user->setTweets([]);
        while($r = $stmt->fetch()) {
            $newTweet = new Tweet($r["id"],$user,$r["text"],$r["createDate"]);
            $user->addTweet($newTweet);
        }
        if ($stmt->fetch()){
            return true;
        }
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";
    }
}
function searchFollowing($userToFollowId){
    $user = $_SESSION['usuario'];
    if (count($user->getFollowingId())>0) {
        return in_array($userToFollowId,$user->getFollowingId());
    } else {
        return false;
    }
    
}
function setFollowing($pdo, User $user) {
    try {
        $id = $user->getId();
        $sql = "SELECT * FROM follows WHERE users_id = ?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$id]);
        while($r = $stmt->fetch()) {
            $newFollowed = $r["userToFollowId"];
            $user->addFollowedId($newFollowed);
        }
        if ($stmt->fetch()){
            return true;
        }
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";
    }
}
function setFollower($pdo, User $user) {
    try {
        $id = $user->getId();
        $sql = "SELECT * FROM follows WHERE userToFollowId = ?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$id]);
        while($r = $stmt->fetch()) {
            $newFollower = $r["users_id"];
            $user->addFollowerId($newFollower);
        }
        if ($stmt->fetch()){
            return true;
        }
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";
    }
}
function editDescription($pdo, User $user, $description){
    try{
        $sql = "UPDATE users SET description=? WHERE id=?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([trim($description), $user->getId()]);
        return true;
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";
    }
}
function follow($pdo, $userToFollowId){
    try{
        $user = $_SESSION['usuario'];
        $sql = "INSERT INTO follows (users_id, userToFollowId) VALUES (?,?)";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$user->getId(), $userToFollowId]);
        array_push($user->getFollowingId(), $userToFollowId);
        array_push(selectUserById($pdo, $userToFollowId)->getFollowingId(), $user->getId());
        $_SESSION['usuario'] = selectUserById($pdo, $user->getId());
        return true;
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";
    }
}
function unfollow($pdo, $userToUnFollowId){
    try{
        $user = $_SESSION['usuario'];
        $sql = "DELETE FROM follows WHERE users_id = ? AND userToFollowId = ?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$user->getId(), $userToUnFollowId]);
        foreach ($user->getFollowingId() as $id) {
            if ($id === $userToUnFollowId) {
                unset($user->getFollowingId()[$id]);
            }
        }
        $_SESSION['usuario'] = selectUserById($pdo, $user->getId());
        return true;
    }catch (PDOException $e) {
        echo "No se ha podido completar la transaccion";;
    }
}
//para saber el num de followers hacer count a $user->followers
?>