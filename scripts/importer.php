<?php

require('config.tpl.php');
require('db.php');

function import_canton($conn){
    $json = file_get_contents('data/geodata_cantonal_lu.geojson');
    $data = json_decode($json)->features;

    foreach($data as $d){
        $sl = is_null($d->properties->SENDELEISTUNG) ? 'null' : $d->properties->SENDELEISTUNG;
        $q = "INSERT INTO `geodata`.`lucerne` (`OBJECTID`, `MFS_CODE`, `MFS_ANBIETER`, `ZELLTECH_2G`, `ZELLTECH_3G`, `ZELLTECH_4G`, `ZELLTECH_5G`, `ZELLTYP`, `ADBTBETRIEB`,`SENDELEISTUNG`, `LAT`, `LONG`) VALUES (".$d->properties->OBJECTID.", '".$d->properties->MFS_CODE."', ".$d->properties->MFS_ANBIETER.", ".$d->properties->ZELLTECH_2G.", ".$d->properties->ZELLTECH_3G.", ".$d->properties->ZELLTECH_4G.", ".$d->properties->ZELLTECH_5G.", ".$d->properties->ZELLTYP.", ".$d->properties->ADBTBETRIEB.", ".$sl.", ".$d->geometry->coordinates[1].", ".$d->geometry->coordinates[0].");";
        mysqli_query($conn, $q);
    }
}

function import_swisscom($conn, $tech){
    $count = 0;
    echo "<ul><li>Importer started with parameter: $tech</li>";

    $json = file_get_contents('data/swisscom_'.$tech.'.json');
    $data = json_decode($json, true);

    echo "<ul>";

    $src = 'json_'.$tech;

    $t2 = ($tech == '2g') ? 1 : 0;
    $t3 = ($tech == '3g') ? 1 : 0;
    $t4 = ($tech == '4g') ? 1 : 0;

    foreach($data as $d) {
        echo "<li>[$count] ";

        $id = $d['id'];
        $lat = $d['geopoint']['lat'];
        $lon = $d['geopoint']['lon'];
        $powercode = $d['powercode_en'];

        $q = "SELECT `id`, `src` FROM `geodata`.`swisscom` WHERE `lat` = '$lat' AND lon = '$lon';";
        $sql = mysqli_query($conn, $q);
        if(mysqli_num_rows($sql)>0){
            //UPDATE
            echo "Found duplicate location for '$lat; $lon'<ul>";
            while($row = mysqli_fetch_assoc($sql)){
                if($row['src'] == $src){
                    echo "<li>Skipped record with ID #$id (already processed)</li>";
                    continue;
                }
                $id = $row['id'];
                if($tech == '2g') $q = "UPDATE `geodata`.`swisscom` SET `tech_2g` = '1', `src` = '$src' WHERE (`id` = '$id');";
                if($tech == '3g') $q = "UPDATE `geodata`.`swisscom` SET `tech_3g` = '1', `src` = '$src' WHERE (`id` = '$id');";
                if($tech == '4g') $q = "UPDATE `geodata`.`swisscom` SET `tech_4g` = '1', `src` = '$src' WHERE (`id` = '$id');";
                mysqli_query($conn, $q);
                echo "<li>Updated record with ID #$id</li>";
            }
            echo "</ul>";
        }else{
            //CREATE
            $q = "INSERT INTO `geodata`.`swisscom` (`id`, `tech_2g`, `tech_3g`, `tech_4g`, `lat`, `lon`, `powercode`, `src`) VALUES ('".$id."', '".$t2."', '".$t3."', '".$t4."', '".$lat."', '".$lon."', '".$powercode."', '".$src."');";
            mysqli_query($conn, $q);
            echo "Inserted record with ID #$id";
        }
        echo "</li>";
        $count++;
    }

    echo "</ul>";
    echo "<li>Processed $count elements from JSON file</li></ul>";
}

$conn = conn_open();
import_swisscom($conn, '4g');
conn_close($conn);