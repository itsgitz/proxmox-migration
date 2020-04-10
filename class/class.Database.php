<?php

namespace ProxmoxMigration\DB;

class Database
{
    private $servername = 'localhost';
    private $username = 'root';
    private $password = 'P4ssword123**';
    private $db = 'gittossuto_api';

    const LOGDIR = './log';
    const LOGFILE = 'app.log';

    /**
     * createConnection
     * 
     * @return object connection
     */
    public function getConnection()
    {
        // create new connection
        $conn = new \mysqli($this->servername, $this->username, $this->password, $this->db);

        return $conn;
    }

    /**
     * isConnectionError
     * 
     * check database connection status
     * 
     * @return bool true|false
     */
    public function isConnectionError()
    {
        if ($this->getConnection()->connect_error) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * getQuery
     * 
     * query or selecting data
     * 
     * @param string
     * @return array
     */
    public function getQuery($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->getConnection()->query($sql);
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * runImportData()
     * 
     * @param string filename
     * @param string tablename
     * @param string columns with csv format and enclosed by brackets. Example: (column1,column2,column3)
     * @return array|error array if success
     */
    public function runImportData($filename, $table, $columns)
    {
        // define a log file execution
        $log = self::LOGDIR . DIRECTORY_SEPARATOR . self::LOGFILE;

        // enclosed character for display double quotes as a string
        $enclosedChar = '\\"';

        // define sql query
        $sqlQuery = "LOAD DATA LOCAL INFILE '$filename' 
            INTO TABLE $table 
            FIELDS TERMINATED BY ','
            ENCLOSED BY '$enclosedChar'
            LINES TERMINATED BY '\\n'
            $columns
        ";

        // define execution for sql query
        $sqlExecution = "mysql -u {$this->username} --password=\"{$this->password}\" {$this->db} -h {$this->servername} -e \"$sqlQuery\" > $log";

        // execute command
        exec($sqlExecution, $output, $return_var);

        // if return var is 1 or true, it means error occurred
        if ($return_var) {

            // return status error
            return [
                "status" => false,
                "message" => "error",
            ];

        } else {
            
            // return status success
            return [
                "status" => true,
                "message" => "success",
            ];
        }
    }
}