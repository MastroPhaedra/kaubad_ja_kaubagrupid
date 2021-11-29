<?php
// проверка пользователя
session_start();
// nastraivaem podklju4enie k baze dannqh
require("conf.php");
global $connection;
/*if (!isset($_SESSION['tuvastamine'])) {
    header('Location: ab_login.php');
    exit();
}
if(isset($_POST['logout'])){
    session_destroy();
    header('Location: ab_login.php');
    exit();
}*/
if (!empty($_POST['login']) && !empty($_POST['pass']) && (strlen($_POST['pass']))>2){
    $login=htmlspecialchars(trim($_POST['login']));
    $pass=htmlspecialchars(trim($_POST['pass']));
    $sool='tavalinetext';
    $krypt=crypt($pass, $sool);
    //echo ($krypt);
    //kontroll, et andmebaasis on selline kasutaja
    $paring="SELECT nimi, parool FROM kasutajad WHERE nimi='$login' AND parool='$krypt'";
    $yhendus=mysqli_query($connection, $paring);
        if(mysqli_num_rows($yhendus)==1){
            if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM kasutajad WHERE nimi='$login' AND parool='$krypt' AND tyyp=1"))==1){ // проверяем, получаем ли мы от сервера ответ по запросу
                $_SESSION['tuvastamine']='Tere admin';
                //header('Location: index.php');
                echo "<script>self.location='https://makarov20.thkit.ee/PHP/phpLehestik/content/kaubad_ja_kaubagrupid/admin_index.php';</script>"; //pereadressatsia s pomoshju JS
                exit();
            } else {
                $_SESSION['tuvastamine']='Tere kasutaja';
                //header('Location: index.php');
                echo "<script>self.location='https://makarov20.thkit.ee/PHP/phpLehestik/content/kaubad_ja_kaubagrupid/index.php';</script>"; //pereadressatsia s pomoshju JS
                exit();
            }
        } else {
            echo '<p style="color:red; font-family: Arial, sans-serif; text-align: center;">Kasutaja ja parool on valed</p>';
        }
    /*if($login=='admin' && $pass=='admin'){
        $_SESSION['tuvastamine']='tere';
        header('Location: index.php');
    }*/
} elseif (strlen($_POST['pass'])<3 && $_POST['login']) {
        echo '<p style="color:red; font-family: Arial, sans-serif; text-align: center;">Parool peab olema 3 ja rohkem sümboleid</p>';
    }
?>
<link rel="stylesheet" href="login_style.css">
<title>Login vorm</title>
<table class="login">
    <form action="" method="post">
        <tr>
            <td colspan="2" class="login-header">Login vorm</td>
        </tr>
        <tr>
            <td>Kasutaja nimi:</td>
            <td><input type="text" name="login" placeholders="Login"></td>
        </tr>
        <tr>
            <td>Salasõna:</td>
            <td><input type="password" name="pass" placeholders="Salasõna"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Logi sisse"></td>
        </tr>
    </form>
</table>
<!--
CREATE TABLE kasutajad (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nimi VARCHAR(10),
    parool TEXT,
    tyyp INT(1) NULL DEFAULT '0'
);

INSERT INTO kasutajad (nimi, parool, tyyp) VALUES ('zakhar', 'tagJdjbPkRspk', 1);
INSERT INTO kasutajad (nimi, parool) VALUES ('kasutaja', 'takGb9VL4XUvM');

Ülesanne:
1.) Lisa parooli pikkuse kontroll (strlen)
2.) Admin - kasutaja parooliga saab maakonnad / kaubagruppide
-->