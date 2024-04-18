<?php

$list[0] = "17";//vrednost prvega elementa
$list[1] = "Prvi vnos";
$list[] = "Naslednji vnos"; //izpuščen indeks naslovi naslednji element



foreach ($list as $key => $value) {
    echo $key . ". " . $value . "\n";
} 

echo sizeof($list);
?>