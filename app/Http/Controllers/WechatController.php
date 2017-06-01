<?php

namespace App\Http\Controllers;

use App\Facades\Http;
use Illuminate\Http\Request;
use LSS\XML2Array;

class WechatController extends Controller
{
    private function checkSignature($request)
    {
        $signature = $request->input("signature");
        $timestamp = $request->input("timestamp");
        $nonce = $request->input("nonce");

        $token = 'A6ovLloGP6939IKgCENEcF2piDW8KZuk';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function init(Request $request){

        $wechat = resolve('Wechat');
        $tuling = resolve('Tuling');

        $xml = $request->getContent();
        $msgInfo = $wechat->getMsgContent($xml);

        if($msgInfo['MsgType'] == 'text'){
            $re = $tuling->getContent($msgInfo['Content'], $msgInfo['FromUserName']);
            \Log::info('tuling return|'.json_encode($re));
            if($re === false){
//                echo $tuling->getError();
                $wechat->replyMessage('text', $msgInfo['FromUserName'], $msgInfo['ToUserName'], $tuling->getError());
            }else{
                $wechat->replyMessage('text', $msgInfo['FromUserName'], $msgInfo['ToUserName'], $re['massage']);
            }
        }
//        $menu = $wechat->getMenu();
//        print_r($menu);exit;

        if($this->checkSignature($request) == true){
            echo $request->input('echostr');exit;
        }
    }
}
