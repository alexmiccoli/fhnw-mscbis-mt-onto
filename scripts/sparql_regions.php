<?php

require('config.php');
require('db.php');
require('functions.php');

$conn = conn_open();

$sql = mysqli_query($conn, "SELECT DISTINCT region, canton_name_en FROM locations;");
if(mysqli_num_rows($sql)>0){
    echo htmlspecialchars("BASE <http://example.org>")."<br/>";
    echo htmlspecialchars("INSERT {")."<br/>";
    while($row = mysqli_fetch_assoc($sql)){

        $region = toAlphanumerical($row['region']);
        $canton = toAlphanumerical($row['canton_name_en']);
        echo htmlspecialchars("<$region> a <http://ikm-group.ch/archiMEO/top#partOfCountry>.")."<br/>";
        echo htmlspecialchars("<$region> <http://ikm-group.ch/archiMEO/top#partOfCountryHasTypeOfPartOfCountry> 'Administrative Region'.")."<br/>";
        echo htmlspecialchars("<$region> <http://ikm-group.ch/archiMEO/top#partOfCountryIsPartOfCountry> <$canton>.")."<br/>";
        echo htmlspecialchars("")."<br/>";

    }
    echo htmlspecialchars("} WHERE {}")."<br/>";
}

conn_close($conn);