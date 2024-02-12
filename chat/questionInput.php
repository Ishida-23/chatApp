<?php declare(strict_types=1); ?>
<?php require_once dirname(__FILE__)."/chatApp.php";?><!-- 外部ファイル読み込み -->
<?php
session_start();// セッションの開始
$err="";
//ログアウト
if(isset($_POST["logout"])){
    $_SESSION["chatApp"]->logout();
    header("Location:question.php",true,307);
    exit;
}
//未ログイン時はログイン画面へ遷移
if(!isset($_SESSION["chatApp"])){
    header("Location:index.php?page=" .$_GET["page"],true,307);
    exit;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    // POST確認
    if(isset($_POST["register"])){
        if(!$_POST["text"]==""){
            $_SESSION["chatApp"]->input($_SESSION["chatApp"]->getUserBean()->getId(),$_POST["text"]);
            header("Location:question.php",true,307);
            exit;
        }else{
            $err="コメントを入力してください。";
        }
    }
}        
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>質問を投稿</title>
    <link rel="stylesheet" href="css/style.css"><!-- 外部ファイル読み込み -->
</head>

<body>
    <header> <!--ヘッダー　-->
        <h1><a href="question.php">チャットアプリ</a></h1>
        <?php require_once dirname(__FILE__) . "/header.php"; ?><!-- 外部ファイル読み込み -->
    </header> <!--ヘッダーここまで　-->


    <main> <!--メイン　-->
        <h1>質問を投稿する</h1>
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
            <input type="textarea" name="text" value="" maxlenght="256">
            <input type="submit"name="register" value="登録">
        </form>
        
        <p><?= $err ?></p>

        <form action= "index.php" method= "GET">
            <input type= "submit" value= "戻る">
        </form>

    </main> <!--メインここまで　-->
</body>
</html>