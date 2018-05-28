<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.02.2018
 * Time: 12:13
 */

namespace common\components;

/**
 * Отправка сообщения в чат телеграма
 * @info Узнать айдишник чата - https://api.telegram.org/bot{TOKEN}/getUpdates и в настойках бота
 * выключить Privacy mode (https://core.telegram.org/bots#privacy-mode)
 * @package common\components
 */
class Telegrammer
{
    public static function sendMessageInfo($message)
    {
        $token = \Yii::$app->params['telegram']['token'];

        foreach (\Yii::$app->params['telegram']['chat_ids'] as $chat_id) {
            $data = [
                'text' => $message,
                'chat_id' => $chat_id,
                'disable_web_page_preview' => \Yii::$app->params['telegram']['disable_web_page_preview'],
                'parse_mode' => \Yii::$app->params['telegram']['parse_mode']
            ];

            $proxy = "138.68.236.23:3128";
            $url = "https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
//            curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        }
    }
}