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

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    switch ($message['text']) {
                      case '/cws list':
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'text',
                                    'text' => "Chat Wheel Sounds list\n
                                    id - Sounds
                                    1  - Ba-dum tishh
                                    2  - Charge
                                    3  - Frog
                                    4  - Crash and burn
                                    5  - Applause
                                    6  - Sad trombone
                                    7  - Crickets
                                    8  - Drum roll
                                    9  - Headshake
                                    10 - Crybaby
                                    11 - Patience from Zhou
                                    12 - 玩不了啦!
                                    13 - Боже, ты посмотри вокруг, что происходит!
                                    14 - Waow
                                    15 - 破两路更好打, 是吧?
                                    16 - Жил до конца, умер как герой
                                    17 - They're all dead!
                                    18 - 天火!
                                    19 - Ай-ай-ай-ай-ай, что сейчас произошло!
                                    20 - Brutal. Savage. Rekt.
                                    21 - 加油!
                                    22 - Это ГГ
                                    23 - It's a disastah!
                                    24 - 走好, 不送
                                    25 - Это. Просто. Нечто.
                                    "
                                )
                            )
                        ));
                        break;

                      default:
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'text',
                                    'text' => $message['text']
                                )
                            )
                        ));
                        break;
                    }
                    break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        case 'join':
            $client->replyMessage(array(
              'replyToken' => $event['replyToken'],
              'messages' => array(
                array(
                  'type' => 'text',
                  'text' => "Hi, I\'m Dota 2 Chat Wheel Sounds Bot, \nuse /cw list for the list of sounds, \nuse /cw {id} to make the bot send the sounds of specific sounds
                  \n \nhttp://blablaba.com"
                )
              )
            ));
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
