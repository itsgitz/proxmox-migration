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
];

foreach ($ENV as $k => $v) {
    putenv("$k=$v");
}