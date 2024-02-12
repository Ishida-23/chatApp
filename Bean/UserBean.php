<?php declare(strict_types=1); ?>
<?php
class UserBean{
    //フィールド
    public   $id;
    private   $loginId;
    private   $password;
    private   $name;
    // コンストラクタ
    public function __construct($id,$loginId,$password,$name) {
        $this->id = $id;
        $this->loginId = $loginId;
        $this->password = $password;
        $this->name = $name;
    }
    public function getId(){
        return $this->id;
    }
    public function getLoginId(){
        return $this->loginId;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getName(){
        return $this->name;
    }
}