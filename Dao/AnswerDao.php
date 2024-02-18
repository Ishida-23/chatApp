<?php declare(strict_types=1); ?>
<?php require_once dirname(__FILE__) . "/../db_connection.php"; ?>
<?php require_once dirname(__FILE__)."/../Bean/AnswerBean.php";?>
<?php
class AnswerDao{
    //回答表示
public static function findAll($questionId){
$answers=[];
$statement;
try{
    // DBに接続
    $pdo=Connect();
    // クエリの準備
    $sql="SELECT name,answer,date,answer.id,userId,questionId FROM answer
            LEFT JOIN user  ON answer.userId = user.id
            WHERE deleteFlg != 1 AND answer.questionId = :a_name";
    // ステートメントの準備
    $statement= $pdo->prepare($sql);
    // 値のバインド
    $statement->bindValue(":a_name", $questionId ,PDO::PARAM_INT);
    // 実行
    $statement->execute();
    while($answer = $statement ->fetch(PDO::FETCH_ASSOC)){
        $answer["answer"]= htmlspecialchars($answer["answer"],ENT_QUOTES | ENT_HTML5);
        array_push($answers,new AnswerBean(
            $answer["id"],$answer["answer"],$answer["date"],$answer["name"],$answer["userId"]));
    }
}catch(PDOExcetion $ex){
    $err  =  "<p>DB接続に失敗しました。<br>";
    $err .="システム管理者へ連絡してください。</p>";
}
return $answers;
}
}?>