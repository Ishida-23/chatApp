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
// POST情報からログイン確認
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["login"])){
    if($_POST["userId"] !="" && $_POST["userPw"] !=""){
        $tmp=new chatApp();
        if($tmp->login($_POST["userId"],$_POST["userPw"])){
            $_SESSION["chatApp"]=$tmp; //セッションにchatAppクラスを保存
            // 遷移先
            if(isset($_GET["page"]) && isset($_GET["questionId"])){
                header("Location:" .$_GET['page']. "?questionId=" .$_GET["questionId"],true,307); //answer.php
            }elseif(isset($_GET["page"])){
                header('Location:' .$_GET['page'],true,307);//questionInput.php
            }else{
                header("Location:question.php",true,307);//通常ログイン時
            }
            exit;
        }
        $err="ユーザーIDまたはパスワードがまちがっています。";
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
    <title>ログイン画面</title>
    <link rel="stylesheet" href="css/style.css"><!-- 外部ファイル読み込み -->
</head>

<body>
    <header> <!--ヘッダー　-->
        <h1><a href="question.php">チャットアプリ</a></h1>
    </header> <!--ヘッダーここまで　-->

    <main> <!--メイン　-->
        <h2>ログイン</h2>
        
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
            <?= $err ?>
            <p>ユーザーID:<input type="text" name="userId"  maxlength="10" value=""></p>
            <p>パスワード:<input type="password" name="userPw" maxlength="10" value=""></p>
            <input type="hidden" name="page" value="<?=$page ?>">
            <input type="submit" name="login" value="ログイン">
        </form>

        <form action="userAdd.php" method="GET">
            <input type="hidden" name="page" value="<?=$page ?>"> 
            <input type="submit" name="" value="新規登録">
        </form>
        
    </main> <!--メインここまで　-->
</body>
</html>