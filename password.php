<?php

require __DIR__ . '/configuration/loader.php';

use ProxmoxMigration\DB\WhmcsApi;
use ProxmoxMigration\DB\System;


// define instance
$api = new WhmcsApi();

if (isset($argv)) {
    if (!isset($argv[1])) {
        echo "[ERROR]: Incomplete arguments! (must encrypt or decrypt) \n\n";
        die();
    }

    if (!isset($argv[2])) {
        echo "[ERROR]: Incomplete arguments! (must dev or mode) \n\n";
        die();
    }

    /**
     * define arguments
     */
    $action = $argv[1];
    $mode = $argv[2];

    switch ($action) {
        case $api::ENCRYPT_ARGUMENT:

            $password = readline("Password: ");
            $response = $api->sendApiRequest($api::ENCRYPT_PASSWORD, $mode, $password);

            print_r($response);

            break;

        case $api::DECRYPT_ARGUMENT:

            $encryptedPassword = readline("Encrypted Password: ");
            $response = $api->sendApiRequest($api::DECRYPT_PASSWORD, $mode, $encryptedPassword);

            print_r($response);

            break;

        default:
            break;
    }
} else {
    echo "[ERROR]: Invalid arguments! \n\n";
}
