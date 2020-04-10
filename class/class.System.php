<?php

namespace ProxmoxMigration\DB;

use ProxmoxMigration\DB\DatabaseRepository as DB_REPO;


class System
{
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
        
        if (strcmp($action, DB_REPO::EXPORT) && strcmp($action, DB_REPO::IMPORT)) {
            echo "[ERROR]: Invalid arguments (action)! \n\n";
            echo "It should be export or import\n\n";
            die();
        } 
        
        if (strcmp($mode, self::DEVELOPMENT_MODE) && strcmp($mode, self::PRODUCTION_MODE)) {
            echo "[ERROR]: Invalid arguments (mode)! \n\n";
            echo "It should be dev (for development environment) or prod (for production environment) \n\n";
            die();
        }

        return [
            'action' => $action,
            'mode' => $mode,
        ];
    }

    public function isDev($mode)
    {
        if (strcmp($mode, self::DEVELOPMENT_MODE)) {
            return true;
        } else {
            return false;
        }
    }
}