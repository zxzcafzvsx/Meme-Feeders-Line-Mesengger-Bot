<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = 'EimjYrf1GS6FS/5QEk7puuvsBChbdnV7UYlgEBED1zR1xqMe6HvD8L7NORVBCxlbZjBBQ+s3MAQwbGcknV1yagHcoRw9ehjFtgF9lxNoC3N/VrpSYTACFDmgb5IZU27WjlMbySRs58LGH90SLzwJWgdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'fb4467f294d0eff83fdbaed08ed146fc';

$sounds = ['chatwheel_rimshot','chatwheel_charge','chatwheel_frog','chatwheel_crash_burn','crowd_lv_01'];

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    switch (strtolower($message['text'])) {
                      case '/cws list':
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'text',
                                    'text' => "Chat Wheel Sounds list\nid  - Sounds\n1  - Ba-dum tishh\n2  - Charge\n3  - Frog\n4  - Crash and burn\n5  - Applause\n6  - Sad trombone\n7  - Crickets\n8  - Drum roll\n9  - Headshake\n10 - Crybaby\n11 - Patience from Zhou\n12 - 玩不了啦!\n13 - Боже, ты посмотри вокруг, что происходит!\n14 - Waow\n15 - 破两路更好打, 是吧?\n16 - Жил до конца, умер как герой\n17 - They're all dead!\n18 - 天火!\n19 - Ай-ай-ай-ай-ай, что сейчас произошло!\n20 - Brutal. Savage. Rekt.\n21 - 加油!\n22 - Это ГГ\n23 - It's a disastah!\n24 - 走好, 不送\n25 - Это. Просто. Нечто.
                                    "
                                )
                            )
                        ));
                        break;
                      case 'memes!':
                        $memes = getImage(getMemes());
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    // 'type' => 'image',
                                    // "originalContentUrl": "",
                                    // "previewImageUrl": ""
                                    'type' => 'image',
                                    "originalContentUrl" => $memes[1],
                                    "previewImageUrl" => $memes[0]
                                )
                            )
                        ));
                        break;
                      default:
                        $expMsg = explode(" ",  $message['text']);
                        if($expMsg[0] == "/cws"){
                            $soundId = $expMsg[1] -1 || 0;
                            $client->replyMessage(array(
                                'replyToken' => $event['replyToken'],
                                'messages' => array(
                                    array(
                                        "type" => "audio",
                                        "originalContentUrl" => "https://powerful-spire-57573.herokuapp.com/sounds/" . $sounds[$id] . ".m4a",
                                        "duration" => 3000
                                    )
                                )
                            ));
                        } else {
                            $client->replyMessage(array(
                                'replyToken' => $event['replyToken'],
                                'messages' => array(
                                    array(
                                        'type' => 'text',
                                        'text' => $event['source']['userId']
                                    )
                                )
                            ));
                            break;
                        }
                    }
                    break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        case 'join':
            $memes = getImage(getMemes());
            $client->replyMessage(array(
                'replyToken' => $event['replyToken'],
                'messages' => array(
                    array(
                        // 'type' => 'image',
                        // "originalContentUrl": "",
                        // "previewImageUrl": ""
                        'type' => 'image',
                        "originalContentUrl" => $memes[1],
                        "previewImageUrl" => $memes[0]
                    ),
                    array(
                        'type' => 'text',
                        'text' => "Type 'memes!'' for memes"
                    )
                )
            ));
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};


function getMemes(){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.imgur.com/3/gallery/search/top/week/".rand(1,10)."?q=meme",
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
    // CURLOPT_URL => "https://api.imgur.com/3/gallery/hot/top/week/" . rand(1,10) . "?showViral=true&mature=true",
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
