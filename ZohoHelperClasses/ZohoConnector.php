<?php
require_once(dirname(__FILE__) . '/ZohoAuth.php');

/**
 * Class ZohoConnector класс содержит методы для имплементации различных запросов в ZohoCRM
 */
class ZohoConnector
{
    /**
     * методы выполняет POST,GET,PUT,DELETE запрос, возвращает ответ сервера
     *
     * @param string $url url запроса
     * @param string $data JSON представления сущности
     * @param string $requestType указываем вид запроса POST,GET,PUT или DELETE
     */
    public static function Requesting($url, $data, $requestType)
    {
        $authtoken = ZohoAuth::GetAuthToken();
        if (isset($authtoken)) {
            $headers = array
            (
                'Authorization: '. $authtoken
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestType);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        } else {
            return null;
        }
    }
}