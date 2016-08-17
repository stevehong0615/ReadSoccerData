<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once 'Connect.php';

$mc = new Memcached();
$mc->addServer("localhost", 11211);

$connect = new Connect;

$selectData = "SELECT * FROM `read_soccer_data`";
$data = $connect->db->prepare($selectData);
$data->execute();
$result = $data->fetchAll(PDO::FETCH_ASSOC);

$mc->set("dataToday", $result);

$arr = array(
    $mc->get("dataToday"),
);
var_dump($arr);
?>