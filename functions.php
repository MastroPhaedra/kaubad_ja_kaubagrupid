<?php 

require ('conf.php');

function countyData($sort_by = "kaubanimi", $search_term = "") {

    global $connection;

    $sort_list = array("kaubanimi", "hind", "kaubagrupp");

    if(!in_array($sort_by, $sort_list)) {

        return "Seda tulpa ei saa sorteerida";

    }

    $request = $connection->prepare("SELECT kaubad.id, kaubanimi, hind, kaubagrupid.kaubagrupp

    FROM kaubad, kaubagrupid 

    WHERE kaubad.id = kaubagrupid.id 

    AND (kaubanimi LIKE '%$search_term%' OR hind LIKE '%$search_term%' OR kaubagrupp LIKE '%$search_term%')

    ORDER BY $sort_by");

    $request->bind_result($id, $kaubanimi, $hind, $kaubagrupid);

    $request->execute();

    $data = array();

    while($request->fetch()) {

        $person = new stdClass();

        $person->id = $id;

        $person->eesnimi = htmlspecialchars($eesnimi);

        $person->perekonnanimi = htmlspecialchars($perekonnanimi);

        $person->maakonna_nimi = $maakonna_nimi;

        array_push($data, $person);

    }

    return $data;

}

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

function addCounty($county_name, $county_centre) {

    global $connection;

    $query = $connection->prepare("INSERT INTO maakond (maakonna_nimi, maakonna_keskus)

    VALUES (?, ?)");

    $query->bind_param("si", $county_name, $county_centre);

    $query->execute();

}

function addPerson($first_name, $last_name, $county_id) {

    global $connection;

    $query = $connection->prepare("INSERT INTO inimene (eesnimi, perekonnanimi, maakonna_id)

    VALUES (?, ?, ?)");

    $query->bind_param("ssd", $first_name, $last_name, $county_id);

    $query->execute();

}

function deletePerson($person_id) {

    global $connection;

    $query = $connection->prepare("DELETE FROM inimene WHERE id=?");

    $query->bind_param("i", $person_id);

    $query->execute();

}

function savePerson($person_id, $first_name, $last_name, $county_id) {

    global $connection;

    $query = $connection->prepare("UPDATE inimene

    SET eesnimi=?, perekonnanimi=?, maakonna_id=?

    WHERE inimene.id=?");

    $query->bind_param("ssii", $first_name, $last_name, $county_id, $person_id);

    $query->execute();

}

?>
