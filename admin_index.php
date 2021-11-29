<?php
// проверка пользователя
session_start();
// nastraivaem podklju4enie k baze dannqh
require("conf.php");
if (!isset($_SESSION['tuvastamine'])) {
    //header('Location: ab_login.php');
    echo "<script>self.location='https://makarov20.thkit.ee/PHP/phpLehestik/content/kaubad_ja_kaubagrupid/ab_login.php';</script>"; //pereadressatsia s pomoshju JS
    exit();
}
if(isset($_POST['logout'])){
    session_destroy();
    //header('Location: ab_login.php');
    echo "<script>self.location='https://makarov20.thkit.ee/PHP/phpLehestik/content/kaubad_ja_kaubagrupid/ab_login.php';</script>"; //pereadressatsia s pomoshju JS
    exit();
}

// nfstaivaem podklju4enie k funktsiam
require("functions.php");
//$sort = "kaubagrupp";
$search_term = "";

// dobavlenie novoi grupq tovarov
if(isset($_REQUEST["kaubagrupi_lisamine"])&&!empty($_REQUEST["kaubagrupp"])) {
    addProductGroup($_REQUEST["kaubagrupp"]);
    //header("Location: https://makarov20.thkit.ee/PHP/phpLehestik/content/kaubad_ja_kaubagrupid/index.php");
    //header:("Location: ".$_SERVER["PHP_SELF"]);  //$_SERVER['REQUEST_URI'] $_SERVER["PHP_SELF"]
    echo "<script>self.location='https://makarov20.thkit.ee/PHP/phpLehestik/content/kaubad_ja_kaubagrupid/admin_index.php';</script>"; //pereadressatsia s pomoshju JS
    //echo "<meta http-equiv='Location' content='http://example.com/final.php'>" //pereadressatsia s pomoshju HTML
    exit();
}

// udalenie producta/tovara
if(isset($_REQUEST["delete"])) {
    deleteProductType($_REQUEST["delete"]);
}

$group = product_typeData();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <!--<link rel="stylesheet" type="text/css" href="../../style/php_style.css">-->
    <title>Kaubad ja Kaubagrupid</title>
</head>
<body>
<header class="header">
    <!-- <div class="header">  <header>  -->
    <p>Admin on sisse logitud</p> <!-- avtorizatsia -->
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout">
    </form><!--  </header> -->
    <div class="container">
        <h1>Tabelid | Kaubad ja Kaubagrupid</h1>
    </div>
</header>
<?php
include('../php_matkaLeht/matk_navigation.php');
?>
<main class="main">
    <div class="container">
        <table> <!-- tablica s tovarami -->
            <thead>
            <tr>
                <th>Id</th>
                <th>Kaubagrupp</th> <!-- sortirovka po tipu tovara -->
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($group as $product_type): ?> <!-- otobrazenie samih tovarov -->
                <tr>
                    <td><strong><?=$product_type->id ?></strong></td>
                    <td><?=$product_type->kaubagrupp ?></td> <!-- tip tovara -->
                    <td>
                        <a title="Kustuta kaup" class="deleteBtn" href="admin_index.php?delete=<?=$product_type->id?>"
                           onclick="return confirm('Oled kindel, et soovid kustutada?');">X</a> <!-- knopka udalenija tovara -->
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form action="admin_index.php"> <!-- forma dlja dobavlenia tovara -->
            <h2>Kaubagrupi lisamine:</h2>
            <dl>
                <dd><input type="text" name="kaubagrupp" placeholder="Sisesta kaubagrupi..."></dd> <!-- pole dlja nazvania tipa tovara -->
                <input type="submit" name="kaubagrupi_lisamine" value="Lisa"> <!-- knopka dla srabatqvaia fuktsii dlja dobavlenia tipa tovara v bazu dannqh -->
            </dl>
        </form>
    </div>
</main>
<h3><a href="https://github.com/MastroPhaedra/kaubad_ja_kaubagrupid" target="_blank">GitHub</a></h3>
<?php
include('../../footer.php');
?>
</body>
</html>