<?php
/**
 * Created by PhpStorm.
 * User: zhaojipeng
 * Date: 17/5/27
 * Time: 16:12
 */

namespace App\Repositories;

use App\Facades\Http;

class Tuling
{
    const APPKEY = '25a790a4b22744c9b2b6c8a4bcc41d4f';
    const TULING_HOST = 'http://www.tuling123.com/openapi/api';

    private $error = '';
    private $success_code = ['100000', '200000', '302000', '308000', '313000', '314000'];

    public function getError()
    {
        return $this->error;
    }

    public function getContent($text, $userId)
    {
        $returnData = [];
        $postData = [
            'userid' => $userId,
            'info' => $text,
            'key' => self::APPKEY,
        ];

        $re = $this->_query($postData);

        if($re ===  false){
            return false;
        }

        switch ($re['code']){
            case '100000':
                $returnData = [
                    'type' => 'text',
                    'massage' => $re['text']
                ];
                break;
            case '200000':
                $returnData = [
                    'type' => 'url',
                    'massage' => $re['text'].'<a href="'.$re['url'].'">点这里查看</a>',
                ];
        }

        $returnData['code'] = 1000;

        return $returnData;
    }

    private function _query($data = [])
    {
        $url = self::TULING_HOST;

        //请求类型
        $re = Http::request('POST', $url, ['json' => $data]);

        //处理请求结果
        if ($re->getStatusCode() != 200) {
            $this->error = '请求失败|http code:' . $re->getStatusCode();
            return false;
        }

        $re = json_decode($re->getBody(), true);

        if ($re === false) {
            $this->error = '数据解析失败';
            return false;
        }

        if (isset($re['code']) === true && in_array($re['code'], $this->success_code) === false) {
            $this->error = '请求失败|' . $re['code'] . ':' . $re['text'];
            return false;
        }

        return $re;
    }
}