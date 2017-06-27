<?php

error_reporting(E_ALL);
$memes = getImage(getMemes());

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Meme Feeders</title>
     <!-- Compiled and minified CSS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js"></script>

  </head>
  <body>
     <div class="row">
        <div class="col s12 m4 offset-m4">
          <div class="card">
            <div class="card-image">
              <img src="<?php print_r($memes[1]); ?>" class="materialboxed">
            </div>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function(){
          $('.materialboxed').materialbox();
        });
      </script>
  </body>
</html>

<?php

function getMemes(){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.imgur.com/3/gallery/search/top/month/".rand(1,10)."?q=meme",
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

function getImage($response){
    $data = json_decode($response, true)['data'];
    $count = count($data);
    $pick = rand(1, $count);
    $img = $data[$pick];
    $id = $img['cover'];

    $image = json_decode(curlImage($id), true)['data']['link'];

    $link = str_replace('http','https', $image);
    $link = explode(".", $link);
    $thumb = $link;
    $ori = $link;

    $thumb[2] = $thumb[2] . "t";
    $ori[2] = $ori[2] . "m";

    $thumb = implode('.', $thumb);
    $ori = implode('.', $ori);
    $link = array($thumb, $ori);

    return $link;

}

function curlImage($id){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.imgur.com/3/image/".$id,
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
