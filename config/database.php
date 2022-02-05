<?php

use App\Utils\Database\ConnectDB;
use App\Utils\Env;

$dsn = sprintf(
  'mysql:host=%s;port=%s;dbname=%s',
  Env::get('DB_HOST', 'localhost'),
  Env::get('DB_PORT', 3306),
  Env::get('DB_NAME')
);

ConnectDB::load($dsn, Env::get('DB_USER'), Env::get('DB_PASSWORD'), [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
]);
