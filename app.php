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
$isDev = $sys->isDev($arguments['mode']);

// Show list of tables that will be migrate
DB_REPO::showListTables($isDev);

// Get arguments
switch ($arguments['action']) {

    /**
     * Query and Export process
     */
    case DB_REPO::EXPORT:
        // Check database connection
        if (!$db->isConnectionError()) {

            /**
             * Only test:
             */
            // // query get users data
            // $users = $db->getQuery(DB_REPO::USERS_TABLENAME);
            // // export data to csv
            // $csv->exportToCsv(DB_REPO::USERS_TABLENAME, $users);


            /**
             * DEV MODE
             */
            // export tblhosting data
            // $tblhosting = $db->getQuery(DB_REPO::);
            // export tblcustomfields
            // export proxmoxVPS_Users
            // export proxmoxVPS_IP
            // export mg_proxmox_addon_ip
            // export mod_proxmox_change_password_log
            
            /**
             * PROD MODE
             */

        } else {

            // Display error if connection has a problem
            echo DB_REPO::DB_CONNECTION_PROBLEM;
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