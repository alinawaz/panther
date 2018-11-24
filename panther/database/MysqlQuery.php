<?php

namespace Panther\Database;

use Panther\Database\Interfaces\MysqlQueryInterface;

class MysqlQuery implements MysqlQueryInterface {

    private static $connected = false;
    private static $conn = FALSE;
    private static $lastQuery = '';
    private static $lastTableQuery = '';
    private static $lastTable = NULL;

    public static function getLastQuery(){
        return Array(
            'Last Direct Query' => MysqlQuery::$lastQuery,
            'Last Table Query' => MysqlQuery::$lastTable->getLastQuery()
        );
    }

    public static function connect() {
        MysqlQuery::Close();
        $default = config('db.default');
        try{
            self::$conn = mysqli_connect(
                config('db.'.$default.'.host'), 
                config('db.'.$default.'.username'), 
                config('db.'.$default.'.password'), 
                config('db.'.$default.'.database'), 
                config('db.'.$default.'.port')
            );
        }catch(Exception $e){
            exit("Panther: Unable to connect to database.");
        }
        if (mysqli_connect_errno()) {
            exit("<h3>Panther: Unable to connect to database.</h3>");
        }
        MysqlQuery::$connected = true;
        return true;
    }

    public static function close() {
        if (MysqlQuery::$connected == true) {
            mysqli_close(self::$conn);
            MysqlQuery::$connected = false;
            return true;
        }
        return false;
    }

    public static function query($QueryString) {
        MysqlQuery::Connect();
        MysqlQuery::$lastQuery = $QueryString;
        $result = mysqli_query(self::$conn,$QueryString);
        if(!$result)
            $result = mysqli_error(self::$conn);
        MysqlQuery::Close();        
        return $result;
    }

    public static function table($table){
        MysqlQuery::$lastTable = new MysqlTable($table);
        return MysqlQuery::$lastTable;
    }

}



?>