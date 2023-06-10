<?php

require('config.php');
require('db.php');
require('functions.php');

$conn = conn_open();

$sql = mysqli_query($conn, "SELECT DISTINCT city_name, region FROM locations;");
if(mysqli_num_rows($sql)>0){
    echo htmlspecialchars("BASE <http://example.org>")."<br/>";
    echo htmlspecialchars("INSERT {")."<br/>";
    while($row = mysqli_fetch_assoc($sql)){

        $region = toAlphanumerical($row['region']);
        $city = toAlphanumerical($row['city_name']);
        $city_orig = $row['city_name'];
        echo htmlspecialchars("<$city> a <http://ikm-group.ch/archiMEO/top#City>").".<br/>";

        $zips = mysqli_query($conn, "SELECT DISTINCT city_zip FROM locations WHERE city_name = '$city';");
        if(mysqli_num_rows($zips)>0) {
            while ($r = mysqli_fetch_assoc($zips)) {
                $zip = $r['city_zip'];
                echo htmlspecialchars("<$city> <http://ikm-group.ch/archiMEO/top#cityHasPostalCode> <$zip>").".<br/>";
            }
        }

        echo htmlspecialchars("<$city> <http://ikm-group.ch/archiMEO/top#cityIsLocatedInPartOfCountry> <$region>").".<br/>";
        echo htmlspecialchars("<$city> <http://ikm-group.ch/archiMEO/top#cityIsLocatedInCountry> <Switzerland>").".<br/>";

    }
    echo htmlspecialchars("} WHERE {}")."<br/>";
}

conn_close($conn);