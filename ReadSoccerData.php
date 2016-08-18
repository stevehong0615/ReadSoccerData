<?php
header("content-type: text/html; charset=utf-8");
header("Refresh: 60; url='https://lab-stevehong0615.c9users.io/ReadSoccerData/ReadSoccerData.php'");

require_once 'Connect.php';

$url = "http://www.228365365.com/sports.php";
$urlEvent = "http://www.228365365.com/app/member/FT_browse/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game=";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookieData.txt");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, $urlEvent);
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookieData.txt");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);

$event = fopen("event.txt", "w");
fwrite($event, $output);
fclose($event);

curl_close($ch);

$event = fopen("event.txt", "r");

while (!feof($event)) {
    $eventData = fgets($event);

    if (false === $eventData) {
        break;
    }

    if (preg_match("/parent.GameFT/", $eventData)) {
        $eventData = str_replace("parent.", "$", $eventData);
        $eventData = str_replace("new Array", "Array", $eventData);
        $eventData = str_replace("<font color=red>Running Ball</font>", "", $eventData);
        $eventData = str_replace("<br>", "", $eventData);
        $result .= "$eventData";
    }
}

eval($result);

$connect = new Connect;

$deleteData = "DELETE FROM `read_soccer_data`";
$deleteData = $connect->db->prepare($deleteData);
$deleteData->execute();

foreach ($GameFT as $key => $value) {
    $id = $value[0];
    $datetime = $value[1];
    $league = $value[2];
    $eventOne = $value[5];
    $eventTwo = $value[6];
    $eventThree = "和";
    $winOvOne = $value[15];
    $winOvTwo = $value[16];
    $winOvThree = $value[17];
    $handicapOvOne = $value[9];
    $handicapOvTwo = $value[10];
    $sizeOvBig = str_replace("O", "大", $value[11]);
    $sizeOvOne = $sizeOvBig . " " . $value[14];
    $sizeOvSmall = str_replace("U", "小", $value[12]);
    $sizeOvTwo = $sizeOvSmall . " " . $value[13];
    $monoOne = $value[18] . $value[20];
    $monoTwo = $value[19] . $value[21];
    $winHaOne = $value[31];
    $winHaTwo = $value[32];
    $winHaThree = $value[33];
    $handicapHaOne = $value[25];
    $handicapHaTwo = $value[26];
    $sizeHaBig = str_replace("O", "大", $value[27]);
    $sizeHaOne = $sizeHaBig . " " . $value[30];
    $sizeHaSmall = str_replace("U", "小", $value[28]);
    $sizeHaTwo = $sizeHaSmall . " " . $value[29];

    $insertData = "INSERT INTO `read_soccer_data` (`id`, `datetime`, `league`, `event_one`,
        `event_two`, `event_three`, `win_ov_one`, `win_ov_two`, `win_ov_three`, `handicap_ov_one`,
        `handicap_ov_two`, `size_ov_one`, `size_ov_two`, `mono_one`, `mono_two`, `win_ha_one`,
        `win_ha_two`, `win_ha_three`, `handicap_ha_one`, `handicap_ha_two`, `size_ha_one`, `size_ha_two`)
        VALUES (:id, :datetime, :league, :event_one, :event_two, :event_three, :win_ov_one,
        :win_ov_two, :win_ov_three, :handicap_ov_one, :handicap_ov_two, :size_ov_one,
        :size_ov_two, :mono_one, :mono_two, :win_ha_one, :win_ha_two, :win_ha_three,
        :handicap_ha_one, :handicap_ha_two, :size_ha_one, :size_ha_two)";

    $data = $connect->db->prepare($insertData);
    $data->bindParam(':id', $id);
    $data->bindParam(':datetime', $datetime);
    $data->bindParam(':league', $league);
    $data->bindParam(':event_one', $eventOne);
    $data->bindParam(':event_two', $eventTwo);
    $data->bindParam(':event_three', $eventThree);
    $data->bindParam(':win_ov_one', $winOvOne);
    $data->bindParam(':win_ov_two', $winOvTwo);
    $data->bindParam(':win_ov_three', $winOvThree);
    $data->bindParam(':handicap_ov_one', $handicapOvOne);
    $data->bindParam(':handicap_ov_two', $handicapOvTwo);
    $data->bindParam(':size_ov_one', $sizeOvOne);
    $data->bindParam(':size_ov_two', $sizeOvTwo);
    $data->bindParam(':mono_one', $monoOne);
    $data->bindParam(':mono_two', $monoTwo);
    $data->bindParam(':win_ha_one', $winHaOne);
    $data->bindParam(':win_ha_two', $winHaTwo);
    $data->bindParam(':win_ha_three', $winHaThree);
    $data->bindParam(':handicap_ha_one', $handicapHaOne);
    $data->bindParam(':handicap_ha_two', $handicapHaTwo);
    $data->bindParam(':size_ha_one', $sizeHaOne);
    $data->bindParam(':size_ha_two', $sizeHaTwo);
    $data->execute();
}
