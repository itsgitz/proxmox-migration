<?php

/**
 * Environment variable
 * 
 * copy this file and rename it to `env.php`
 */

$ENV = [
    'DB_NAME' => '',
    'DB_SERVERNAME' => '',
    'DB_USERNAME' => '',
    'DB_PASSWORD' => '',
    'WHMCS_API_IDENTIFIER' => '',
    'WHMCS_API_SECRET' => '',
    'WHMCS_API_URL' => '',
];

foreach ($ENV as $k => $v) {
    putenv("$k=$v");
}