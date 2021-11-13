<?php

// nastraivaem podklju4enie k baze dannqh
require("conf.php");
//session_start();
//if (!isset($_SESSION['tuvastamine'])) {
//   header('Location: login.php');
//    exit();
//}

// nfstaivaem podklju4enie k funktsiam
require("functions.php");
$sort = "kaubanimi";
$search_term = "";

// sortirovka
if(isset($_REQUEST["sort"])) {
    $sort = $_REQUEST["sort"];
}

// poisk
if(isset($_REQUEST["search_term"])) {
    $search_term = $_REQUEST["search_term"];
}

// dobavlenie novoi grupq tovarov
if(isset($_REQUEST["kaubagrupi_lisamine"])&&!empty($_REQUEST["kaubagrupp"])) {
    addProductGroup($_REQUEST["kaubagrupp"]);
    header("Location: index.php");
    exit();
}

// dobavlenie novogo tovara
if(isset($_REQUEST["kauba_lisamine"])&&!empty($_REQUEST["kaubanimi"])&&!empty($_REQUEST["hind"])) {
    addProduct($_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["kaubagrupp_id"]);
    header("Location: index.php");
    exit();
}

// udalenie producta/tovara
if(isset($_REQUEST["delete"])) {
    deleteProduct($_REQUEST["delete"]);
}

// sohranenie
if(isset($_REQUEST["save"])) {
    saveProduct($_REQUEST["changed_id"], $_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["kaubagrupp_id"]);
}
$product = countyData($sort, $search_term);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Kaubad ja Kaubagrupid</title>
</head>
<body>
<header class="header">
    <p>Admin on sisse logitud</p> <!-- avtorizatsia -->
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout">
    </form>
    <div class="container">
        <h1>Tabelid | Kaubad ja Kaubagrupid</h1>
    </div>
</header>
<main class="main">
    <div class="container">
        <form action="index.php">
            <input type="text" name="search_term" placeholder="Otsi..."> <!-- pole dla poiska -->
        </form>
    </div>
    <?php if(isset($_REQUEST["edit"])): ?> <!-- funktsia redaktirovania -->
        <?php foreach($product as $goods): ?>
            <?php if($goods->id == intval($_REQUEST["edit"])): ?>
                <div class="container">
                    <form action="index.php">
                        <input type="hidden" name="changed_id" value="<?=$goods->id ?>"/> <!-- skrqtoe pole radaktirovania ID -->
                        <input type="text" name="kaubanimi" value="<?=$goods->kaubanimi?>"> <!-- pole dlja redaktirovania imeni tovara -->
                        <input type="number" name="hind" value="<?=$goods->hind?>"> <!-- pole dlja redaktirovania tsenq -->
                        <?php echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid", "kaubagrupp_id"); ?> <!-- pole dlja redaktirovania nazvania gruppq tovara -->
                        <a title="Katkesta muutmine" class="cancelBtn" href="index.php" name="cancel">X</a> <!-- knopka otmenq izmenenii -->
                        <input type="submit" name="save" value="&#10004;"> <!-- knopka sohranenia izmenenii -->
                    </form>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="container">
        <table> <!-- tablica s tovarami -->
            <thead>
            <tr>
                <th>Id</th>
                <th><a href="index.php?sort=kaubanimi">Kaubanimi</a></th> <!-- sortirovka po imeni tovara -->
                <th><a href="index.php?sort=hind">Hind</a></th> <!-- sortirovka po tsene -->
                <th><a href="index.php?sort=kaubagrupp">Kaubagrupp</a></th> <!-- sortirovka po tipu tovara -->
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($product as $goods): ?> <!-- otobrazenie samih tovarov -->
                <tr>
                    <td><strong><?=$goods->id ?></strong></td> <!-- id tovara -->
                    <td><?=$goods->kaubanimi ?></td> <!-- imja tovara -->
                    <td><?=$goods->hind ?></td> <!-- tsena tovara -->
                    <td><?=$goods->kaubagrupp ?></td> <!-- tip tovara -->
                    <td>
                        <a title="Kustuta kaup" class="deleteBtn" href="index.php?delete=<?=$goods->id?>"
                           onclick="return confirm('Oled kindel, et soovid kustutada?');">X</a> <!-- knopka udalenija tovara -->
                        <a title="Muuda kaupa" class="editBtn" href="index.php?edit=<?=$goods->id?>">&#9998;</a> <!-- knopka iznebebia tovara -->
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form action="index.php"> <!-- forma dlja dobavlenia tovara -->
            <h2>Kaubagrupi lisamine:</h2>
            <dl>
                <dd><input type="text" name="kaubagrupp" placeholder="Sisesta kaubagrupi..."></dd> <!-- pole dlja nazvania tipa tovara -->
                <input type="submit" name="kaubagrupi_lisamine" value="Lisa"> <!-- knopka dla srabatqvaia fuktsii dlja dobavlenia tipa tovara v bazu dannqh -->
            </dl>
        </form>
        <form action="index.php">
            <h2>Kauba lisamine:</h2>
            <dl>
                <dt>Kaubanimi:</dt>
                <dd><input type="text" name="kaubanimi" placeholder="Sisesta kaubanimi..."></dd> <!-- pole dlja nazvania tovara -->
                <dt>Hind:</dt>
                <dd><input type="number" name="hind" placeholder="Sisesta hinda..."></dd> <!-- pole dlja tsenq tovara -->
                <dt>Kaubagrupp</dt>
                <dd><?php
                    echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid", "kaubagrupp_id");
                    ?></dd> <!-- pole dlja vqbora tipa tovara -->
                <input type="submit" name="kauba_lisamine" value="Lisa pood"> <!-- knopka dla srabatqvaia fuktsii dlja dobavlenia tovara v bazu dannqh -->
            </dl>
        </form>
    </div>
</main>
</body>
</html>
