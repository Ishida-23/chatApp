<?php declare(strict_types=1); ?>
<?php require_once dirname(__FILE__)."/Dao/QuestionDao.php";?>
<?php require_once dirname(__FILE__)."/Dao/AnswerDao.php";?>
<?php require_once dirname(__FILE__)."/chatApp.php";?>
<?php
session_start();// セッションの開始
$err="";
$questionInput = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $questionInput = $_POST["questionId"];
    if(isset($_POST["logout"])){
        $_SESSION["chatApp"]->logout();
        header("Location:question.php",true,307);
        exit;
    }elseif(isset($_POST["delete"])){
        // Delete_answer();
    }
}else{
    if(isset($_GET["questionId"])){             
        $questionInput = $_GET["questionId"];
    }else{
        header("Location:question.php",true,307);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>質問詳細画面</title>
    <link rel="stylesheet" href="css/style.css"><!-- 外部ファイル読み込み -->
</head>

<body>
    <header> <!--ヘッダー　-->
        <h1><a href="question.php">チャットアプリ</a></h1>
        <?php require_once dirname(__FILE__) . "/header.php"; ?><!-- 外部ファイル読み込み -->
    </header> <!--ヘッダーここまで　-->

    <main>
        <p>質問</p>
            <div class="question">
                <form action="answer.php" method="GET">
                    <?php $question=QuestionDao::findById($questionInput); ?>
                    <?=$question->getName() ?><br>
                    <?=$question->getQuestion() ?><br>
                    <?=$question->getDate() ?><br>
                    <input type="hidden" name="questionId" value="<?=$question->getId() ?>" >
                    <input type="hidden" name="page" value="answer.php">
                    <input type="submit" name="answer" value="回答">                    
                </form>
            </div>
        <P>回答</P>
        <?php
        // 回答文をフェッチ
        $answers=AnswerDao::findAll($questionInput);
        if($answers!=null){
            define('MAX',3); // 1ページの投稿の表示数
            $total = count($answers); // トータル件数
            $max_page = ceil($total / MAX); 
            if(!isset($_GET['page_id'])){ 
                $now = 1; 
            }else{
                $now = $_GET['page_id'];
            }
            $start_no = ($now - 1) * MAX; 
        
            $answers_paging = array_slice($answers, $start_no, MAX, true);

            foreach($answers_paging as $answer){
            ?>
            <div class= "question">
                <p>
                    <?= $answer->getName() ?><br>
                    <?= $answer->getAnswer() ?><br>
                    <?= $answer->getDate() ?><br>
                </p>
                <!-- 本人のみ削除 -->
        <?php   if(isset($_SESSION["chatApp"])){
                    if($_SESSION["chatApp"]->getUserBean()->getId() == $answer->getUserId()){ ?>
                        <form action= "<?= $_SERVER['PHP_SELF'] ?>" method= 'POST'>
                            <input type= "hidden" name= "answerId" value= "<?= $answer->getId()?> ">
                            <input type= "submit" name= "delete" value= "削除">
                        </form>
        <?php   
                    }   
                }   
                echo "</div>";
            }
            for($i = 1; $i <= $max_page; $i++){ 
                if ($i == $now) {   
                    echo $now; 
                } else {
                    ?>
                    <a href="detail.php?page_id=<?= $i ?>"><?= $i ?></a>
                <?php
                }
            }
        }else{
            echo "回答はまだされていません";
        }
        ?>
        <p><?= $err ?></p>
            

        <!-- 質問一覧に戻る -->
        <form action= "question.php" method= "GET">
            <input type= "submit" value= "戻る">
        </form>
        
    </main> <!--メインここまで　-->
</body>
</html>