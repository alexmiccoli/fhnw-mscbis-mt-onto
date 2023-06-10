<?php

function toAlphanumerical($string)
{
    $string = str_replace(" ", "_", $string);
    $string = str_replace("ä", "ae", $string);
    $string = str_replace("ü", "ue", $string);
    $string = str_replace("ö", "oe", $string);
    $string = str_replace("Ä", "Ae", $string);
    $string = str_replace("Ü", "Ue", $string);
    $string = str_replace("Ö", "Oe", $string);
    $string = str_replace("ß", "ss", $string);
    $string = str_replace("´", "", $string);
    return $string;
}