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
     * @param string $modulename API имя модуля
     * @param string $jsondata JSON заполненый {поле : изначение,...} создаваемой сущности
     */
    public static function CreateRecord($modulename, $jsondata)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename;
        $data = '{
	                "data": ['
            . $jsondata .
            ']
                 }';
        $result = ZohoConnector::Requesting($url, $data,'POST');
        if (isset($result)){
            $jsonerror = json_decode($result,true);
            if ($jsonerror['status'] === "error"){
                $fp = fopen(dirname(__FILE__) .'/ErrorsLog.txt',"w");
                fwrite($fp,"Error: ".$result."\n");
                fclose($fp);
            } else {
                return $result;
            }
        }
            return null;
    }

    /**
     *
     * обновляет сущность в ZohoCRM в единственном числе по идентификатору
     *
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     * @param string $jsondata JSON заполненый {поле : изначение,...} обновляемой сущности
     */
    public static function UpdateRecord($modulename, $id, $jsondata)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
        $data = '{
	                "data": ['
            . $jsondata .
            ']
                 }';
        $result = ZohoConnector::Requesting($url, $data,'PUT');
        if (isset($result)){
            $jsonerror = json_decode($result,true);
            if ($jsonerror['status'] === "error"){
                $fp = fopen(dirname(__FILE__) .'/ErrorsLog.txt',"w");
                fwrite($fp,"Error: ".$result."\n");
                fclose($fp);
            } else {
                return $result;
            }
        }
        return null;
    }

    /**
     * удаляем сущность в ZohoCRM в единственном числе по идентификатору
     *
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     */
    public static function DeleteRecord($modulename, $id)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
        $result = ZohoConnector::Requesting($url,'','DELETE');
        if (isset($result)){
            $jsonerror = json_decode($result,true);
            if ($jsonerror['status'] === "error"){
                $fp = fopen(dirname(__FILE__) .'/ErrorsLog.txt',"w");
                fwrite($fp,"Error: ".$result."\n");
                fclose($fp);
            } else {
                return $result;
            }
        }
        return null;
    }

    /**
     * получаем сущность из ZohoCRM в единственном числе по идентификатору, возвращает JSON объект
     *
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     */
    public static function GetRecord($modulename, $id)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
        $result = ZohoConnector::Requesting($url,'','GET');
        if (isset($result)){
            $jsonerror = json_decode($result,true);
            if ($jsonerror['status'] === "error"){
                $fp = fopen(dirname(__FILE__) .'/ErrorsLog.txt',"w");
                fwrite($fp,"Error: ".$result."\n");
                fclose($fp);
            } else {
                $jsonstr = json_decode($result);
                $jsonelem = $jsonstr->data;
                $jsonenc = json_encode($jsonelem);
                $jsonobj = substr($jsonenc,1,strlen($jsonenc)-2);
                return $jsonobj;
            }
        }
            return null;
    }

    /**
     * получаем сущности из ZohoCRM по указаному критерию, возвращает массив JSON объектов
     *
     * @param string $modulename API имя модуля
     * @param string $criteria критерий поиска "(apifieldname:starts_with|equals:value)", допускается несколько критериев лог.оп. - AND, OR
     */
    public static function SearchRecordByCriteria($modulename, $criteria)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/search?criteria=" . $criteria;
        $result = ZohoConnector::Requesting($url,'','GET');
        if (isset($result)){
            $jsonerror = json_decode($result,true);
            if ($jsonerror['status'] === "error"){
                $fp = fopen(dirname(__FILE__) .'/ErrorsLog.txt',"w");
                fwrite($fp,"Error: ".$result."\n");
                fclose($fp);
            } else {
                $jsonstr = json_decode($result);
                $jsonelem = $jsonstr->data;
                $objlist = array();
                foreach ($jsonelem as $key){
                    $objlist[] = json_encode($key);
                }
                return $objlist;
            }
        }
        return null;
    }

    /**
     * получаем связанные модули у сущности из ZohoCRM, возвращает JSON объект
     *
     * @param string $modulename API имя модуля
     * @param string $id идентификатор сущности
     * @param string $relaterecordname API имя связанного модуля
     */
    public static function GetRelatedRecords($modulename, $relaterecordname, $id)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id."/".$relaterecordname;
        $result = ZohoConnector::Requesting($url,'','GET');
        if (isset($result)){
            $jsonerror = json_decode($result,true);
            if ($jsonerror['status'] === "error"){
                $fp = fopen(dirname(__FILE__) .'/ErrorsLog.txt',"w");
                fwrite($fp,"Error: ".$result."\n");
                fclose($fp);
            } else {
                $jsonstr = json_decode($result);
                $jsonelem = $jsonstr->data;
                $jsonenc = json_encode($jsonelem);
                $jsonobj = substr($jsonenc,1,strlen($jsonenc)-2);
                return $jsonobj;
            }
        }
        return null;
    }
    /**
     * обновляем связанный модуль у сущности из ZohoCRM
     *
     * @param string $modulename API имя модуля
     * @param string $moduleid идентификатор сущности
     * @param string $relaterecordname API имя связанного модуля
     * @param string $relatedrecordid идентификатор связного списка
     * @param string $jsondata JSON заполненый {поле : изначение,...} обновляемого связного модуля
     */
    public static function UpdateRelatedRecord($modulename, $moduleid, $relaterecordname, $relatedrecordid, $jsondata)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $moduleid."/".$relaterecordname."/".$relatedrecordid;
        $data = '{
	                "data": ['
            . $jsondata .
            ']
                 }';
        $result = ZohoConnector::Requesting($url, $data,'PUT');
        if (isset($result)){
            $jsonerror = json_decode($result,true);
            if ($jsonerror['status'] === "error"){
                $fp = fopen(dirname(__FILE__) .'/ErrorsLog.txt',"w");
                fwrite($fp,"Error: ".$result."\n");
                fclose($fp);
            } else {
                return $result;
            }
        }
        return null;
    }

    /**
     * Получает значение поля, если поле это лукап получаем идентификатор вложенного поля
     *
     * @param string $jsonobj JSON объект сущности
     * @param string $valueApiname API имя поля
     */
    public static function GetFieldValue ($jsonobj,$valueApiname){
        $jsonobjDec = json_decode($jsonobj,true);
        if (is_array($jsonobjDec[$valueApiname])){
            $inneronj = $jsonobjDec[$valueApiname];
            return $inneronj['id'];
        } else {
            return $jsonobjDec[$valueApiname];
        }
    }

    public static function UpdateFieldValue ($modulename, $id ,$valueApiname, $value){
        $record = ZohoMethods::GetRecord($modulename, $id);
        if(isset($record)){
            $jsonobjDec = json_decode($record,true);
            $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
            if (is_array($jsonobjDec[$valueApiname])){
                $data = '{"data": [{'. $valueApiname .':{"id":'.$value.'}}]}';
                $result = ZohoConnector::Requesting($url, $data,'PUT');
                if (isset($result)){
                    return $result;
                }
            } else {
                $data = '{"data":[{'. $valueApiname .':'.$value.'}]}';
                $result = ZohoConnector::Requesting($url, $data,'PUT');
                if (isset($result)){
                    return $result;
                }
            }
        }
        return null;
    }
}

