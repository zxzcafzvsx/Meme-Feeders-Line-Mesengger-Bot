<?php
error_reporting(E_ALL);
$memes = parseMemes(getMemes());

print_r($memes[0]);
print_r($memes[1]);


function getMemes(){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    // CURLOPT_URL => "https://api.imgur.com/3/gallery/hot/top/week/" . rand(1,10) . "?showViral=true&mature=true",
    CURLOPT_URL => "https://api.imgur.com/3/gallery/hot/top/week/1?showViral=true&mature=true",
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
  $data = json_decode($response, true)['data'];
  $count = count($data);
  $pick = rand(1, $count);
  $isNotImg = true;
  $img = $data[$pick];

  if($count > 0){
    while($isNotImg){
      $pick = rand(1, $count);
      $img = $data[$pick];

      error_log("Output Number was " . $pick);
      if(array_key_exists('images', $img) || preg_match("/(.gif|.jpg|.png)/i", $img['link'])){
        $isNotImg = false;
        break;
        error_log("IMAGES KEY FOUNDEEEEDD");
      }
    }

    if(array_key_exists('images', $img)){
      $link = str_replace('http','https', $img['images'][0]['link']);
      $link = explode(".", $link);
      $thumb = $link;
      $ori = $link;

      $thumb = $thumb[2] . "s";
      $ori = $ori[2] . "b";

      $thumb = implode('.', $thumb);
      $ori = implode('.', $ori);
      $link = array($thumb, $ori);

      return $link;
    } else {
      $link = str_replace('http','https', $img['link']);
      $link = explode(".", $link);
      $thumb = $link;
      $ori = $link;

      $thumb = $thumb[2] . "s";
      $ori = $ori[2] . "b";

      $thumb = implode('.', $thumb);
      $ori = implode('.', $ori);
      $link = array($thumb, $ori);

      return $link;
    }

  } else {
    return "ERROR BRO";
    error_log($data);
  }

}
