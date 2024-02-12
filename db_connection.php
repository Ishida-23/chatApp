<?php declare(strict_types=1); ?>
<?php
// DB接続
function Connect():PDO{
    $pdo= new PDO(
        // 接続先DB情報,文字コード
        "mysql:host=127.0.0.1:3306; dbname=ideastock;charset=utf8mb4",
        // DBログインID
        "root",
        // DBログインパスワード
        "pass");
    // PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、
    // PDOExceptionの例外を投げる。
    $pdo->SetAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // SQLインジェクション対策
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    return $pdo;
}
?>