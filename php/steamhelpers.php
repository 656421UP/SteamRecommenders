<?php

function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function getUser($steamId){
    $apikey = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $response = file_get_contents_curl('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$apikey.'&steamids='.$steamId.'&format=json');
    // echo 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$apikey.'&steamids='.$steamId.'&format=json';
    // $response = json_decode($response, false);
    return $response;
}

function getFriendsList($steamId){
    $apikey = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $friendList = file_get_contents_curl('http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key='.$apikey.'&steamid='.$steamId.'relationship=friend&format=json');
    // print_r($friendList);
    // return $friendList;
    $friendList = json_decode($friendList, false);
    // echo 'http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key='.$apikey.'&steamid='.$steamId.'relationship=friend&format=json';
    $friendList = $friendList->friendslist->friends;
    $friendsIds = '';

    foreach($friendList as $key => $value){
        if($key == 0){
            $friendsIds .= $value->steamid;
        }else{
            $friendsIds .= ','.$value->steamid;
        }
    }
    $response = getUser($friendsIds);
    return $response;
}

?>
