<?php

/**
 * Proxmox Migration Script
 * author: Developer Team @ Infinys System Indonesia
 */

include './configuration/loader.php';


use ProxmoxMigration\DB\CSV;
use ProxmoxMigration\DB\Database;
use ProxmoxMigration\DB\DatabaseRepository as DB_REPO;



// Define and get a database connection ...
$db = new Database();

// Define csv class
$csv = new CSV();

// Show list of tables that will be migrate
echo DB_REPO::showListTables();

// Get arguments
switch ($argv[1]) {

    /**
     * Query and Export process
     */
    case DB_REPO::EXPORT:
        // Check database connection
        if (!$db->isConnectionError()) {

            // query get users data
            $users = $db->getQuery(DB_REPO::USERS_TABLENAME);

            // export data to csv
            $csv->exportToCsv(DB_REPO::USERS_TABLENAME, $users);

        } else {

            // Display error if connection has a problem
            echo DB_REPO::DB_CONNECTION_PROBLEM;
        }

        break;

    /**
     * Import process
     */
    case DB_REPO::IMPORT:
        var_dump($db->runImportData(DB_REPO::USERS_CSV_FILES, DB_REPO::USERS_TABLENAME, DB_REPO::USERS_COLUMNS));

        break;

    default:
        echo DB_REPO::DB_INVALID_ARGUMENT;
        break;
}