<?php declare(strict_types=1); ?>
<?php
class AnswerBean{
    private $id;
    private $answer;
    private $date;
    private $name;
    private $userId;
    private $answers=[];

    public function __construct($id,$answer,$date,$name,$userId) {
        $this->id = $id;
        $this->answer = $answer;
        $this->date = $date;
        $this->name = $name;
        $this->userId = $userId;   
    }
    public function getId(){
        return $this->id;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getAnswer(){
        return $this->answer;
    }
    public function getDate(){
        return $this->date;
    }
    public function getName(){
        return $this->name;
    }
}
?>