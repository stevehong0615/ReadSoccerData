<?php
// 在開發過程中看到實際的錯誤提示
error_reporting(E_ALL & ~E_NOTICE);

$mc = new Memcached();
$mc->addServer("localhost", 11211);

echo json_encode($mc->get("dataToday"));
