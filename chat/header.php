
<?php if(isset($_SESSION["chatApp"])):?>
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
        <input type="submit" name="logout" value="ログアウト">
        </form>
        <p>こんにちは<?= $_SESSION["chatApp"]->getUserBean()->getName()?>さん</p>
<?php else:?>
        <form action="index.php" method="GET">
        <input type="submit" name="" value="ログイン">
        </form>
<?php endif; ?>