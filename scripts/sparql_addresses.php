<?php

require('config.php');
require('db.php');
require('functions.php');

$conn = conn_open();

$street_ids = array();

$sql = mysqli_query($conn, "SELECT DISTINCT city_zip, city_name, streetname, number FROM locations WHERE streetname != '';");
if(mysqli_num_rows($sql)>0){
    echo htmlspecialchars("BASE <http://example.org>")."<br/>";
    echo htmlspecialchars("INSERT {")."<br/>";
    while($row = mysqli_fetch_assoc($sql)){

        $city = toAlphanumerical($row['city_name']);
        $street = toAlphanumerical($row['streetname']);
        $number = toAlphanumerical($row['number']);
        $identifier = toAlphanumerical($row['city_zip'].' '.$street.' '.$number);
        $street_id = toAlphanumerical($row['city_zip'].' '.$street);

        if(!in_array($street_id, $street_ids)){
            echo htmlspecialchars("<$street_id> a <http://ikm-group.ch/archiMEO/top#Street>.")."<br/>";
            echo htmlspecialchars("<$street_id> <http://ikm-group.ch/archiMEO/top#streetBelongsToCity> <$city>.")."<br/>";
            array_push($street_ids, $street_id);
        }

        echo htmlspecialchars("")."<br/>";
        echo htmlspecialchars("<$identifier> <http://ikm-group.ch/archiMEO/top#buildingIsLocatedInStreet> <$street_id>.")."<br/>";
        echo htmlspecialchars("<$identifier> <http://ikm-group.ch/archiMEO/top#buildingHasNumber> '$number'.")."<br/>";

    }
    echo htmlspecialchars("} WHERE {}")."<br/>";
}

conn_close($conn);