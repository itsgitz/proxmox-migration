<?php

namespace ProxmoxMigration\DB;

use ProxmoxMigration\DB\DatabaseRepository as DB_REPO;


class System
{
    const ACTION = 'action';
    const MODE = 'mode';
    const DEVELOPMENT_MODE = 'dev';
    const PRODUCTION_MODE = 'prod';

    /**
     * getArguments()
     * 
     * check and define given arguments
     * 
     * @param array $argv arguments
     * @return array action, mode, dev[true|false]
     */
    public function getArguments($argv)
    {
        // if arguments is empty, error
        if (count($argv) < 2 || count($argv) < 3) {
            /**
             * if argument is empty
             */
            echo "[ERROR]: Incomplete arguments! \n\n";
            echo "[Usage]: php -q app.php [action] [mode] \n\n";
            echo "* action: export|import \n";
            echo "* mode: dev|prod \n";
            echo "\n";

            die();
        }

        /**
         * Passed arguments
         */
        $action = $argv[1];
        $mode = $argv[2];
        
        if (strcmp($action, DB_REPO::EXPORT) != 0 && strcmp($action, DB_REPO::IMPORT) != 0) {
            echo "[ERROR]: Invalid arguments (action)! \n\n";
            echo "It should be export or import\n\n";
            die();
        } 

        if (strcmp($mode, self::DEVELOPMENT_MODE) != 0 && strcmp($mode, self::PRODUCTION_MODE) != 0) {
            echo "[ERROR]: Invalid arguments (mode)! \n\n";
            echo "It should be dev (for development environment) or prod (for production environment) \n\n";
            die();
        }

        return [
            self::ACTION => $action,
            self::MODE => $mode,
        ];
    }

    /**
     * isDev
     * 
     * check if application run in dev mode
     * 
     * @param string mode
     * @return bool true if "dev", else return false
     */
    public function isDev($mode)
    {
        if (strcmp($mode, self::DEVELOPMENT_MODE) == 0) {
            return true;
        } else {
            return false;
        }
    }
}