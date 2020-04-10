<?php

/**
 * Environment variable
 */

$ENV = [
    'DB_NAME' => 'gittossuto_api',
    'DB_SERVERNAME' => 'localhost',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => 'P4ssword123**',
];

foreach ($ENV as $k => $v) {
    putenv("$k=$v");
}