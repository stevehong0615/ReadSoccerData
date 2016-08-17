<?php
require_once 'ReadSoccerData.php';

$eventData = getData();
$a = writeData($eventData);
echo $a;
