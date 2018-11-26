<?php

namespace Panther\Database;

use Panther\Database\Interfaces\MysqlQueryInterface;

class MysqlQuery implements MysqlQueryInterface
{

    private static $connected = false;
    private static $conn = FALSE;
    private static $lastQuery = '';
    private static $lastTableQuery = '';
    private static $lastTable = NULL;
    private static $mocked_instance = NULL;

    public static function connect() {
        if(MysqlQuery::$connected)
            MysqlQuery::close();

        $default = getenv('DB_DEFAULT');
        self::$conn = @mysqli_connect(
            getenv('DB_'.$default.'_HOST'), 
            getenv('DB_'.$default.'_USERNAME'), 
            getenv('DB_'.$default.'_PASSWORD'), 
            getenv('DB_'.$default.'_DATABASE'), 
            getenv('DB_'.$default.'_PORT')
        );
        if(self::$conn){
            MysqlQuery::$connected = true;
            return true;
        }
        MysqlQuery::$connected = false;
        throw new \Exception('Unable to connect to database.');
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

    public static function getLastQuery(){
        return Array(
            'Last Direct Query' => MysqlQuery::$lastQuery,
            'Last Table Query' => MysqlQuery::$lastTable ? MysqlQuery::$lastTable->getLastQuery(): ''
        );
    }

    public static function table($table){
        MysqlQuery::$lastTable = new MysqlTable($table);
        return MysqlQuery::$lastTable;
    }

}



?>