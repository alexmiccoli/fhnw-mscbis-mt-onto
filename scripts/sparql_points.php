<?php

require('config.php');
require('db.php');
require('functions.php');

$conn = conn_open();

$street_ids = array();
$points = array();

$sql = mysqli_query($conn, "SELECT * FROM antennas left join locations on antennas.location_id = locations.location_id ORDER BY antennas.antenna_id ASC;");
if(mysqli_num_rows($sql)>0){
    echo htmlspecialchars("BASE <http://example.org>")."<br/>";
    echo htmlspecialchars("INSERT {")."<br/>";
    while($row = mysqli_fetch_assoc($sql)){

        $city = toAlphanumerical($row['city_name']);
        $street = toAlphanumerical($row['streetname']);
        $number = toAlphanumerical($row['number']);
        $building = toAlphanumerical($row['city_zip'].' '.$street.' '.$number);
        $street_id = toAlphanumerical($row['city_zip'].' '.$street);
        $lat_lon = $row['lat'].'_'.$row['lon'];
        $lat = $row['lat'];
        $lon = $row['lon'];

        if(!in_array($lat_lon, $points)){
            echo htmlspecialchars("<$lat_lon> a <http://ontologies.metaphacts.com/antennas/Point>.")."<br/>";
            echo htmlspecialchars("<$lat_lon> a <http://ontologies.metaphacts.com/antennas/Point>.")."<br/>";
            echo htmlspecialchars("<$lat_lon> <http://ontologies.metaphacts.com/antennas/latitude> '$lat'.")."<br/>";
            echo htmlspecialchars("<$lat_lon> <http://ontologies.metaphacts.com/antennas/longitude> '$lon'.")."<br/>";
            echo htmlspecialchars("<$lat_lon> <http://ontologies.metaphacts.com/antennas/coordinateSystem> 'WGS84'.")."<br/>";
            if($row['streetname'] == '') echo htmlspecialchars("<$lat_lon> <http://ontologies.metaphacts.com/antennas/pointIsInCity> <$city>.")."<br/>";
            if($row['streetname'] != '' && $row['number'] == '') echo htmlspecialchars("<$lat_lon> <http://ontologies.metaphacts.com/antennas/pointIsInStreet> <$street>.")."<br/>";
            if($row['streetname'] != '' && $row['number'] != '') echo htmlspecialchars("<$lat_lon> <http://ontologies.metaphacts.com/antennas/pointIsOnBuilding> <$building>.")."<br/>";
            array_push($points, $lat_lon);
        }
    }
    echo htmlspecialchars("} WHERE {}")."<br/>";
}

conn_close($conn);