<?php declare(strict_types=1); ?>
<?php require_once dirname(__FILE__)."/Dao/QuestionDao.php";?>
<?php require_once dirname(__FILE__)."/chatApp.php";?>
<?php
session_start();// セッションの開始
$err="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["logout"])){
        $_SESSION["chatApp"]->logout();
    }elseif(isset($_POST["delete"])){
        QuestionDao::deleteQuestion($_POST["questionId"]);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>チャットアプリ</title>
    <link rel="stylesheet" href="css/style.css"><!-- 外部ファイル読み込み -->
</head> 
<body>
    <header> <!--ヘッダー　-->
        <h1><a href= "question.php">チャットアプリ</a></h1>
        <nav>
            <form action= "questionInput.php" method= "GET">
                <input type= "hidden" name= "page" value= "questionInput.php">
                <input type= "submit"  value= "質問を投稿する">
            </form>
            <?php require_once dirname(__FILE__) . "/header.php"; ?><!-- 外部ファイル読み込み -->
        </nav>
    </header> <!--ヘッダーここまで　-->
    <main> <!--メイン　-->
        <?php
        $questions=QuestionDao::findAll();
        if($questions!=null){
        define('MAX',3); // 1ページの投稿の表示数
        $total = count($questions); // トータル件数
        $max_page = ceil($total / MAX); 
        if(!isset($_GET['page_id'])){ 
            $now = 1; 
        }else{
            $now = $_GET['page_id'];
        }
        $start_no = ($now - 1) * MAX; 
       
        $questions_paging = array_slice($questions, $start_no, MAX, true);

        foreach($questions_paging as $question){
        ?>  
            <div class= "question">
                <p>
                    <?= $question->getName() ?><br>
                    <?= $question->getQuestion() ?><br>
                    <?= $question->getDate() ?><br>
                </p>
                <div class= "button">
                    <form action= "detail.php" method= "GET">
                        <input type= "hidden" name= "questionId" value= "<?= $question->getId()?> ">
                        <input type= "submit" name="" value= "詳細">
                    </form>
                    
                    <!-- 本人のみ削除 -->
        <?php       if(isset($_SESSION["chatApp"])){
                        if($_SESSION["chatApp"]->getUserBean()->getId() == $question->getUserId()){ ?>
                            <form action= "<?= $_SERVER['PHP_SELF'] ?>" method= 'POST'>
                                <input type= "hidden" name= "questionId" value= "<?= $question->getId()?> ">
                                <input type= "submit" name= "delete" value= "削除">
                            </form>
        <?php   
                        }   
                    }   
                echo "</div>";
            echo "</div>";
            }
            for($i = 1; $i <= $max_page; $i++){ 
                if ($i == $now) {   
                    echo $now; 
                } else {
                    ?>
                    <a href="question.php?page_id=<?= $i ?>"><?= $i ?></a>
                <?php
                }
            }
        }else{
            echo "投稿されていません。";
        }
        ?>
        <p><?= $err ?></p>

    </main> <!--メインここまで　-->
</body>
</html>