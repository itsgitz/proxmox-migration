#!/usr/bin/php

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
use ProxmoxMigration\DB\DatabaseRepository;



// define system class
$sys = new System();

// Check and define arguments
$arguments = $sys->getArguments($argv);

/**
 * Arguments cannot be empty!
 */
if (isset($arguments)) {
    // create system directory that contains storage and log directory
    // storage for csv files
    // log for log files
    $sys->createSystemDirectory();


    // Define and get a database connection ...
    $db = new Database();

    // Define database repository data
    $dbRepo = new DatabaseRepository();

    // Define csv class
    $csv = new CSV();

    // check if mode is development mode
    $isDev = $sys->isDev($arguments[$sys::MODE]);

    // Show list of tables that will be migrate
    $dbRepo->showListTables($isDev);


    // Check database connection
    if (!$db->isConnectionError()) {

        // Choose arguments
        switch ($arguments[$sys::ACTION]) {

            /**
             * Query and Export process
             */
            case $dbRepo::EXPORT:
                /**
                 * This is only test for exporting data from local database
                 */
                // $users = $db->getQuery($dbRepo->USERS_TABLENAME);
                // print_r( $csv->exportToCsv($dbRepo->USERS_TABLENAME, $users) );

                switch ($arguments[$sys::MODE]) {
                    case $sys::DEVELOPMENT_MODE:

                        /**
                         * DEV MODE
                         * 
                         * Here in this example the script will export 2 VMs data on production with
                         * hosting_id = 24705 and 24706
                         */
                        echo "[INFO] Running code in development environment for exporting data ...\n";
                        echo "Note that only one data (VM) will be exported while in development environment\n\n";

                        $where = $dbRepo->generateWhereClauses();

                        // export tblhosting data
                        $tblhosting = $db->getQuery(
                            $dbRepo::TBLHOSTING_TABLENAME,
                            $where[$dbRepo::TBLHOSTING_TABLENAME],
                            $isDev
                        );

                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::EXPORT,
                            print_r($csv->exportToCsv($dbRepo::TBLHOSTING_TABLENAME, $tblhosting), true)
                        );

                        // export tblcustomfieldsvalues
                        $tblcustomfieldsvalues = $db->getQuery(
                            $dbRepo::TBLCUSTOMFIELDSVALUES_TABLENAME,
                            $where[$dbRepo::TBLCUSTOMFIELDSVALUES_TABLENAME],
                            $isDev
                        );

                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::EXPORT,
                            print_r($csv->exportToCsv($dbRepo::TBLCUSTOMFIELDSVALUES_TABLENAME, $tblcustomfieldsvalues), true)
                        );

                        // export proxmoxVPS_Users
                        $proxmoxVPS_Users = $db->getQuery(
                            $dbRepo::PROXMOXVPS_USERS_TABLENAME, 
                            $where[$dbRepo::PROXMOXVPS_USERS_TABLENAME], 
                            $isDev
                        );

                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::EXPORT,
                            print_r($csv->exportToCsv($dbRepo::PROXMOXVPS_USERS_TABLENAME, $proxmoxVPS_Users), true)
                        );

                        // export proxmoxVPS_IP
                        $proxmoxVPS_IP = $db->getQuery(
                            $dbRepo::PROXMOXVPS_IP_TABLENAME, 
                            $where[$dbRepo::PROXMOXVPS_IP_TABLENAME], 
                            $isDev
                        );

                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::EXPORT,
                            print_r($csv->exportToCsv($dbRepo::PROXMOXVPS_IP_TABLENAME, $proxmoxVPS_IP), true)
                        );

                        // export mg_proxmox_addon_ip
                        $mg_proxmox_addon_ip = $db->getQuery(
                            $dbRepo::MG_PROXMOX_ADDON_IP_TABLENAME, 
                            $where[$dbRepo::MG_PROXMOX_ADDON_IP_TABLENAME], 
                            $isDev
                        );

                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::EXPORT,
                            print_r($csv->exportToCsv($dbRepo::MG_PROXMOX_ADDON_IP_TABLENAME, $mg_proxmox_addon_ip), true)
                        );

                        // export mod_proxmox_change_password_log
                        $mod_proxmox_change_password_log = $db->getQuery(
                            $dbRepo::MOD_PROXMOX_CHANGE_PASSWORD_LOG_TABLENAME,
                            $where[$dbRepo::MOD_PROXMOX_CHANGE_PASSWORD_LOG_TABLENAME],
                            $isDev
                        );

                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::EXPORT,
                            print_r($csv->exportToCsv($dbRepo::MOD_PROXMOX_CHANGE_PASSWORD_LOG_TABLENAME, $mod_proxmox_change_password_log), true)
                        );

                        $sys->showFinisihMessage();


                        break;

                    case $sys::PRODUCTION_MODE:

                        /**
                         * PROD MODE
                         */
                        // export proxmoxVPS_Users => ProxmoxAddon_User
                        echo "[INFO] Running code in production environment for exporting data ...\n";
                        echo "All VMs will be exported \n\n";

                        $proxmoxVPS_Users = $db->getQuery($dbRepo::PROXMOXVPS_USERS_TABLENAME);

                        $sys->generateLog(
                            $sys::PRODUCTION_MODE,
                            $dbRepo::EXPORT,
                            print_r($csv->exportToCsv($dbRepo::PROXMOXVPS_USERS_TABLENAME, $proxmoxVPS_Users), true)
                        );

                        // export proxmoxVPS_IP => ProxmoxAddon_VmIpAddress
                        $proxmoxVPS_IP = $db->getQuery($dbRepo::PROXMOXVPS_IP_TABLENAME);

                        $sys->generateLog(
                            $sys::PRODUCTION_MODE,
                            $dbRepo::EXPORT,
                            print_r($csv->exportToCsv($dbRepo::PROXMOXVPS_IP_TABLENAME, $proxmoxVPS_IP), true)
                        );

                        // export mg_proxmox_addon_ip
                        $mg_proxmox_addon_ip = $db->getQuery($dbRepo::MG_PROXMOX_ADDON_IP_TABLENAME);

                        $sys->generateLog(
                            $sys::PRODUCTION_MODE,
                            $dbRepo::EXPORT,
                            print_r($csv->exportToCsv($dbRepo::MG_PROXMOX_ADDON_IP_TABLENAME, $mg_proxmox_addon_ip), true)
                        );

                        $sys->showFinisihMessage();


                        break;

                    default:
                        break;
                }
                break;

            /**
             * Import process
             */
            case $dbRepo::IMPORT:
                /**
                 * This is only test for exporting data from local database
                 */
                // var_dump($db->runImportData($dbRepo->USERS_CSV_FILES, $dbRepo->USERS_TABLENAME, $dbRepo->USERS_COLUMNS));
                
                switch ($arguments[$sys::MODE]) {

                    /**
                     * DEV MODE
                     */
                    case $sys::DEVELOPMENT_MODE:

                        echo "[INFO] Running code in development environment for importing data ...\n";
                        echo "Note that only one data (VM) will be imported while in development environment\n\n";

                        // import tblhosting
                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::IMPORT,
                            print_r($db->runImportData(
                                $dbRepo::TBLHOSTING_CSV_FILES, 
                                $dbRepo::TBLHOSTING_TABLENAME, 
                                $dbRepo::TBLHOSTING_COLUMNS
                            ), true)
                        );

                        // import tblcustomfieldsvalues
                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::IMPORT,
                            print_r($db->runImportData(
                                $dbRepo::TBLCUSTOMFIELDSVALUES_CSV_FILES,
                                $dbRepo::TBLCUSTOMFIELDSVALUES_TABLENAME,
                                $dbRepo::TBLCUSTOMFIELDSVALUES_COLUMNS
                            ), true)
                        );

                        // import proxmoxVPS_Users => ProxmoxAddon_User
                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::IMPORT,
                            print_r($db->runImportData(
                                $dbRepo::PROXMOXVPS_USERS_CSV_FILES,
                                $dbRepo::PROXMOX_ADDON_USER_TABLENAME,
                                $dbRepo::PROXMOX_ADDON_USER_COLUMNS
                            ), true)
                        );

                        // import proxmoxVPS_IP => ProxmoxAddon_VmIpAddress
                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::IMPORT,
                            print_r($db->runImportData(
                                $dbRepo::PROXMOXVPS_IP_CSV_FILES,
                                $dbRepo::PROXMOX_ADDON_VMIPADDRESS_TABLENAME,
                                $dbRepo::PROXMOX_ADDON_VMIPADDRESS_COLUMNS
                            ), true)
                        );

                        // import mg_proxmox_addon_ip
                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::IMPORT,
                            print_r($db->runImportData(
                                $dbRepo::MG_PROXMOX_ADDON_IP_CSV_FILES,
                                $dbRepo::MG_PROXMOX_ADDON_IP_TABLENAME,
                                $dbRepo::MG_PROXMOX_ADDON_IP_COLUMNS
                            ), true)
                        );

                        // import mod_proxmox_change_password_log
                        $sys->generateLog(
                            $sys::DEVELOPMENT_MODE,
                            $dbRepo::IMPORT,
                            print_r($db->runImportData(
                                $dbRepo::MOD_PROXMOX_CHANGE_PASSWORD_LOG_CSV_FILES,
                                $dbRepo::MOD_PROXMOX_CHANGE_PASSWORD_LOG_TABLENAME,
                                $dbRepo::MOD_PROXMOX_CHANGE_PASSWORD_LOG_COLUMNS
                            ), true)
                        );

                        $sys->showFinisihMessage();

                        break;

                    case $sys::PRODUCTION_MODE:
                        
                        /**
                         * PROD MODE
                         */

                        echo "[INFO] Running code in development environment for importing data ...\n";
                        echo "All VMs will be imported \n\n";

                        // import proxmoxVPS_Users => ProxmoxAddon_User
                        $sys->generateLog(
                            $sys::PRODUCTION_MODE,
                            $dbRepo::IMPORT,
                            print_r($db->runImportData(
                                $dbRepo::PROXMOXVPS_USERS_CSV_FILES,
                                $dbRepo::PROXMOX_ADDON_USER_TABLENAME,
                                $dbRepo::PROXMOX_ADDON_USER_COLUMNS
                            ), true)
                        );

                        // import proxmoxVPS_IP => ProxmoxAddon_VmIpAddress
                        $sys->generateLog(
                            $sys::PRODUCTION_MODE,
                            $dbRepo::IMPORT,
                            print_r($db->runImportData(
                                $dbRepo::PROXMOXVPS_IP_CSV_FILES,
                                $dbRepo::PROXMOX_ADDON_VMIPADDRESS_TABLENAME,
                                $dbRepo::PROXMOX_ADDON_VMIPADDRESS_COLUMNS
                            ), true)
                        );

                        // import mg_proxmox_addon_ip
                        $sys->generateLog(
                            $sys::PRODUCTION_MODE,
                            $dbRepo::IMPORT,
                            print_r($db->runImportData(
                                $dbRepo::MG_PROXMOX_ADDON_IP_CSV_FILES,
                                $dbRepo::MG_PROXMOX_ADDON_IP_TABLENAME,
                                $dbRepo::MG_PROXMOX_ADDON_IP_COLUMNS
                            ), true)
                        );
                        break;

                    default:
                        break;
                }

                break;

            default:
                break;
        }
    } else {

        // connection problem
        echo $dbRepo::DB_CONNECTION_PROBLEM . "\n\n";
    }
}
