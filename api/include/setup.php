<?php

/**
 * @file
 * Setup.
 */

include __DIR__ . '/settings.php';
include __DIR__ . '/functions.php';

$_link = mysqli_connect($host, $login, $passwd, $db);
