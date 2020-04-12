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
use ProxmoxMigration\DB\System;
use ProxmoxMigration\DB\Database;
use ProxmoxMigration\DB\DatabaseRepository as DB_REPO;



// define system class
$sys = new System();

// Check and define arguments
$arguments = $sys->getArguments($argv);

if (isset($arguments)) {
    // create system directory that contains storage and log directory
    // storage for csv files
    // log for log files
    $sys->createSystemDirectory();


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
                        /**
                         * This is only test for exporting data from local database
                         */
                        // $users = $db->getQuery(DB_REPO::USERS_TABLENAME);
                        // print_r( $csv->exportToCsv(DB_REPO::USERS_TABLENAME, $users) );


                        /**
                         * DEV MODE
                         * 
                         * Here in this example the script will export 2 VMs data on production with
                         * hosting_id = 24705 and 24706
                         */
                        echo "[INFO] Running code in development environment ...\n";
                        echo "Note that only one data (VM) will be exported while in development environment\n\n";

                        $where = DB_REPO::generateWhereClauses();

                        // export tblhosting data
                        $tblhosting = $db->getQuery(DB_REPO::TBLHOSTING_TABLENAME, $where[DB_REPO::TBLHOSTING_TABLENAME], $isDev);
                        print_r($csv->exportToCsv(DB_REPO::TBLHOSTING_TABLENAME, $tblhosting));

                        // export tblcustomfieldsvalues
                        $tblcustomfieldsvalues = $db->getQuery(DB_REPO::TBLCUSTOMFIELDSVALUES_TABLENAME, $where[DB_REPO::TBLCUSTOMFIELDSVALUES_TABLENAME], $isDev);
                        print_r($csv->exportToCsv(DB_REPO::TBLCUSTOMFIELDSVALUES_TABLENAME, $tblcustomfieldsvalues));

                        // export proxmoxVPS_Users
                        $proxmoxVPS_Users = $db->getQuery(DB_REPO::PROXMOXVPS_USERS_TABLENAME, $where[DB_REPO::PROXMOXVPS_USERS_TABLENAME], $isDev);
                        print_r($csv->exportToCsv(DB_REPO::PROXMOXVPS_USERS_TABLENAME, $proxmoxVPS_Users));

                        // export proxmoxVPS_IP
                        $proxmoxVPS_IP = $db->getQuery(DB_REPO::PROXMOXVPS_IP_TABLENAME, $where[DB_REPO::PROXMOXVPS_IP_TABLENAME], $isDev);
                        print_r($csv->exportToCsv(DB_REPO::PROXMOXVPS_IP_TABLENAME, $proxmoxVPS_IP));

                        // export mg_proxmox_addon_ip
                        $mg_proxmox_addon_ip = $db->getQuery(DB_REPO::MG_PROXMOX_ADDON_IP_TABLENAME, $where[DB_REPO::MG_PROXMOX_ADDON_IP_TABLENAME], $isDev);
                        print_r($csv->exportToCsv(DB_REPO::MG_PROXMOX_ADDON_IP_TABLENAME, $mg_proxmox_addon_ip));

                        // export mod_proxmox_change_password_log
                        $mod_proxmox_change_password_log = $db->getQuery(DB_REPO::MOD_PROXMOX_CHANGE_PASSWORD_LOG_TABLENAME, $where[DB_REPO::MOD_PROXMOX_CHANGE_PASSWORD_LOG_TABLENAME], $isDev);
                        print_r($csv->exportToCsv(DB_REPO::MOD_PROXMOX_CHANGE_PASSWORD_LOG_TABLENAME, $mod_proxmox_change_password_log));

                        sleep(1.5);
                        echo "[INFO]: Finish ... \n\n";


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
}
