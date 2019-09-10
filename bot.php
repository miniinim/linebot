<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'f6QNtCLKjvG2f2VPU2Z2rsHi8ESXW/Uq1HQiYTFvrtnG51y70T+gYhF0h7oKMcAciTvRTo4nmYFqobRDMYhxdPILlW6eJmnKOgReCAIrTM4SMvBP+dIbjZrwnAr4gnRmxttnrzL4/TfyYOG09RaV4wdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'd971cc07e553dd232e5deecaab0a2982';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array



if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {

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

            break;

            case "Cashback" :
            case "cashback" :
            case "แคชแบค" :
            case "ยอดขาย" :

            $reply_text = "รายได้จากยอดธุรกิจส่วนตัว \nยอดขาย : 150,000 บาท \nCashback : 15,000 บาท \nยอดขายระหว่างวันที่ 11 ส.ค. 2562 - 10 ก.ย. 2562";

            break;

            case "PV" :
            case "pv" :
            case "Pv" :
            case "พีวี" :
            case "โบนัส" :
            case "โบนัส" :

            $reply_text = "รายได้จากการพัฒนาสายงาน \nคะแนนธุรกิจ : 150,000 PV \nPersonal Bonus : 5,000 PV \nยอดขายระหว่างวันที่ 11 ส.ค. 2562 - 10 ก.ย. 2562";

            break;

            case "Help":
            case "help":
            case "ช่วย":
            case "ช่วยเหลือ" :

            $reply_text = "คำสั่งที่สามารถใช้ได้คือ \n1. Detail สำหรับเรียกข้อมููลส่วนตัว \n2. Cashback สำหรับเรียกคะแนนยอดขาย Cashback \n3. PV สำหรับเรียกคะแนนโบนัสสายงาน (PV)";

            break;

            default:

              $reply_text = "ไม่เข้าใจคำถามของคุณ พิมพ์ Help/ช่วยเหลือ เพื่อดูคำสั่งที่สามารถใช้งานได้";

            break;
        }

        $data = [
            'replyToken' => $reply_token,
            //'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  //Debug Detail message
            //'messages' => [['type' => 'text', 'text' => $text ]]
            'messages' => [['type' => 'text', 'text' => $reply_text ]]
        ];
        $post_body    = json_encode($data, JSON_UNESCAPED_UNICODE);
        $send_result  = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";

        $arrayPostData['to'] = $userID;
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "2";
        $arrayPostData['messages'][1]['stickerId'] = "34";
        pushMsg($post_header,$arrayPostData);
    }
}

echo "OK";


function pushMsg($arrayHeader,$arrayPostData)
{
  $strUrl = "https://api.line.me/v2/bot/message/push";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$strUrl);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close ($ch);
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

?>
