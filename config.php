<?php

/**
 * Configuration for database connection
 *
 */

$host       = "localhost";
$username   = "stockAppFinal";
$password   = "cpsc3042018";
$dbname     = "stockAppFinal";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
