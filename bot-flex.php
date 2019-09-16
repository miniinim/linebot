<?php

$API_URL        = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN   = 'f6QNtCLKjvG2f2VPU2Z2rsHi8ESXW/Uq1HQiYTFvrtnG51y70T+gYhF0h7oKMcAciTvRTo4nmYFqobRDMYhxdPILlW6eJmnKOgReCAIrTM4SMvBP+dIbjZrwnAr4gnRmxttnrzL4/TfyYOG09RaV4wdB04t89/1O/w1cDnyilFU=';
$channelSecret  = 'd971cc07e553dd232e5deecaab0a2982';
$POST_HEADER    = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$data =
[
  'notificationDisabled' => false,
  'to'        => "U7e31a728502ad029ba23f1b6d21a7537",
  'messages'  =>
  [
    ['type' => 'text', 'text' => "บัญชีของคุณได้รับยอดโอน Cashback รอบประจำวันที่ 1 ก.ย. 2562 - 30 ก.ย. 2562" ],
    ['type' => 'text', 'text' => "เป็นเงิน 1,000,000 บาท" ],
    ['type' => 'sticker','packageId' => "11537",'stickerId' => "52002759" ],
    /*['type' => 'image','originalContentUrl' => "https://mokmoon.com/images/LINEDevelopers.png",'previewImageUrl' => "https://mokmoon.com/images/LINEDEV.png" ],
    ['type' => 'video','originalContentUrl' => "https://mokmoon.com/videos/Brown.mp4",'previewImageUrl' => "https://linefriends.com/img/bangolufsen/img_og.jpg" ],
    ['type' => 'location','title' => "LINE Company (Thailand) Limited",'address' => "127 อาคารเกษรทาวเวอร์ ชั้น17 ถ.ราชดำริ แขวงลุมพินี เขตปทุมวัน กรุงเทพฯ 10330",'latitude' => "13.7460089",'longitude' => "100.5386192" ]*/
  ]
];

$post_body    = json_encode($data, JSON_UNESCAPED_UNICODE);
$send_result  = send_reply_message($API_URL.'/push', $POST_HEADER, $post_body);

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
