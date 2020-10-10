<?php

namespace App\Handlers;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class SlugTransHandler
{
    public function trans($str)
    {
        $key = config('services.baidu_trans.key');
        $secret = config('services.baidu_trans.secret');
        if(! ($key && $secret)) {
            return pinyin_permalink($str);
        }

        $salt = Str::random();
        $sign = md5($key . $str . $salt . $secret);

        $response = (new Client())->post('https://fanyi-api.baidu.com/api/trans/vip/translate', [
            'query' => [
                'q' => $str,
                'from' => 'auto',
                'to' => 'en',
                'appid' => $key,
                'salt'  => $salt,
                'sign' => $sign,
            ],
        ]);
        $result = json_decode($response->getBody(), true);
        if(isset($result['trans_result'][0]['dst'])) {
            $transStr = $result['trans_result'][0]['dst'];
            return Str::slug($transStr);
        } else {
            return pinyin_permalink($str);
        }
    }
}
