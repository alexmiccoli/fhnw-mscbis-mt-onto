<?php

function conn_open(){
    $conn = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_base']);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully<hr/>";

    return $conn;
}

function conn_close($c){
    mysqli_close($c);
    //echo "<hr/>Connected closed";
}