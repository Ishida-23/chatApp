<?php declare(strict_types=1); ?>
<?php require_once dirname(__FILE__)."/chatApp.php";?><!-- 外部ファイル読み込み -->
<?php
session_start();// セッションの開始
$err="";
$page="";

if(isset($_SESSION["chatApp"])){
    header("Location:question.php",true,307);
    exit;
}

// POST情報からアカウント登録
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST["viewName"] !="" && $_POST["userId"] !="" && $_POST["pass"] !="" ){      
        switch (chatApp::userAdd($_POST["viewName"],$_POST["userId"],$_POST["pass"])) {
            case 0:
                $err="登録に失敗しました。";
                break;
            case 1:
                header("Location:index.php",true,307);
                exit;
            case 2:
                $err="ユーザー名は6～10文字で登録してください。";
                break;
            case 3:
                $err="パスワードは6～10文字で登録してください。";
                break;
        }
    }else{
        $err="入力してください。";
    }
}   
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="css/style.css"><!-- 外部ファイル読み込み -->
</head>

<body>

    <header> <!--ヘッダー　-->
        <h1><a href="question.php">チャットアプリ</a></h1>
    </header> <!--ヘッダーここまで　-->

    <main> <!--メイン　-->
        <form action="userAdd.php" method="POST">
            <p>表示名:<input type= "text" name= "viewName"  maxlength= "10" value="" placeholder="最大10文字まで"></p>
            <p>ユーザーID:<input type= "text" name= "userId" maxlength= "10" value="" placeholder="6～10文字で登録してください。"></p>
            <p>パスワード:<input type= "text" name= "pass"  maxlength= "10" value="" placeholder="6～10文字で登録してください。"></p>
            <input type="submit" name= "entry" value= "登録">
            <?= $err ?>
        </form>

        <form action= "index.php" method= "GET">
            <input type= "submit" value= "戻る">
        </form>
    </main> <!--メインここまで　-->
</body>
</html>