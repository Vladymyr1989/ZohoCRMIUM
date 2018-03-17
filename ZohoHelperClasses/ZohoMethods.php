<?php
require_once(dirname(__FILE__) . '/ZohoConnector.php');

/**
 * Class ZohoMethods класс содержит методы для работы с ZohoCRM
 */
class ZohoMethods
{
    /**
     * создает сущность в ZohoCRM в единственном числе, возвращает ответ сервера
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $jsondata JSON заполненый {поле : изначение,...} создаваемой сущности
     * @return mixed
     */
    public static function CreateRecord($authtoken, $modulename, $jsondata)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename;
        $data = '{
	                "data": ['
            . $jsondata .
            ']
                 }';
        $result = ZohoConnector::PostRequesting($authtoken, $url, $data);
        return $result;
    }

    /**
     *
     * обновляет сущность в ZohoCRM в единственном числе по идентификатору, возвращает ответ сервера
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     * @param string $jsondata JSON заполненый {поле : изначение,...} обновляемой сущности
     * @return mixed
     */
    public static function UpdateRecord($authtoken, $modulename, $id, $jsondata)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
        $data = '{
	                "data": ['
            . $jsondata .
            ']
                 }';
        $result = ZohoConnector::PutRequesting($authtoken, $url, $data);
        return $result;
    }

    /**
     * удаляем сущность в ZohoCRM в единственном числе по идентификатору, возвращает ответ сервера
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     * @return mixed
     */
    public static function DeleteRecord($authtoken, $modulename, $id)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
        $result = ZohoConnector::DeleteRequesting($authtoken, $url);
        return $result;
    }
}

