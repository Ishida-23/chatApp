<?php declare(strict_types=1); ?>
<?php require_once dirname(__FILE__) . "/../db_connection.php"; ?>
<?php require_once dirname(__FILE__)."/../Bean/UserBean.php";?>
<?php
class UserDao{
    // ログイン認証
    public static function certificate($id,$pass){
        $statement;
        $abc=[];
        try{
            $pdo = Connect();
            $sql = "SELECT * FROM user WHERE loginId= :id";
            $statement = $pdo->prepare($sql);
            $statement -> bindValue(":id",$id,PDO::PARAM_INT);
            $statement -> execute();
            $user= $statement->fetch(PDO::FETCH_ASSOC);
            if($user ==True && $pass==$user["password"]){
                $userBean=new UserBean($user["id"],$user["loginId"],$user["password"],$user["name"]);
                return $userBean;
            }
            return null;
        }catch(PDOException $ex){
            return null;
        }
    }
    //ユーザー登録
    public static function add($userId,$pass,$viewName){
        try{
            $pdo= Connect();
            $sql="INSERT INTO user";
            $sql.="(loginId,password,name)";
            $sql.="VALUES";
            $sql.="(:loginId,:password,:name)";
            $statement=$pdo->prepare($sql);
            $statement->bindValue(":loginId",$userId,PDO::PARAM_STR);
            $statement->bindValue(":password",$pass,PDO::PARAM_INT);
            $statement->bindValue(":name",$viewName,PDO::PARAM_INT);
            $statement->execute();
            return true;
        }catch(PDOException $ex){
            return false;
        }
    }
}