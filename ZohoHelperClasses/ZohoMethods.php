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
     * @param string $wfTriger тригер ставится только чтобы срабатывала связная задача, виды: approval,workflow,blueprint
     */
    public static function CreateRecord($modulename, $jsondata, $wfTriger)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename;
        $data = '{"data": ['. $jsondata .'],"trigger": ['.$wfTriger.']}';
        $result = ZohoConnector::Requesting($url, $data, 'POST');
        if (isset($result)) {
            $jsonerror = json_decode($result, true);
            if ($jsonerror['status'] === "error") {
                file_put_contents(dirname(__FILE__) .'/ErrorsLog.txt', date('Y-m-d H:i:s') . "Error $modulename: ".$result."\n", FILE_APPEND);
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
     * @param string $wfTriger тригер ставится только чтобы срабатывала связная задача, виды: approval,workflow,blueprint
     */
    public static function UpdateRecord($modulename, $id, $jsondata,$wfTriger)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
        $data = '{"data": ['. $jsondata .'],"trigger": ['.$wfTriger.']}';
        $result = ZohoConnector::Requesting($url, $data, 'PUT');
        if (isset($result)) {
            $jsonerror = json_decode($result, true);
            if ($jsonerror['status'] === "error") {
                file_put_contents(dirname(__FILE__) .'/ErrorsLog.txt', date('Y-m-d H:i:s') . "Error $modulename: ".$result."\n", FILE_APPEND);
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
        $result = ZohoConnector::Requesting($url, '', 'DELETE');
        if (isset($result)) {
            $jsonerror = json_decode($result, true);
            if ($jsonerror['status'] === "error") {
                file_put_contents(dirname(__FILE__) .'/ErrorsLog.txt', date('Y-m-d H:i:s') . "Error $modulename: ".$result."\n", FILE_APPEND);
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
        $result = ZohoConnector::Requesting($url, '', 'GET');
        if (isset($result)) {
            $jsonerror = json_decode($result, true);
            if ($jsonerror['status'] === "error") {
                file_put_contents(dirname(__FILE__) .'/ErrorsLog.txt', date('Y-m-d H:i:s') . "Error $modulename: ".$result."\n", FILE_APPEND);
            } else {
                $jsonstr = json_decode($result);
                $jsonelem = $jsonstr->data;
                $jsonenc = json_encode($jsonelem);
                $jsonobj = substr($jsonenc, 1, strlen($jsonenc) - 2);
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
        $result = ZohoConnector::Requesting($url, '', 'GET');
        if (isset($result)) {
            $jsonerror = json_decode($result, true);
            if ($jsonerror['status'] === "error") {
                file_put_contents(dirname(__FILE__) .'/ErrorsLog.txt', date('Y-m-d H:i:s') . "Error $modulename: ".$result."\n", FILE_APPEND);
            } else {
                $jsonstr = json_decode($result);
                $jsonelem = $jsonstr->data;
                $objlist = array();
                foreach ($jsonelem as $key) {
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
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id . "/" . $relaterecordname;
        $result = ZohoConnector::Requesting($url, '', 'GET');
        if (isset($result)) {
            $jsonerror = json_decode($result, true);
            if ($jsonerror['status'] === "error") {
                file_put_contents(dirname(__FILE__) .'/ErrorsLog.txt', date('Y-m-d H:i:s') . "Error $modulename: ".$result."\n", FILE_APPEND);
            } else {
                $jsonstr = json_decode($result);
                $jsonelem = $jsonstr->data;
                $jsonenc = json_encode($jsonelem);
                $jsonobj = substr($jsonenc, 1, strlen($jsonenc) - 2);
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
     * @param string $wfTriger тригер ставится только чтобы срабатывала связная задача, виды: approval,workflow,blueprint
     */
    public static function UpdateRelatedRecord($modulename, $moduleid, $relaterecordname, $relatedrecordid, $jsondata, $wfTriger)
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $moduleid . "/" . $relaterecordname . "/" . $relatedrecordid;
        $data = '{"data": ['. $jsondata .'],"trigger": ['.$wfTriger.']}';
        $result = ZohoConnector::Requesting($url, $data, 'PUT');
        if (isset($result)) {
            $jsonerror = json_decode($result, true);
            if ($jsonerror['status'] === "error") {
                file_put_contents(dirname(__FILE__) .'/ErrorsLog.txt', date('Y-m-d H:i:s') . "Error $modulename: ".$result."\n", FILE_APPEND);
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
     *
     */
    public static function GetFieldValue($jsonobj, $valueApiname)
    {
        $jsonobjDec = json_decode($jsonobj, true);
        if (is_array($jsonobjDec[$valueApiname])) {
            $inneronj = $jsonobjDec[$valueApiname];
            return $inneronj['id'];
        } else {
            return $jsonobjDec[$valueApiname];
        }
    }

    /**
     * Получает значение поля, если поле это лукап получаем идентификатор вложенного поля
     *
     * @param string $modulename API имя модуля
     * @param string $id идентификатор модуля
     * @param string $valueApiname API имя поля
     * @param string $value значение поля
     * @param string $wfTriger тригер ставится только чтобы срабатывала связная задача, виды: approval,workflow,blueprint
     */
    public static function UpdateFieldValue($modulename, $id, $valueApiname, $value, $wfTriger)
    {
        $record = ZohoMethods::GetRecord($modulename, $id);
        if (isset($record)) {
            $jsonobjDec = json_decode($record, true);
            $url = "https://www.zohoapis.com/crm/v2/" . $modulename . "/" . $id;
            if (is_array($jsonobjDec[$valueApiname])) {
                $data = '{"data": [{' . $valueApiname . ':{"id":' . $value . '}}],"trigger": ['.$wfTriger.']}';
                $result = ZohoConnector::Requesting($url, $data, 'PUT');
                if (isset($result)) {
                    return $result;
                }
            } else {
                $data = '{"data":[{' . $valueApiname . ':' . $value . '}],"trigger": ['.$wfTriger.']}';
                $result = ZohoConnector::Requesting($url, $data, 'PUT');
                if (isset($result)) {
                    return $result;
                }
            }
        }
        return null;
    }
}

