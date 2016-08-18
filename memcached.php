<?php
// 若程式正在執行中，關閉瀏覽器後會繼續在背景執行
ignore_user_abort(true);
// php執行30秒後會自動關閉，將limit設定為0，30秒後會繼續執行
set_time_limit(0);

// 在開發過程中看到實際的錯誤提示
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
