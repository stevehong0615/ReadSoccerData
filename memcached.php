<?php
ignore_user_abort(true);
set_time_limit(0);

error_reporting(E_ALL & ~E_NOTICE);
require_once 'Connect.php';

$mc = new Memcached();
$mc->addServer("localhost", 11211);

$connect = new Connect;

while (true) {
    $selectData = "SELECT * FROM `read_soccer_data`";
    $data = $connect->db->prepare($selectData);
    $data->execute();
    $result = $data->fetchAll(PDO::FETCH_ASSOC);

    $mc->set("dataToday", $result);
    sleep(60);
}
