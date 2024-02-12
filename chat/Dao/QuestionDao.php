<?php declare(strict_types=1); ?>
<?php require_once dirname(__FILE__) . "/../db_connection.php"; ?>
<?php require_once dirname(__FILE__)."/../Bean/QuestionBean.php";?>
<?php
date_default_timezone_set('Asia/Tokyo'); //日本のタイムゾーンに設定
class QuestionDao{

// 一覧検索
public function findAll(){
    $questions=[];
    $statement;
    try{
        // DBに接続
        $pdo= Connect();
        // クエリの準備
        $sql="SELECT question.id,question,date,name,userId FROM question 
        LEFT JOIN user ON question.userId=user.id 
        WHERE deleteflg!=1 ORDER BY question.id DESC;";
        // スタートメントの準備
        $statement=$pdo->prepare($sql);
        // 実行
        $statement->execute();
        while($question = $statement ->fetch(PDO::FETCH_ASSOC)){
            $question["question"]= htmlspecialchars($question["question"],ENT_QUOTES | ENT_HTML5);
            array_push($questions,new QuestionBean(
                $question["id"],$question["question"],$question["date"],$question["name"],$question["userId"]));
        }
    }catch(PDOException $ex){
        $err= "接続に失敗しました。";
        return null;
    }
    return $questions;
}
// 削除操作 
public static function deleteQuestion($id){
    try{
        $pdo= Connect();
        $sql= "UPDATE question SET deleteflg = 1 WHERE id = :questionId ";
        $delete= $pdo->prepare($sql);
        $delete->bindValue(":questionId",$id,PDO::PARAM_INT);
        $delete->execute();
        }catch(PDOException $ex){
            $err= "接続に失敗しました。";
        }
}

//投稿機能
public static function questionInput($userId,$text){
    try{
        $question = preg_replace("/\s|　/", "",$text); //すべての空白除去
        $question=htmlspecialchars($question,ENT_QUOTES | ENT_HTML5);
        $date=date("YmdHis");

        $pdo= Connect();
        $sql="INSERT INTO question";
        $sql.="(userId,question,date)";
        $sql.="VALUES";
        $sql.="(:userId,:question,:date)";

        $statement=$pdo->prepare($sql);
        $statement->bindValue(":userId",$userId,PDO::PARAM_INT);
        $statement->bindValue(":question", $question ,PDO::PARAM_STR);
        $statement->bindValue(":date", $date ,PDO::PARAM_INT);
        $statement->execute();
        return true;
    }catch(PDOException $ex){
        return false;
    }
}

}
?>