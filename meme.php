<?php

error_reporting(E_ALL);
require_once('./callback/functions.php');
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
