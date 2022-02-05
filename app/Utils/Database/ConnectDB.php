<?php

namespace App\Utils\Database;

use PDO;

class ConnectDB
{
  private static string $dsn;
  private static string|null $user;
  private static string|null $password;
  private static array $options;

  private PDO|null $pdo = null;

  public static function load(
    string $dsn,
    ?string $user = null,
    ?string $password = null,
    array $options = []
  ) {
    self::$dsn = $dsn;
    self::$user = $user;
    self::$password = $password;
    self::$options = $options;

    self::testConnection();
  }

  public function getPDO()
  {
    return $this->pdo;
  }

  protected function createConnection()
  {
    $this->pdo = new PDO(self::$dsn, self::$user, self::$password, self::$options);
  }

  protected function closeConnection()
  {
    $this->pdo = null;
  }

  private static function testConnection()
  {
    new PDO(self::$dsn, self::$user, self::$password, self::$options);
  }
}
