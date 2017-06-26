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
                'text' => '
                Hi, I\'m Dota 2 Chat Wheel Sounds Bot,
                use /cw list for the list of sounds,
                use /cw {id} to make the bot send the sounds of specific sounds

                http://blablaba.com
                '
              )
            )
          ))
          break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
