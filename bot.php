<?php

$API_URL        = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN   = 'f6QNtCLKjvG2f2VPU2Z2rsHi8ESXW/Uq1HQiYTFvrtnG51y70T+gYhF0h7oKMcAciTvRTo4nmYFqobRDMYhxdPILlW6eJmnKOgReCAIrTM4SMvBP+dIbjZrwnAr4gnRmxttnrzL4/TfyYOG09RaV4wdB04t89/1O/w1cDnyilFU=';
$channelSecret  = 'd971cc07e553dd232e5deecaab0a2982';
$POST_HEADER    = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
$request        = file_get_contents('php://input');   // Get request content
$request_array  = json_decode($request, true);   // Decode JSON to Array


if ( sizeof($request_array['events']) > 0 )
{
    foreach ($request_array['events'] as $event)
    {
        $reply_message = '';
        $reply_token = $event['replyToken'];

        $text   = $event['message']['text'];
        $userID = $event['source']['userId'];

        //Api Member Check

        switch ($text)
        {
            case "Detail" :
            case "detail" :
            case "ข้อมูล" :
            case "ข้อมูลสมาชิก" :
            case "ประวัติ" :
            case "สมาชิก" :

            $reply_text = "ข้อมูลส่วนตัวของสมาชิก \nชื่อตัวแทน : Trainnee Account \nรหัสนักธุรกิจ : BC6201669 \nอีเมล์ : the.miniinim@gmail.com \nโทร : (095) 652-8573";

            $jsonFlex =
            [
              "type"        => "image",
              "url"         => "https://scdn.line-apps.com/n/channel_devcenter/img/flexsnapshot/clip/clip9.jpg",
              "size"        => "full",
              "aspectRatio" => "1.91:1"
            ];

            $data =
            [
              'replyToken'  => $reply_token,
              'messages'    => [$jsonFlex]
            ];

            break;

            case "Cashback" :
            case "cashback" :
            case "แคชแบค" :
            case "ยอดขาย" :

            $jsonFlex = [
                "type" => "flex",
                "altText" => "รายได้จากยอดธุรกิจส่วนตัว",
                "contents" => [
                  "type" => "bubble",
                  "direction" => "ltr",
                  "header" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => [
                      [
                        "type" => "text",
                        "text" => "รายได้จากยอดธุรกิจส่วนตัว",
                        "size" => "lg",
                        "align" => "start",
                        "weight" => "bold",
                        "color" => "#009813"
                      ],
                      [
                        "type" => "text",
                        "text" => "ยอดขาย",
                        "size" => "lg",
                        "weight" => "bold",
                        "color" => "#000000"
                      ],
                      [
                        "type" => "text",
                        "text" => "฿ 150,500.00",
                        "size" => "3xl",
                        "weight" => "bold",
                        "color" => "#000000"
                      ],
                      [
                        "type" => "text",
                        "text" => "ยอดขายระหว่างวันที่ 11 ส.ค. 2562 - 10 ก.ย. 2562",
                        "size" => "xs",
                        "color" => "#B2B2B2"
                      ],
                      [
                        "type" => "text",
                        "text" => "ยังไม่ถึงรอบจ่าย.",
                        "margin" => "lg",
                        "size" => "lg",
                        "color" => "#000000"
                      ]
                    ]
                  ],
                  "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => [
                      [
                        "type" => "separator",
                        "color" => "#C3C3C3"
                      ],
                      [
                        "type" => "box",
                        "layout" => "baseline",
                        "margin" => "lg",
                        "contents" => [
                          [
                            "type" => "text",
                            "text" => "Cashback",
                            "align" => "start",
                            "color" => "#C3C3C3"
                          ],
                          [
                            "type" => "text",
                            "text" => "฿ 500.00",
                            "align" => "end",
                            "color" => "#000000"
                          ]
                        ]
                      ],
                      [
                        "type" => "separator",
                        "margin" => "lg",
                        "color" => "#C3C3C3"
                      ]
                    ]
                  ],
                  "footer" => [
                    "type" => "box",
                    "layout" => "horizontal",
                    "contents" => [
                      [
                        "type" => "text",
                        "text" => "ดูข้อมุลทั้งหมด",
                        "size" => "lg",
                        "align" => "start",
                        "color" => "#0084B6",
                        "action" => [
                          "type" => "uri",
                          "label" => "ดูข้อมุลทั้งหมด",
                          "uri" => "https://family.confideen.com/"
                        ]
                      ]
                    ]
                  ]
                ]
              ];

              $data =
              [
                'replyToken'  => $reply_token,
                'messages'    => [$jsonFlex]
              ];

            break;

            case "PV" :
            case "pv" :
            case "Pv" :
            case "พีวี" :
            case "โบนัส" :
            case "คะแนนธุรกิจ" :

            //$reply_text = "รายได้จากการพัฒนาสายงาน \nคะแนนธุรกิจ : 150,000 PV \nPersonal Bonus : 5,000 PV \nยอดขายระหว่างวันที่ 11 ส.ค. 2562 - 10 ก.ย. 2562";

            $jsonFlex = [
                "type" => "flex",
                "altText" => "รายได้จากการพัฒนาสายงาน",
                "contents" => [
                  "type" => "bubble",
                  "direction" => "ltr",
                  "header" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => [
                      [
                        "type" => "text",
                        "text" => "รายได้จากการพัฒนาสายงาน",
                        "size" => "lg",
                        "align" => "start",
                        "weight" => "bold",
                        "color" => "#009813"
                      ],
                      [
                        "type" => "text",
                        "text" => "คะแนนธุรกิจ",
                        "size" => "lg",
                        "weight" => "bold",
                        "color" => "#000000"
                      ],
                      [
                        "type" => "text",
                        "text" => "PV 150,000.00",
                        "size" => "3xl",
                        "weight" => "bold",
                        "color" => "#000000"
                      ],
                      [
                        "type" => "text",
                        "text" => "ยอดขายระหว่างวันที่ 11 ส.ค. 2562 - 10 ก.ย. 2562",
                        "size" => "xs",
                        "color" => "#B2B2B2"
                      ],
                      [
                        "type" => "text",
                        "text" => "ยังไม่ถึงรอบจ่าย.",
                        "margin" => "lg",
                        "size" => "lg",
                        "color" => "#000000"
                      ]
                    ]
                  ],
                  "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => [
                      [
                        "type" => "separator",
                        "color" => "#C3C3C3"
                      ],
                      [
                        "type" => "box",
                        "layout" => "baseline",
                        "margin" => "lg",
                        "contents" => [
                          [
                            "type" => "text",
                            "text" => "Personal Bonus",
                            "align" => "start",
                            "color" => "#C3C3C3"
                          ],
                          [
                            "type" => "text",
                            "text" => "฿ 500.00",
                            "align" => "end",
                            "color" => "#000000"
                          ]
                        ]
                      ],
                      [
                        "type" => "box",
                        "layout" => "baseline",
                        "margin" => "lg",
                        "contents" => [
                          [
                            "type" => "text",
                            "text" => "Bonus (สายหลัก)",
                            "color" => "#C3C3C3"
                          ],
                          [
                            "type" => "text",
                            "text" => "฿ 500.00",
                            "align" => "end"
                          ]
                        ]
                      ],
                      [
                        "type" => "box",
                        "layout" => "baseline",
                        "margin" => "lg",
                        "contents" => [
                          [
                            "type" => "text",
                            "text" => "Bonus (สายรอง)",
                            "color" => "#C3C3C3"
                          ],
                          [
                            "type" => "text",
                            "text" => "฿ 250.00",
                            "align" => "end"
                          ]
                        ]
                      ],
                      [
                        "type" => "separator",
                        "margin" => "lg",
                        "color" => "#C3C3C3"
                      ]
                    ]
                  ],
                  "footer" => [
                    "type" => "box",
                    "layout" => "horizontal",
                    "contents" => [
                      [
                        "type" => "text",
                        "text" => "ดูข้อมุลทั้งหมด",
                        "size" => "lg",
                        "align" => "start",
                        "color" => "#0084B6",
                        "action" => [
                          "type" => "uri",
                          "label" => "ดูข้อมุลทั้งหมด",
                          "uri" => "https://family.confideen.com/"
                        ]
                      ]
                    ]
                  ]
                ]
              ];

              $data =
              [
                'replyToken'  => $reply_token,
                'messages'    => [$jsonFlex]
              ];

            break;

            case "Help":
            case "help":
            case "ช่วย":
            case "ช่วยเหลือ" :

            $reply_text = "คำสั่งที่สามารถใช้ได้คือ \n1. Detail สำหรับเรียกข้อมููลส่วนตัว \n2. Cashback สำหรับเรียกคะแนนยอดขาย Cashback \n3. PV สำหรับเรียกคะแนนโบนัสสายงาน (PV)";
            $data = [
                'replyToken' => $reply_token,
                //'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  //Debug Detail message
                //'messages' => [['type' => 'text', 'text' => $text ]]
                'messages' => [['type' => 'text', 'text' => $reply_text ]]
            ];

            break;

            default:

              $reply_text = "ไม่เข้าใจคำถามของคุณ พิมพ์ Help/ช่วยเหลือ เพื่อดูคำสั่งที่สามารถใช้งานได้";
              $data = [
                  'replyToken' => $reply_token,
                  //'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  //Debug Detail message
                  //'messages' => [['type' => 'text', 'text' => $text ]]
                  'messages' => [['type' => 'text', 'text' => $reply_text ]]
              ];

            break;
        }


        $post_body    = json_encode($data, JSON_UNESCAPED_UNICODE);
        $send_result  = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";


function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
