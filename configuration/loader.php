<?php

require __DIR__ . '/env.php';

/**
 * php autoloader
 */
spl_autoload_register(function ($class_name)
{
  $parts = explode('\\', $class_name);
  include './class/class.' . end($parts) . '.php';
});