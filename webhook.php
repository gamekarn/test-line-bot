<?php
    $accessToken = "5VaSb6IxNjTuQdpvJ/y1hg2klEtcrjO7ngO/AI5QtqBq4MkQ9K913lTpLgUYMMuxIwGkk/uX/e/Zp3Msk0AtdQYmN2/SThCHbgt4EqwamkwB2GHvdHeinI52uRNEOopE/DSwf4Rc6p7O6Qa8CALGewdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    
    //รับข้อความจากผู้ใช้
    $message = $arrayJson['events'][0]['message']['text'];
    $messageType = $arrayJson['events'][0]['message']['type'];

#ตัวอย่าง Message Type "Text"
    if($message == "สวัสดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Sticker"
    else if($message == "ฝันดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "sticker";
        $arrayPostData['messages'][0]['packageId'] = "2";
        $arrayPostData['messages'][0]['stickerId'] = "46";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Image"
    else if($message == "รูปน้องแมว"){
        $image_url = "https://i.pinimg.com/originals/cc/22/d1/cc22d10d9096e70fe3dbe3be2630182b.jpg";
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "image";
        $arrayPostData['messages'][0]['originalContentUrl'] = $image_url;
        $arrayPostData['messages'][0]['previewImageUrl'] = $image_url;
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Location"
    else if($message == "พิกัดสยามพารากอน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "location";
        $arrayPostData['messages'][0]['title'] = "สยามพารากอน";
        $arrayPostData['messages'][0]['address'] =   "13.7465354,100.532752";
        $arrayPostData['messages'][0]['latitude'] = "13.7465354";
        $arrayPostData['messages'][0]['longitude'] = "100.532752";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Text + Sticker ใน 1 ครั้ง"
    else if($message == "ลาก่อน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "อย่าทิ้งกันไป";
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "1";
        $arrayPostData['messages'][1]['stickerId'] = "131";
        replyMsg($arrayHeader,$arrayPostData);
    }

    else if($message == "555"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "ถถถ";
        replyMsg($arrayHeader,$arrayPostData);
    }
    
    if ($messageType == "location"){
        $math = $math.random_int(0,19);
        $myLat = $arrayJson['events'][0]['message']['latitude'];    
        $myLon = $arrayJson['events'][0]['message']['longitude'];    
    
        $jsonRest = json_decode(getRest($myLat,$myLon), true);

        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = 'ชื่อร้าน: ' 
        . $jsonRest['page']['first']. "\n". 'https://www.wongnai.com/'
        . $jsonRest['page']['entities'][$math]['shortUrl'];
        //$arrayPostData['messages'][0]['text'] = $myLat . $myLon;
    
        replyMsg($arrayHeader,$arrayPostData);
    }

    // if ($messageType == "location"){
    //     $myLat = $arrayJson['events'][0]['message']['latitude'];    
    //     $myLon = $arrayJson['events'][0]['message']['longitude'];    
    
    //     $jsonAQI = json_decode(getAQI($myLat,$myLon), true);

    //     $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    //     $arrayPostData['messages'][0]['type'] = "text";
    //     $arrayPostData['messages'][0]['text'] = 'Nearest AQI : ' . $jsonAQI['data']['state'] . ' is ' . '[' . $jsonAQI['data']['current']['pollution']['aqius'] . ']';
    //     $arrayPostData['messages'][1]['type'] = "text";
    //     $arrayPostData['messages'][1]['text'] = 'Nearest TP : ' . $jsonAQI['data']['state'] . ' is ' . '[' . $jsonAQI['data']['current']['weather']['tp'] . ']';
    //     //$arrayPostData['messages'][0]['text'] = $myLat . $myLon;
    
    //     replyMsg($arrayHeader,$arrayPostData);
    // }

    if($message == "สุ่มสติ๊กเกอร์"){
        $math = (string)$math.random_int(1,150);
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "sticker";
        $arrayPostData['messages'][0]['packageId'] = "2";
        $arrayPostData['messages'][0]['stickerId'] = $math;
        $arrayPostData['messages'][1]['type'] = "text";
        $arrayPostData['messages'][1]['text'] = $math;
        replyMsg($arrayHeader,$arrayPostData);
    }

    if($message == "ราคาทอง") {
        $jsonInfoGold = json_decode(getInfoGold(),true);
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = 'ราคาทองตอนนี้ ' .$jsonInfoGold[1]["bid"]. ' บาท';
        //$arrayPostData['messages'][0]['text'] = 'ราคาทองตอนนี้ ' . getInfoGold()[87] .getInfoGold()[88].getInfoGold()[89].getInfoGold()[90].getInfoGold()[91].getInfoGold()[92].getInfoGold()[93].' บาท' ;
        replyMsg($arrayHeader,$arrayPostData);
    }

function replyMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }

    function getAQI($currentLat,$currentLon){
        echo $currentLat;
        echo $currentLon;
        // api.airvisual.com/v2/nearest_city?lat={{LATITUDE}}&lon={{LONGITUDE}}&key={{YOUR_API_KEY}}
        $strUrl = "http://api.airvisual.com/v2/nearest_city?lat=$currentLat&lon=$currentLon&key=5uE3y4hLFGFbDmfto";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_GET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
        return $result;
    }

    function getRest($currentLat,$currentLon){
        echo $currentLat;
        echo $currentLon;
        $math = (string)$math.random_int(1,3);
        $strUrl = "https://www.wongnai.com/_api/v1.5/businesses?_t=json&domain=1&spatialInfo.coordinate.latitude=$currentLat&spatialInfo.radius=1.0&spatialInfo.coordinate.longitude=$currentLon&rerank=true&features.foodOrder=true&page.number=$math";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_GET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
        return $result;
    }

    function getInfoGold(){
        // api.airvisual.com/v2/nearest_city?lat={{LATITUDE}}&lon={{LONGITUDE}}&key={{YOUR_API_KEY}}
        $strUrl = "http://www.thaigold.info/RealTimeDataV2/gtdata_.txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_GET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
        return $result;
    }
   exit;
?> 