<?php declare(strict_types=1); ?>
<?php
class QuestionBean{
    private $id;
    private $question;
    private $date;
    private $name;
    private $userId;
    private $questions=[];

    public function __construct($id,$question,$date,$name,$userId) {
        $this->id = $id;
        $this->question = $question;
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
    public function getQuestion(){
        return $this->question;
    }
    public function getDate(){
        return $this->date;
    }
    public function getName(){
        return $this->name;
    }
}
?>