<?php declare(strict_types=1); ?>
<?php require_once dirname(__FILE__)."/Bean/UserBean.php";?>
<?php require_once dirname(__FILE__)."/Dao/UserDao.php";?>
<?php require_once dirname(__FILE__)."/Dao/QuestionDao.php";?>

<?php
class chatApp{
    private   $userBean;

    //UserBean取り出し
    public function getUserBean(){
        return $this->userBean;
    }
    //ログイン認証
    public function login($userId,$pw){
        $this->userBean=UserDao::certificate($userId,$pw);
        if(!$this->userBean==null){
            return true;
        }
        return false;
    }
    //ログアウト機能
    public function logout(){
        $_SESSION=array();
        session_destroy();
    }
    //新規投稿
    public function input($userId,$question){
        QuestionDao::questionInput($userId,$question);
    }
    //新規登録
    public static function userAdd($viewName,$userId,$pass){
        $viewName = trim($_POST["viewName"]);//前後の空白除去
        $userId = preg_replace("/\s|　/", "", $_POST["userId"]); //すべての空白除去
        $pass = preg_replace("/\s|　/", "", $_POST["pass"]); //すべての空白除去
        $viewName = htmlspecialchars($viewName,ENT_QUOTES | ENT_HTML5);
        $userId = htmlspecialchars($userId,ENT_QUOTES | ENT_HTML5);
        $pass = htmlspecialchars($pass,ENT_QUOTES | ENT_HTML5);
        
        if(strlen($userId) >= 6&& strlen($pass) >= 6){
           if(UserDao::add($userId,$pass,$viewName)){
            // 登録成功
            return 1;
           }else{
            // 失敗
            return 0;
           }
        }elseif(strlen($userId) <6){
            return 2;
        }else{
            return 3;
        }
    }
}