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
                      case '/cw list':
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'text',
                                    'text' => "Chat Wheel Sounds list
                                    \n  BP Level  | id - Sounds
                                    \n    26      | 1  - Ba-dum tishh
                                    \n    26      | 2  - Charge
                                    \n    26      | 3  - Frog
                                    \n    26      | 4  - Crash and burn
                                    \n    26      | 5  - Applause
                                    \n    107     | 6  - Sad trombone
                                    \n    107     | 7  - Crickets
                                    \n    107     | 8  - Drum roll
                                    \n    107     | 9  - Headshake
                                    \n    107     | 10 - Crybaby
                                    \n    157     | 11 - Patience from Zhou
                                    \n    157     | 12 - 玩不了啦!
                                    \n    157     | 13 - Боже, ты посмотри вокруг, что происходит!
                                    \n    207     | 14 - Waow
                                    \n    207     | 14 - 破两路更好打, 是吧?
                                    \n    207     | 14 - Жил до конца, умер как герой
                                    \n    257     | 14 - They're all dead!
                                    \n    257     | 14 - 天火!
                                    \n    257     | 14 - Ай-ай-ай-ай-ай, что сейчас произошло!
                                    \n    307     | 14 - Brutal. Savage. Rekt.
                                    \n    307     | 14 - 加油!
                                    \n    307     | 14 - Это ГГ
                                    \n    357     | 14 - It's a disastah!
                                    \n    357     | 14 - 走好, 不送
                                    \n    357     | 14 - Это. Просто. Нечто.
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
