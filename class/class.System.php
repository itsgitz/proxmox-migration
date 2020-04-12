<?php

namespace ProxmoxMigration\DB;

use DateTime;
use ProxmoxMigration\DB\DatabaseRepository as DB_REPO;


class System
{
    const ACTION = 'action';
    const MODE = 'mode';
    const DEVELOPMENT_MODE = 'dev';
    const PRODUCTION_MODE = 'prod';
    const LOGDIR = './log';
    const DB_LOGFILE = 'db.log';
    const APP_LOGFILE = 'app.log';

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

    /**
     * createSystemDirectory()
     * 
     */
    public function createSystemDirectory()
    {
        if (!file_exists(DB_REPO::STORAGE_DIR)) {
            echo "Creating 'storage' directory ... \n";

            mkdir(DB_REPO::STORAGE_DIR);
            sleep(1.5);
        }

        if (!file_exists(self::LOGDIR)) {
            echo "Creating 'log' directory ... \n";

            mkdir(self::LOGDIR);
            sleep(1.5);
        }
    }

    /**
     * generateLog()
     * 
     * @param string $mode (dev|prod)
     * @param string $action (export|import)
     * @param mixed $data (as print_r is allowed)
     */
    public function generateLog($mode, $action, $data)
    {
        $date = new DateTime();
        $date = $date->format("y-m-d h:i:s");

        $log = "[$mode][$action][$date]: $data \n";
        file_put_contents(
            self::LOGDIR . DIRECTORY_SEPARATOR . self::APP_LOGFILE,
            $log,
            FILE_APPEND
        );
    }

    /**
     * showFinishMessage()
     */
    public function showFinisihMessage()
    {
        sleep(1.5);
        echo "[INFO]: Finish ... \n\n";
    }
}