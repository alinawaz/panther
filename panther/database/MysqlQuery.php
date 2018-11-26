<?php

namespace Panther\Database;

use Panther\Core\Config;
use Panther\Database\Interfaces\QueryInterface;

class MysqlQuery implements QueryInterface
{

    private static $connected = false;
    private static $conn = FALSE;
    private static $lastQuery = '';
    private static $lastTableQuery = '';
    private static $lastTable = NULL;
    private static $mocked_instance = NULL;

    public static function connect() {
        if(self::$connected)
            self::close();

        $default = getenv('DB_DEFAULT');
        self::$conn = @mysqli_connect(
            getenv('DB_'.$default.'_HOST'), 
            getenv('DB_'.$default.'_USERNAME'), 
            getenv('DB_'.$default.'_PASSWORD'), 
            getenv('DB_'.$default.'_DATABASE'), 
            getenv('DB_'.$default.'_PORT')
        );
        if(self::$conn){
            self::$connected = true;
            return true;
        }
        MysqlQuery::$connected = false;
        throw new \Exception('Unable to connect to database.');
    }

    public static function close() {
        if (self::$connected == true) {
            mysqli_close(self::$conn);
            self::$connected = false;
            return true;
        }
        return false;
    }

    public static function query($QueryString) {
        self::Connect();
        self::$lastQuery = $QueryString;
        $result = mysqli_query(self::$conn,$QueryString);
        if(!$result)
            $result = mysqli_error(self::$conn);
        self::Close();        
        return $result;
    }

    public static function getLastQuery(){
        return Array(
            'Last Direct Query' => self::$lastQuery,
            'Last Table Query' => self::$lastTable ? self::$lastTable->getLastQuery(): ''
        );
    }

    public static function table($table){
        self::$lastTable = new MysqlTable($table);
        return self::$lastTable;
    }

}



?>