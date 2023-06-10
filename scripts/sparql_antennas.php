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
        $cell_type = 'Unknown';
        $antenna_id = $row['antenna_id'];
        $provider = $row['provider'];
        $adaptive = ($row['adaptive'] == 1) ? 'true' : 'false';
        $powercode = $row['powercode'];

        switch($row['type']) {
            case '1':
                $cell_type = 'Femto';
                break;
            case '2':
                $cell_type = 'Macro';
                break;
            case '3':
                $cell_type = 'Micro';
                break;
            case '4':
                $cell_type = 'Pico';
                break;
        }

        echo htmlspecialchars("<$antenna_id> a <http://ontologies.metaphacts.com/antennas/MobileAntenna>.")."<br/>";
        echo htmlspecialchars("<$antenna_id> <http://ontologies.metaphacts.com/antennas/antennaHasCoordinates> <$lat_lon>.")."<br/>";
        echo htmlspecialchars("<$antenna_id> <http://ontologies.metaphacts.com/antennas/antennaIsOwnedBy> <$provider>.")."<br/>";
        echo htmlspecialchars("<$antenna_id> <http://ontologies.metaphacts.com/antennas/antennaId> '$antenna_id'.")."<br/>";
        echo htmlspecialchars("<$antenna_id> <http://ontologies.metaphacts.com/antennas/cellType> '$cell_type'.")."<br/>";
        echo htmlspecialchars("<$antenna_id> <http://ontologies.metaphacts.com/antennas/adaptive> $adaptive.")."<br/>";
        echo htmlspecialchars("<$antenna_id> <http://ontologies.metaphacts.com/antennas/powercode> '$powercode'.")."<br/>";
        if($row['tech_2g'] == 1) echo htmlspecialchars("<$antenna_id> <http://ontologies.metaphacts.com/antennas/technology> '2g'.")."<br/>";
        if($row['tech_3g'] == 1) echo htmlspecialchars("<$antenna_id> <http://ontologies.metaphacts.com/antennas/technology> '3g'.")."<br/>";
        if($row['tech_4g'] == 1) echo htmlspecialchars("<$antenna_id> <http://ontologies.metaphacts.com/antennas/technology> '4g'.")."<br/>";

    }
    echo htmlspecialchars("} WHERE {}")."<br/>";
}

conn_close($conn);