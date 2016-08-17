<?php
header("content-type: text/html; charset=utf-8");
require_once 'Connect.php';

function getData()
{
    $agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";
    $url = "http://www.228365365.com/sports.php";
    $urlEvent = "http://www.228365365.com/app/member/FT_browse/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game=";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookieData.txt");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);

    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_URL, $urlEvent);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookieData.txt");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);

    $event = fopen("event.txt", "w");
    fwrite($event, $output);
    fclose($event);

    curl_close($ch);

    // echo htmlspecialchars($output);

    $event = fopen("event.txt", "r");

    while (!feof($event)) {
        $eventData = fgets($event);

        if (false === $eventData) {
            break;
        }

        if (preg_match("/parent.GameFT/", $eventData)) {
            $eventData = str_replace("parent.", "$", $eventData);
            $eventData = str_replace("new A", "A", $eventData);
            $eventData = str_replace("<font color=red>Running Ball</font>", "", $eventData);
            $eventData = str_replace("<br>", "", $eventData);
            $result .= "$eventData";
        }
    }
    eval($result);

    return $GameFT;

    // echo $leagueData[0][1];

    // echo $leagueData[0][2];

    // echo $leagueData[0][5];
    // echo $leagueData[0][6];

    // echo $leagueData[0][15];
    // echo $leagueData[0][16];
    // echo $leagueData[0][17];

    // echo $leagueData[0][9];
    // echo $leagueData[0][10];

    // echo str_replace("O", "大", $leagueData[0][11]);
    // echo $leagueData[0][14];
    // echo str_replace("U", "小", $leagueData[0][12]);
    // echo $leagueData[0][13];

    // echo $leagueData[0][18];
    // echo $leagueData[0][20];
    // echo $leagueData[0][19];
    // echo $leagueData[0][21];

    // echo $leagueData[0][31];
    // echo $leagueData[0][32];
    // echo $leagueData[0][33];

    // echo $leagueData[0][25];
    // echo $leagueData[0][26];

    // echo str_replace("O", "大", $leagueData[0][27]);
    // echo $leagueData[0][30];
    // echo str_replace("U", "小", $leagueData[0][28]);
    // echo $leagueData[0][29];
}

function writeData($leagueData)
{
    foreach ($leagueData as $key => $value) {
        $datetime = $value[1];
        $league = $value[2];
    }

    // var_dump($leagueData);
    // echo count($leagueData);
}
