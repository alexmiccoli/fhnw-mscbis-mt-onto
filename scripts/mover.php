<?php

require('config.tpl.php');
require('db.php');

$conn = conn_open();

// SUNRISE
/*
$getPoints = mysqli_query($conn, "SELECT * FROM `geodata`.`lucerne` WHERE MFS_ANBIETER = 3 AND ZELLTECH_5G = 0;");
if(mysqli_num_rows($getPoints)>0){
    while($row = mysqli_fetch_assoc($getPoints)){

        $id = 'A200';
        for($i=0; $i<(4-strlen($row['OBJECTID'])); $i++){
            $id .= '0';
        }
        $id .= $row['OBJECTID'];

        $provider = 'Sunrise';
        $lat = $row['LAT'];
        $lon = $row['LONG'];
        $tech_2g = $row['ZELLTECH_2G'];
        $tech_3g = $row['ZELLTECH_3G'];
        $tech_4g = $row['ZELLTECH_4G'];
        $type = '99';
        $adaptive = '99';
        $powercode = 'Unknown';

        $q = "INSERT INTO `geodata`.`antennas` (`antenna_id`, `provider`, `lat`, `lon`, `tech_2g`, `tech_3g`, `tech_4g`, `type`, `adaptive`, `powercode`) VALUES ('$id', '$provider', '$lat', '$lon', '$tech_2g', '$tech_3g', '$tech_4g', '$type', '$adaptive', '$powercode');";
        mysqli_query($conn, $q);

    }
}
*/

// SWISSCOM

$getPoints = mysqli_query($conn, "SELECT * FROM `geodata`.`lucerne` WHERE MFS_ANBIETER = 4 AND ZELLTECH_5G = 0;");
if(mysqli_num_rows($getPoints)>0){
    while($row = mysqli_fetch_assoc($getPoints)){

        $tmp_lat = round($row['LAT'], 3);
        $tmp_lon = round($row['LONG'], 3);

        $getCell = mysqli_query($conn, "SELECT * FROM `geodata`.`swisscom` WHERE lat LIKE '$tmp_lat%' AND lon LIKE '$tmp_lon%';");
        if(mysqli_num_rows($getCell)>0){
            while($cell = mysqli_fetch_assoc($getCell)){

                $id = 'A10';
                for($i=0; $i<(5-strlen($cell['id'])); $i++){
                    $id .= '0';
                }
                $id .= $cell['id'];

                $provider = 'Swisscom';
                $lat = $cell['lat'];
                $lon = $cell['lon'];
                $tech_2g = $cell['tech_2g'];
                $tech_3g = $cell['tech_3g'];
                $tech_4g = $cell['tech_4g'];
                $type = $row['ZELLTYP'];
                $adaptive = $row['ADBTBETRIEB'];
                $powercode = $cell['powercode'];

                $q = "INSERT INTO `geodata`.`antennas` (`antenna_id`, `provider`, `lat`, `lon`, `tech_2g`, `tech_3g`, `tech_4g`, `type`, `adaptive`, `powercode`) VALUES ('$id', '$provider', '$lat', '$lon', '$tech_2g', '$tech_3g', '$tech_4g', '$type', '$adaptive', '$powercode');";
                mysqli_query($conn, $q);

            }
        }
    }
}

conn_close($conn);