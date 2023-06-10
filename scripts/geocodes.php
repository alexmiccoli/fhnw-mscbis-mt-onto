<?php

require('config.tpl.php');
require('db.php');

$conn = conn_open();

$sql = mysqli_query($conn, "SELECT * FROM `geodata`.`antennas` WHERE `location_id` IS NULL LIMIT 50;");
if(mysqli_num_rows($sql)>0){
    while($row = mysqli_fetch_assoc($sql)){
        $antenna_id = $row['antenna_id'];

        $url = $GLOBALS['maps_geocodes_url'].'?latlng='.$row["lat"].','.$row["lon"].'&key='.$GLOBALS['maps_key'];

        $street_number = '';
        $route = '';
        $locality = '';
        $postal_code = '0';
        $administrative_area_level_2 = '';


        $json = json_decode(file_get_contents($url));

        foreach($json->results[0]->address_components as $c){
            if($c->types[0] == 'street_number') $street_number = $c->long_name;
            if($c->types[0] == 'route') $route = $c->long_name;
            if($c->types[0] == 'locality') $locality = $c->long_name;
            if($c->types[0] == 'postal_code') $postal_code = $c->long_name;
            if($c->types[0] == 'administrative_area_level_2') $administrative_area_level_2 = $c->long_name;
        }



        $newLocation = "INSERT INTO `geodata`.`locations` (`location_id`, `streetname`, `number`, `city_zip`, `city_name`, `region`, `canton_code`, `canton_name_en`, `country_code`, `country_name_en`) VALUES (null, '$route', '$street_number', '$postal_code', '$locality', '$administrative_area_level_2', 'LU', 'Lucerne', 'CH', 'Switzerland');";

        if (mysqli_query($conn, $newLocation)) {
            $last_id = mysqli_insert_id($conn);
            $update = "UPDATE `geodata`.`antennas` SET `location_id` = '$last_id' WHERE (`antenna_id` = '$antenna_id');";
            mysqli_query($conn, $update);
            echo $update.'<br/>';
            echo "Updated antenna $antenna_id with location $last_id<br/>";
        }
    }
}

conn_close($conn);