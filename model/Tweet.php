<?php 
require_once("User.php");
class Tweet {
    protected $id;
    protected User $user;
    protected $text;
    protected $createDate;

    public function __construct($id, $user, $text, $createDate) {
        $this->id = $id;
        $this->user = $user;
        $this->text = $text;
        $this->createDate = $createDate;
    }

    //comparator tweets order
    public static function compareByIdDescending($o1, $o2) {
        if ($o1->id === $o2->id) {
            return 0;
        }
        return ($o2->getId() - $o1->getId()) ? -1 : 1;
    }
    public function getId(){
        return $this->id;
    }
    public function getUser(){
        return $this->user;
    }
    public function getText(){
        return $this->text;
    }
    public function getCreateDate(){
        return $this->createDate;
    }
    
    public function __toString(){
        return $this->id." ".$this->user->username.$this->text." ".$this->createDate;
    }
}

?>