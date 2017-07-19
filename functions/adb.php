<?php

/**
 * author: 
 * date:
 * description: A root class for all manage classes. This class communicates with DB
 */
define("DB_HOST", 'wfpromsqlp02');
define("DB_NAME", 'retail_prod');
define("DB_PORT", 3306);
define("DB_USER", "retail_prod_usr");   
define("DB_PWORD", "Rw1716$7"); 
   
//define("DB_HOST", 'localhost');
//define("DB_NAME", 'csashesi_kingston-coker');
//define("DB_PORT", 3306);
//define("DB_USER", "csashesi_kc15");
//define("DB_PWORD", "db!a4df4d");

define("LOG_LEVEL_SEC", 0);
define("LOG_LEVEL_DB_FAIL", 0);

function log_msg($level, $er_code, $msg, $mysql_msg) {
    return 0;
}

class adb {
    /*     * error description */

    var $str_error;
    /* error code */
    var $error;
    /* db connection link */
    var $link;
    /* Every error log has a 4 digit code. The first two digits(prefix) tells you which class logged the error */
    var $er_code_prefix;
    /* query result resource */
    var $result;

    function adb() {

        $this->er_code_prefix = 1000;
        $this->link = false;
        $this->result = 0;
    }

    /**
     * logs error into database using functions defined in log.php
     */
    function log_error($level, $code, $msg, $mysql_msg = "NONE") {
        $er_code = $this->er_code_prefix + $code;
        //call to a predefined function 
        $log_id = log_msg($level, $er_code, $msg, $mysql_msg);
        //if log id is false return 0;
        if (!$log_id) {
            return 0;
        }

        //display this code to user
        $this->error = "$er_code-$log_id";
        return $log_id;
    }

    /**
     * creates connection to database
     */
    
    public function connect()
    {
//        ini_set('mssql.charset', 'UTF-8'); 
        $options = array(  "UID" => DB_USER,  "PWD" => DB_PWORD, "CharacterSet" => "UTF-8", "Database" => DB_NAME);
        $this->_connection = sqlsrv_connect(DB_HOST, $options);
        if(!$this->_connection)
        { 
            die('<font color="red">Error: Unable to connect to database host.</font>');
        }
//        $this->_dbselect = @mssql_select_db(DB_NAME, $this->_connection);
//        if(!$this->_dbselect)
//        {
//            die('<font color="red">Error: Unable to select database.</font>');
//        }
        return true;
    }
//    function connect() {
//
//        if ($this->link) {
//            return true;
//        }
//        //try to connect to db
////        $this->link = mysql_connect(DB_HOST, DB_USER, DB_PWORD);
//        $this->link = sqlsrv_connect( DB_HOST, $connectionInfo);
//        
//
//        if (!$this->link) {
//            //if connection fail log error and set $str_error
//            echo "not connected"; //debug line
//            $this->log_error(LOG_LEVEL_DB_FAIL, 1, "connection failed  in db:connect()", mysql_error());
//            return false;
//        }
// 
//        if (!mysql_select_db(DB_NAME)) {
//
//            $log_id = $this->log_error(LOG_LEVEL_DB_FAIL, 2, "select db failed   in db:connect()", mysql_error($this->link));
//            return false;
//        }
//
//        return true;
//    }

    /**
     * returns a row from a data source
     */
     public function fetch()
    {
        return sqlsrv_fetch_array($this->_result);
    }
    
   
    /**
     * connect to db and run a query 
     */
    
    public function query($sql)
    {
        if (!$this->connect()) {
//           print "hereeeddddddddddddddde---e" . $str_sql;
            return false;
        }
        
        $this->_result = sqlsrv_query($this->_connection, $sql);
        if(!$this->_result)
        {
            $this->log_error(LOG_LEVEL_DB_FAIL, 4, "query failed", mysql_error($this->link));
            return false;
        }
        return true;
    }
      

    /**
     * returns number of rows in current dataset
     */
    function get_num_rows() {
        return mysql_num_rows($this->result);
    }
 
    /**
     * returns last auto generated id 
     */
    function get_insert_id() {
        $query = "Select scope_identity() as 'identity";
//        print $query;
        $this->query($query); 
        $row = $this->fetch();
        print_r($row); 
//        return mysql_insert_id();
    }

}
