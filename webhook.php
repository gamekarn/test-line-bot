<?php
function replyMsg($arrayHeader,$arrayPostData){

    $accessToken = "5VaSb6IxNjTuQdpvJ/y1hg2klEtcrjO7ngO/AI5QtqBq4MkQ9K913lTpLgUYMMuxIwGkk/uX/e/Zp3Msk0AtdQYmN2/SThCHbgt4EqwamkwB2GHvdHeinI52uRNEOopE/DSwf4Rc6p7O6Qa8CALGewdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่

    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
`
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
?>