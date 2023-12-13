<?php
namespace SWServices\Pendings;
use Exception;

class PendingsHandler{

    public static function uuidsReq($data){
        $array = [];
        foreach ($data as list($a, $b)) {
          $array = array_merge($array, [["uuid" => $a ,
                  "action" => $b]]);
        }
        return array("uuids" => $array);
    }
    
    public static function uuidReq($data){
     return array("uuid" => $data);
    }
}
?>