<?php declare(strict_types=1); ?>
<?php

function Delete_answer(){
    try{
        $pdo= Connect();
        $sql= "UPDATE answer SET deleteFlg = 1 WHERE id = :answerId";
        $delete= $pdo->prepare($sql);
        $delete->bindValue(":answerId",$_POST["answerId"],PDO::PARAM_INT);
        $delete->execute();
        }catch(PDOException $ex){
            $err= "接続に失敗しました。";
        }
}

?>