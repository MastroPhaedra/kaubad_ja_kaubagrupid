<?php
// nastraivaem podklju4enie k baze dannqh
//require("conf.php");
// проверка пользователя
session_start();
/*if (!isset($_SESSION['tuvastamine'])) {
    header('Location: login.php');
    exit();
}*/
if (!empty($_POST['login']) && !empty($_POST['pass'])){
    $login=$_POST['login'];
    $pass=$_POST['pass'];
    if($login=='admin' && $pass=='admin'){
        $_SESSION['tuvastamine']='tere';
        //header('Location: index.php');
        echo "<script>self.location='https://makarov20.thkit.ee/PHP/phpLehestik/content/kaubad_ja_kaubagrupid/index.php';</script>"; //pereadressatsia s pomoshju JS
    }
}
?>
<h1>Login vorm</h1>
<table>
    <form action="" method="post">
        <tr>
            <td>Kasutaja nimi:</td>
            <td><input type="text" name="login" placeholders="Login"></td>
        </tr>
        <tr>
            <td>Salasõna:</td>
            <td><input type="text" name="pass" placeholders="Salasõna"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Logi sisse"></td>
        </tr>
    </form>
</table>

<!--
CREATE TABLE kasutajad (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nimi VARCHAR(10),
    parool text
);
-->