<?php

namespace App\Http\Controllers;

use App\Facades\Http;
use Illuminate\Http\Request;

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
        $menu = $wechat->getMenu();
        print_r($menu);exit;

        if($this->checkSignature($request) == true){
            echo $request->input('echostr');exit;
        }


    }
}
