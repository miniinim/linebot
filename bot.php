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
          		//----------------------------- ตรวจสอบข้อมูล ---------------------
              $test_connect = api_connect("GET","/authen/detail/" . $userID,"");
              if($test_connect['ini'] == "true")
              {
                $reply_text   = "ข้อมูลส่วนตัวของสมาชิก \nชื่อตัวแทน : {$test_connect['member']['mem_firstname']} {$test_connect['member']['mem_lastname']} \nรหัสนักธุรกิจ : {$test_connect['member']['mem_code']} \nอีเมล์ : {$test_connect['member']['mem_email']} \nโทร : {$test_connect['member']['mem_phone']}";
                //Output ---------------------------------------------------------
                $data =
                [
                  'replyToken' => $reply_token,
                  'messages' => [['type' => 'text', 'text' => $reply_text ]]
                ];
              }
              else if($test_connect['ini'] == "false")
              {
                //Output -------------------------------------------------------
                $data =
                [
                  'replyToken' => $reply_token,
                  'messages' =>
                  [
                    [
                      'type' => 'text',
                      'text' => "บัญชี Line ของคุณยังไม่ผ่านการผูกบัญชี Confideen Family ต้องการผูกบัญชี กรุณาตอบกลับข้อความนี้ด้วยคำสั่ง \"ผูกบัญชี\"",
                      'quickReply' =>
                      [
                        'items' =>
                        [
                          [
                            'type' => 'action',
                            'action' =>
                            [
                              'type' => 'message',
                              'label' => 'ผูกบัญชี Confideen',
                              'text' => 'ผูกบัญชี',
                            ]
                          ],
                          [
                            'type' => 'action',
                            'action' =>
                            [
                              'type' => 'message',
                              'label' => 'ลองอีกครั้ง',
                              'text' => 'ข้อมูลสมาชิก',
                            ]
                          ]

                        ]
                      ]
                    ]
                  ]
                ];
              }
            break;

            case "ผูกบัญชี" :
            case "Link" :
        		  //----------------------------- ตรวจสอบข้อมูล ---------------------
              $test_connect = api_connect("GET","/authen/connect/" . $userID,"");
              // บันทึกเหตุการณ์ล่าสุดว่าขอผูกบัญชี
              if($test_connect['ini'] == "false")
              {
                $message_text = $test_connect['return'];
              }
              else
              {
                $message_text = "กรอกหมายเลขโทรศัพท์ที่คุณลงทะเบียนไว้กับ Confideen Family ค่ะ";
              }
              $data =
              [
                'replyToken' => $reply_token,
                'messages' => [['type' => 'text', 'text' => $message_text ]]
              ];
            break;

            case "ลืมรหัสผ่าน" :
            case "Password" :
        		  //----------------------------- ตรวจสอบข้อมูล ---------------------
              // บันทึกเหตุการณ์ล่าสุดว่าขอเปลี่ยนรหัสผ่าน
              $data =
              [
                'replyToken' => $reply_token,
                'messages' => [['type' => 'text', 'text' => "กรอกหมายเลขโทรศัพท์ที่คุณลงทะเบียนไว้กับ Confideen Family ค่ะ" ]]
              ];
            break;

            case "หมายเลขพัสดุ" :
            case "Tracking" :
        		  //----------------------------- ตรวจสอบข้อมูล ---------------------
              // บันทึกเหตุการณ์ล่าสุดว่าขอเลข Tracking Number
              $data =
              [
                'replyToken' => $reply_token,
                'messages' => [['type' => 'text', 'text' => "กรอกหมายเลขโทรศัพท์ ของลูกค้าที่สั่งซื้อล่าสุดค่ะ" ]]
              ];
            break;

            case "Cashback" :
            case "cashback" :
            case "แคชแบค" :
            case "ยอดขาย" :

            //----------------------------- ตรวจสอบข้อมูล ---------------------
            $test_connect = api_connect("GET","/authen/detail/" . $userID,"");

            if($test_connect['ini'] == "true")
            {
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
            }
            else if($test_connect['ini'] == "false")
            {
              //Output -------------------------------------------------------
              $data =
              [
                'replyToken' => $reply_token,
                'messages' =>
                [
                  [
                    'type' => 'text',
                    'text' => "บัญชี Line ของคุณยังไม่ผ่านการผูกบัญชี Confideen Family ต้องการผูกบัญชี กรุณาตอบกลับข้อความนี้ด้วยคำสั่ง \"ผูกบัญชี\"",
                    'quickReply' =>
                    [
                      'items' =>
                      [
                        [
                          'type' => 'action',
                          'action' =>
                          [
                            'type' => 'message',
                            'label' => 'ผูกบัญชี Confideen',
                            'text' => 'ผูกบัญชี',
                          ]
                        ],
                        [
                          'type' => 'action',
                          'action' =>
                          [
                            'type' => 'message',
                            'label' => 'ลองอีกครั้ง',
                            'text' => 'ข้อมูลสมาชิก',
                          ]
                        ]

                      ]
                    ]
                  ]
                ]
              ];
            }

            break;

            case "PV" :
            case "pv" :
            case "Pv" :
            case "พีวี" :
            case "โบนัส" :
            case "คะแนนธุรกิจ" :

            //----------------------------- ตรวจสอบข้อมูล ---------------------
            $test_connect = api_connect("GET","/authen/detail/" . $userID,"");

            if($test_connect['ini'] == "true")
            {
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
            }
            else if($test_connect['ini'] == "false")
            {
              //Output -------------------------------------------------------
              $data =
              [
                'replyToken' => $reply_token,
                'messages' =>
                [
                  [
                    'type' => 'text',
                    'text' => "บัญชี Line ของคุณยังไม่ผ่านการผูกบัญชี Confideen Family ต้องการผูกบัญชี กรุณาตอบกลับข้อความนี้ด้วยคำสั่ง \"ผูกบัญชี\"",
                    'quickReply' =>
                    [
                      'items' =>
                      [
                        [
                          'type' => 'action',
                          'action' =>
                          [
                            'type' => 'message',
                            'label' => 'ผูกบัญชี Confideen',
                            'text' => 'ผูกบัญชี',
                          ]
                        ],
                        [
                          'type' => 'action',
                          'action' =>
                          [
                            'type' => 'message',
                            'label' => 'ลองอีกครั้ง',
                            'text' => 'ข้อมูลสมาชิก',
                          ]
                        ]

                      ]
                    ]
                  ]
                ]
              ];
            }

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

              //-------------------------------------
              //ตรวจสอบ Last Event ว่าดำเนินการอะไรค้างอยู่
              //-------------------------------------

              //ผูกบัญชี ------------------------------

              $check_log_connect = api_connect("GET","/authen/logs/" . $userID,"");

              // บันทึกเหตุการณ์ล่าสุดว่าขอผูกบัญชี
              $logs_action = $check_log_connect['action'];

              switch ($logs_action)
              {
                case "connect":

                $phone        = $text;
                $mobile_valid = preg_match('/^[0-9]{10}+$/', $phone);

                if($mobile_valid)
                {
                  $check_log_connect = api_connect("GET","/authen/request-otp/" . $userID . "/" . $phone,"");

                  if($check_log_connect['ini'] == "true")
                  {
                    $data =
                    [
                      'replyToken' => $reply_token,
                      'messages' => [['type' => 'text', 'text' => "เพื่อยืนยันตัวตนของคุณ ระบบได้จัดส่งรหัส OTP ไปที่เบอร์โทรนี้ กรุณากรอกรหัส OTP 6 หลักที่ได้รับจาก SMS ค่ะ" ]]
                    ];
                  }
                  else
                  {
                    $data =
                    [
                      'replyToken' => $reply_token,
                      'messages' => [['type' => 'text', 'text' => $check_log_connect['return'] ]]
                    ];
                  }

                }
                else
                {
                  $data =
                  [
                    'replyToken' => $reply_token,
                    'messages' => [['type' => 'text', 'text' => "เบอร์ไม่ถูกต้อง" ]]
                  ];
                }

                break;

                case "send-otp":

                $otp       = $text;
                $otp_valid = preg_match('/^[0-9]{6}+$/', $otp);

                if($otp_valid)
                {
                  $check_log_connect = api_connect("GET","/authen/check-otp/" . $userID . "/" . $otp,"");

                  if($check_log_connect['ini'] == "true")
                  {
                    $data =
                    [
                      'replyToken' => $reply_token,
                      'messages' =>
                      [
                        [
                          'type' => 'text',
                          'text' => $check_log_connect['return'],
                          'quickReply' =>
                          [
                            'items' =>
                            [
                              [
                                'type' => 'action',
                                'action' =>
                                [
                                  'type' => 'message',
                                  'label' => 'ดูข้อมูลสมาชิก',
                                  'text' => 'ข้อมูลสมาชิก',
                                ]
                              ],
                              [
                                'type' => 'action',
                                'action' =>
                                [
                                  'type' => 'message',
                                  'label' => 'ดูยอดขาย',
                                  'text' => 'ยอดขาย',
                                ]
                              ],
                              [
                                'type' => 'action',
                                'action' =>
                                [
                                  'type' => 'message',
                                  'label' => 'ดูโบนัสสายงาน',
                                  'text' => 'โบนัส',
                                ]
                              ],
                              [
                                'type' => 'action',
                                'action' =>
                                [
                                  'type' => 'message',
                                  'label' => 'ลืมรหัสผ่าน',
                                  'text' => 'ลืมรหัสผ่าน',
                                ]
                              ],
                            ]
                          ]
                        ]
                      ]
                    ];
                  }
                  else
                  {
                    $data =
                    [
                      'replyToken' => $reply_token,
                      'messages' => [['type' => 'text', 'text' => $check_log_connect['return'] ]]
                    ];
                  }

                }
                else
                {
                  $data =
                  [
                    'replyToken' => $reply_token,
                    'messages' => [['type' => 'text', 'text' => "เบอร์ไม่ถูกต้อง" ]]
                  ];
                }

                break;

                default:
    						//------------------ RETURN ERROR -----------------

                $url      = 'https://api.line.me/v2/bot/profile/' . $userID;
                $request  = getProfile($url, $POST_HEADER);
                $profile  = json_decode($request, true);
                $encode   = strtr(base64_encode($text), '+/', '-_');
                $connect  = api_connect("GET","/authen/chat/" . $userID . "/" . $encode . "/" . $profile['displayName'] . "/" . $profile['pictureUrl'], "");

                if($connect['ini'] == "true")
                {
                  $message_text = $connect['return'];
                  $data =
                  [
                    'replyToken' => $reply_token,
                    //'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  //Debug Detail message
                    //'messages' => [['type' => 'text', 'text' => $text ]]
                    'messages' => [['type' => 'text', 'text' => $message_text ]]
                  ];
                }
                else if($connect['ini'] == "false")
                {
                  $message_text = $connect['return'];
                  $data =
                  [
                    'replyToken' => $reply_token,
                    //'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  //Debug Detail message
                    //'messages' => [['type' => 'text', 'text' => $text ]]
                    'messages' => [['type' => 'text', 'text' => $message_text ]]
                  ];
                }

              }

              //ส่งเบอร์ - Link
              //ส่ง OTP - Link

              //ลืมรหัสผ่าน ----------------------------
              //ส่งเบอร์ - Forgot
              //ส่ง OTP - Forgot

              //ขอ Tracking Number ------------------
              //ส่งเบอร์ - Tracking
              //ส่ง OTP - Tracking

            break;
        }

        $post_body    = json_encode($data, JSON_UNESCAPED_UNICODE);
        $send_result  = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

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

function getProfile($url, $post_header)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}


function api_connect($get, $call, $data)
{
	$apiKey 	  = "8rMz65o3D0E";
	$secretKey  = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNAD";
  $url        = "https://family.confideen.com/api" . $call;

	switch ($get)
	{
		case "GET": // เรียกข้อมูล

			//------------------------- API -------------------------------------------
			$header = array();
			$header[] = 'Content-length: 0';
			$header[] = 'Content-type: application/json;charset=utf-8';
			$header[] = "api-key: {$apiKey}";
			$header[] = "secret-key: {$secretKey}";
			//------------------------- Return -------------------------------------------
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$response_json = curl_exec($ch);
			curl_close($ch);
			//------------------------- Return -------------------------------------------
			//$output = json_decode($response_json, true);
			$output = unserialize(base64_decode($response_json));
			//-------------------------------------------------------------------------------
			//------------------------- Return -------------------------------------------
			return $output;

		break;

		case "POST": // เพิ่มข้อมูล
			//------------------------- API -------------------------------------------

			$data_json = json_encode($data);

			$header = array();
			$header[] = 'Content-type: application/json';
			$header[] = 'Content-Length: ' . strlen($data_json);
			$header[] = "api-key: {$apiKey}";
			$header[] = "secret-key: {$secretKey}";
			//------------------------- API -------------------------------------------
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'ecdhe_ecdsa_aes_256_sha');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$response_json = curl_exec($ch);
			curl_close($ch);
			//------------------------- Return -------------------------------------------
      //$output = json_decode($response_json, true);
			$output = unserialize(base64_decode($response_json));
			//-------------------------------------------------------------------------------
			//------------------------- Return -------------------------------------------
			return $output;
		break;

	}
}

?>
