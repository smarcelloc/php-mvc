<?php

namespace App\Utils;

use Error;
use Exception;

class Env
{
  public static function load(string $filename)
  {
    if (!is_file($filename)) {
      throw new Exception("The file environment was not found $filename");
    }

    self::readFileEnv($filename);
  }

  public static function get(string $key, mixed $defaultValue = null)
  {
    $value = getenv($key);

    if ($value === false || $value === '') {
      return $defaultValue;
    }

    return self::defineTypeValue($value);
  }

  public static function isExist(string $key)
  {
    return getenv($key) !== false;
  }

  public static function isEmpty(string $key)
  {
    $value = getenv($key);

    return $value !== false ? empty($value) : true;
  }

  public static function required(string $key)
  {
    $value = self::get($key, null);

    if (is_null($value)) {
      throw new Error("You must enter a value for the variable {$key}", 1);
    }

    return $value;
  }

  private static function readFileEnv(string $filename)
  {
    $content = file($filename, FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES);

    foreach ($content as $line) {
      putenv(trim($line));
    }
  }

  private static function defineTypeValue(string $value)
  {
    return match ($value) {
      'true' => true,
      'false' => false,
      'null' => null,
      default => $value
    };
  }
}
