<?php
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    //header('Location: login.php');
    echo "<script>self.location='https://makarov20.thkit.ee/PHP/phpLehestik/content/kaubad_ja_kaubagrupid/ab_login.php';</script>"; //pereadressatsia s pomoshju JS
    exit();
}
if(isset($_POST['logout'])){
    session_destroy();
    //header('Location: login.php');
    echo "<script>self.location='https://makarov20.thkit.ee/PHP/phpLehestik/content/kaubad_ja_kaubagrupid/ab_login.php';</script>"; //pereadressatsia s pomoshju JS
    exit();
}
?>