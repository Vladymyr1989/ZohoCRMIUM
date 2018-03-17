<?php

/**
 * Class ZohoConnector класс содержит методы для имплементации различных запросов в ZohoCRM
 */
class ZohoConnector
{
    /**
     * методы выполняет POST запрос, возвращает ответ сервера
     *
     * @param string $authtoken токен авторизации
     * @param string $url url запроса
     * @param string $data JSON представления сущности
     * @return mixed
     */
    public static function PostRequesting($authtoken, $url, $data)
    {
        $headers = array
        (
            'Authorization: ' . $authtoken
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * методы выполняет GET запрос, возвращает ответ сервера
     *
     * @param string $authtoken токен авторизации
     * @param string $url url запроса
     * @return mixed
     */
    public static function GetRequesting($authtoken, $url)
    {
        $headers = array
        (
            'Authorization: ' . $authtoken
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * методы выполняет DELETE запрос, возвращает ответ сервера
     *
     * @param string $authtoken токен авторизации
     * @param string $url url запроса
     * @return mixed
     */
    public static function DeleteRequesting($authtoken, $url)
    {
        $headers = array
        (
            'Authorization: ' . $authtoken
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * методы выполняет PUT запрос, возвращает ответ сервера
     *
     * @param string $authtoken токен авторизации
     * @param string $url url запроса
     * @param string $data JSON представления сущности
     * @return mixed
     */
    public static function PutRequesting($authtoken, $url, $data)
    {
        $headers = array
        (
            'Authorization: ' . $authtoken
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}