<?php

// nastraivaem podklju4enie k baze dannqh
require ('conf.php');

// funtsia sortirovki
function countyData($sort_by = "kaubanimi", $search_term = "") {

    global $connection;

    $sort_list = array("kaubanimi", "hind", "kaubagrupp"); // massiv s nazvaniami po kotorqm budet dostupna sortirovka

    if(!in_array($sort_by, $sort_list)) {

        return "Seda tulpa ei saa sorteerida"; // uvedomlenie na slutsai oshibki

    }

    $request = $connection->prepare("SELECT kaubad.id, kaubanimi, hind, kaubagrupid.kaubagrupp

    FROM kaubad, kaubagrupid 

    WHERE kaubad.kaubagrupp_id = kaubagrupid.id 

    AND (kaubanimi LIKE '%$search_term%' OR hind LIKE '%$search_term%' OR kaubagrupp LIKE '%$search_term%')

    ORDER BY $sort_by"); //otpravka zaprosa v bazu dannqh (BD)

    $request->bind_result($id, $product_name, $price, $productGroup_name); // polu4ennqe dannqe po zaprosu iz BD priravnivaem k peremennqm v skobkah

    $request->execute();

    $data = array();

    while($request->fetch()) {

        $product = new stdClass(); // novii svobodnogo, poka ne opredeljonnogo klassa

        $product->id = $id; // ID

        $product->kaubanimi = htmlspecialchars($product_name); // kaubanimi

        $product->hind = htmlspecialchars($price); // hind

        $product->kaubagrupp = $productGroup_name; //kaubagrupp

        array_push($data, $product);

    }

    return $data;

}

// funktsia poiska
function createSelect($query, $name) {

    global $connection;

    $query = $connection->prepare($query);

    $query->bind_result($id, $data);

    $query->execute();

    $result = "<select name='$name'>";

    while($query->fetch()) {

        $result .= "<option value='$id'>$data</option>";

    }

    $result .= "</select>";

    return $result;

}

// funktsia dlja dobavlenia "kaubagrupp" v tablitsi "kaubagrupid"
function addProductGroup($productGroup_name) {

    global $connection;

    $query = $connection->prepare("INSERT INTO kaubagrupid (kaubagrupp)

    VALUES (?)");

    $query->bind_param("s", $productGroup_name);

    $query->execute();

}

// funktsia dlja dobavlenia "kaubanimi", "hind", "kaubagrupp_id" v tablitsi "kaubad"
function addProduct($product_name, $price, $productGroup_id) {

    global $connection;

    $query = $connection->prepare("INSERT INTO kaubad (kaubanimi, hind, kaubagrupp_id)

    VALUES (?, ?, ?)");

    $query->bind_param("sdi", $product_name, $price, $productGroup_id);

    $query->execute();

}

// funktsia dlja udalenia tovara iz tablitsi "kaubad"
function deleteProduct($product_id) {

    global $connection;

    $query = $connection->prepare("DELETE FROM kaubad WHERE id=?");

    $query->bind_param("i", $product_id);

    $query->execute();

}

// funktsia dlja OBNOVLENIA dannqh tovara v tablitsi "kaubad"
function saveProduct($product_id, $product_name, $price, $productGroup_id) {

    global $connection;

    $query = $connection->prepare("UPDATE kaubad

    SET kaubanimi=?, hind=?, kaubagrupp_id=?

    WHERE kaubad.id=?");

    $query->bind_param("sdii", $product_name, $price, $productGroup_id, $product_id);

    $query->execute();

}

?>