<?php

require __DIR__ . '/configuration/loader.php';

use ProxmoxMigration\DB\WhmcsApi;


// define instance
$api = new WhmcsApi();

$encryptedPassword = readline("Encrypted Password: ");

// Decrypt Password
$api->sendApiRequest($api::DECRYPT_PASSWORD, $encryptedPassword);

