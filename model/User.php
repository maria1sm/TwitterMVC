<?php 
class User {
    protected $id;
    protected $username;
    protected $email;
    private $password;
    protected $description;
    protected $createDate;
    protected $tweets;
    protected $followingId;
    protected $followersId;

    public function __construct($id, $username, $email, $password, $description, $createDate) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->description = $description;
        $this->createDate = $createDate;
        $this->tweets = [];
        $this->followingId = [];
        $this->followersId = [];
    }
    
    //usort($tweets, 'comparator');

    //SOLO PARA ATRIBUTOS PRIVADOS O PROTECTED
    public function __get($password) {
        return $password;
    }
    public function __set($password, $nuevoValor) {
        echo 'No puedes setear la contraseña';
    }

    public function getId(){
        return $this->id;
    }
    public function getUsername(){
        return $this->username;
    }
    public function setUsername($atributo){
        return $this->username = $atributo;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($atributo){
        return $this->email = $atributo;
    }
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($atributo){
        return $this->description = $atributo;
    }
    public function getCreateDate(){
        return $this->createDate;
    }
    public function getTweets(){
        return $this->tweets;
    }
    public function setTweets($atributo){
        return $this->tweets = $atributo;
    }
    public function addTweet($element) {
        array_push($this->tweets, $element);
    }
    public function getFollowersId(){
        return $this->followersId;
    }
    public function setFollowersId($atributo){
        return $this->followersId = $atributo;
    }
    public function addFollowerId($element) {
        array_push($this->followersId, $element);
    }
    public function getFollowingId(){
        return $this->followingId;
    }
    public function setFollowingId($atributo){
        return $this->followingId = $atributo;
    }
    public function addFollowedId($element) {
        array_push($this->followingId, $element);
    }
    public function __toString(){
        return $this->id." ".$this->username.$this->email." ".$this->description;
    }
}

?>