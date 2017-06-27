<?php
error_reporting(E_ALL); 
$memes = parseMemes(getMemes());

echo $memes;


function getMemes(){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.imgur.com/3/gallery/hot/top/week/" . rand(1,10) . "?showViral=true&mature=true",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "authorization: Client-ID 715e186f0ee257f"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    error_log("cURL Error #:" . $err);
  } else {
    return $response;
  }
}

function parseMemes($response){
  $data = json_decode($response)->data;
  $count = count($data);
  $pick = rand(1, $count);

  if($count > 0){
    return $data[$pick]->images[0]->link;
  } else {
    return "ERROR BRO";
    error_log($data);
  }

}
