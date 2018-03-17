<?php
require_once(dirname(__FILE__) . '/ZohoConnector.php');

/**
 * Class ZohoMethods класс содержит методы для работы с ZohoCRM
 */
class ZohoMethods
{
    /**
     * создает сущность в ZohoCRM в единственном числе
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $jsondata JSON заполненый {поле : изначение,...} создаваемой сущности
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
        $jsonerror = json_decode($result,true);
        if ($jsonerror['status'] === "error"){
            $fp = fopen(dirname(__FILE__) .'/ErrorLog.txt',"a");
            fwrite($fp,"Error: ".$result."\n");
        } else {
            return $result;
        }
        return null;
    }

    /**
     *
     * обновляет сущность в ZohoCRM в единственном числе по идентификатору
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     * @param string $jsondata JSON заполненый {поле : изначение,...} обновляемой сущности
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
        $jsonerror = json_decode($result,true);
        if ($jsonerror['status'] === "error"){
            $fp = fopen(dirname(__FILE__) .'/ErrorLog.txt',"a");
            fwrite($fp,"Error: ".$result."\n");
        } else {
            return $result;
        }
        return null;
    }

    /**
     * удаляем сущность в ZohoCRM в единственном числе по идентификатору
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     */
    public static function DeleteRecord($authtoken, $modulename, $id)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
        $result = ZohoConnector::DeleteRequesting($authtoken, $url);
        $jsonerror = json_decode($result,true);
        if ($jsonerror['status'] === "error"){
            $fp = fopen(dirname(__FILE__) .'/ErrorLog.txt',"a");
            fwrite($fp,"Error: ".$result."\n");
        } else {
            return $result;
        }
        return null;
    }

    /**
     * получаем сущность из ZohoCRM в единственном числе по идентификатору, возвращает JSON объект
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     */
    public static function GetRecord($authtoken, $modulename, $id)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
        $result = ZohoConnector::GetRequesting($authtoken, $url);
        $jsonerror = json_decode($result,true);
        if ($jsonerror['status'] === "error"){
            $fp = fopen(dirname(__FILE__) .'/ErrorLog.txt',"a");
            fwrite($fp,"Error: ".$result."\n");
        } else {
            return $result;
        }
        return null;
    }

    /**
     * получаем сущности из ZohoCRM по указаному критерию, возвращает JSON объект
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $criteria критерий поиска "(apifieldname:starts_with|equals:value)", допускается несколько критериев лог.оп. - AND, OR
     */
    public static function SearchRecordByCriteria($authtoken, $modulename, $criteria)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/search?criteria=" . $criteria;
        $result = ZohoConnector::GetRequesting($authtoken, $url);
        $jsonerror = json_decode($result,true);
        if ($jsonerror['status'] === "error"){
            $fp = fopen(dirname(__FILE__) .'/ErrorLog.txt',"a");
            fwrite($fp,"Error: ".$result."\n");
        } else {
            return $result;
        }
        return null;
    }

    /**
     * получаем связанные модули у сущности из ZohoCRM, возвращает JSON объект
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     * @param string $relaterecordname API имя связанного модуля
     */
    public static function GetRelatedRecords($authtoken, $modulename, $relaterecordname, $id)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id."/".$relaterecordname;
        $result = ZohoConnector::GetRequesting($authtoken, $url);
        $jsonerror = json_decode($result,true);
        if ($jsonerror['status'] === "error"){
            $fp = fopen(dirname(__FILE__) .'/ErrorLog.txt',"a");
            fwrite($fp,"Error: ".$result."\n");
        } else {
            return $result;
        }
        return null;
    }
    /**
     * обновляем связанный модуль у сущности из ZohoCRM
     *
     * @param string $authtoken токен авторизации
     * @param string $modulename API имя модуля
     * @param string $moduleid идентификатор сущности
     * @param string $relaterecordname API имя связанного модуля
     * @param string $relatedrecordid идентификатор связного списка
     * @param string $jsondata JSON заполненый {поле : изначение,...} обновляемого связного модуля
     */
    public static function UpdateRelatedRecord($authtoken, $modulename, $moduleid, $relaterecordname, $relatedrecordid, $jsondata)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $moduleid."/".$relaterecordname."/".$relatedrecordid;
        $data = '{
	                "data": ['
            . $jsondata .
            ']
                 }';
        $result = ZohoConnector::PutRequesting($authtoken, $url, $data);
        $jsonerror = json_decode($result,true);
        if ($jsonerror['status'] === "error"){
            $fp = fopen(dirname(__FILE__) .'/ErrorLog.txt',"a");
            fwrite($fp,"Error: ".$result."\n");
        } else {
            return $result;
        }
        return null;
    }
}

