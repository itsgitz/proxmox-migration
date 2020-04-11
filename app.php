<?php

/**
 * Proxmox Migration Script
 * 
 * @author: Developer Team @ Infinys System Indonesia
 * @link: https://isi.co.id
 * 
 */

require __DIR__ . '/configuration/loader.php';


use ProxmoxMigration\DB\CSV;
use ProxmoxMigration\DB\Database;
use ProxmoxMigration\DB\DatabaseRepository as DB_REPO;
use ProxmoxMigration\DB\System;



// define system class
$sys = new System();

// Check and define arguments
$arguments = $sys->getArguments($argv);

// Define and get a database connection ...
$db = new Database();

// Define csv class
$csv = new CSV();

// check if mode is development mode
$isDev = $sys->isDev($arguments[$sys::MODE]);

// Show list of tables that will be migrate
DB_REPO::showListTables($isDev);


// Check database connection
if (!$db->isConnectionError()) {

    // Choose arguments
    switch ($arguments[$sys::ACTION]) {

            /**
         * Query and Export process
         */
        case DB_REPO::EXPORT:
            switch ($arguments[$sys::MODE]) {
                case $sys::DEVELOPMENT_MODE:
                    echo "dev";
                    /**
                     * DEV MODE
                     * 
                     * Here in this example the script will export 2 VMs data on production with
                     * hosting_id = 24705 and 24706
                     */
                    // export tblhosting data
                    $tblhosting = $db->getQuery(DB_REPO::tb, "id = 24075 or id = 24076", $isDev);
                    // export tblcustomfields
                    // export proxmoxVPS_Users
                    // export proxmoxVPS_IP
                    // export mg_proxmox_addon_ip
                    // export mod_proxmox_change_password_log

                    break;

                case $sys::PRODUCTION_MODE:
                    echo "prod";
                    /**
                     * PROD MODE
                     */
                    break;

                default:
                    break;
            }
            break;

            /**
             * Import process
             */
        case DB_REPO::IMPORT:
            // var_dump($db->runImportData(DB_REPO::USERS_CSV_FILES, DB_REPO::USERS_TABLENAME, DB_REPO::USERS_COLUMNS));

            break;

        default:
            break;
    }
} else {

    // connection problem
    echo DB_REPO::DB_CONNECTION_PROBLEM . "\n\n";
}
