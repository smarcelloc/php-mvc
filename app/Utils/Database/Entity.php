<?php

namespace App\Utils\Database;

use PDO;
use PDOException;

class Entity extends ConnectDB
{
  private array $params = [];

  private string $where;
  private string $select;
  private string $limit;
  private string $order;
  private string $group;

  public function __construct(private string $table)
  {
    $this->createConnection();
  }

  public function execute(string $query, array $params = [])
  {
    $statement = $this->getPDO()->prepare($query);
    $statement->execute($params);

    return $statement;
  }

  public function insert(array $data)
  {
    $fields = array_keys($data);
    $binds = array_pad([], count($data), '?');
    $values = array_values($data);

    $query = sprintf(
      'INSERT INTO %s (%s) VALUES (%s)',
      $this->table,
      implode(',', $fields),
      implode(',', $binds)
    );

    $this->execute($query, $values);

    return $this->getPDO()->lastInsertId();
  }

  public function update(array $data)
  {
    $fields = array_keys($data);
    $values = array_values($data);

    $query = sprintf(
      'UPDATE %s SET %s=? %s',
      $this->table,
      implode('=?,', $fields),
      $this->where
    );

    $this->execute($query, array_merge($values, $this->params));
  }

  public function delete()
  {
    $query = sprintf('DELETE FROM %s %s', $this->table, $this->where);
    $this->execute($query, $this->params);
  }

  public function get(int $mode = PDO::FETCH_DEFAULT)
  {
    $query = $this->querySelect();
    $statement = $this->execute($query, $this->params);

    return $statement->fetchAll($mode);
  }

  public function count(string $count = '*'): int
  {
    return $this->select("COUNT($count) as query_count")->first(PDO::FETCH_OBJ)->query_count;
  }

  public function first(int $mode = PDO::FETCH_DEFAULT)
  {
    $query = $this->querySelect();
    $statement = $this->execute($query, $this->params);

    return $statement->fetch($mode);
  }

  public function select(string $select = '*')
  {
    $this->select = "SELECT $select";
    return $this;
  }

  public function whereLike(string $like, mixed $params, string $operator = 'AND')
  {
    $paramsValues = is_array($params) ? array_values($params) : [$params];
    $patternLike = '/(["|\'].*?["|\'])/';

    if (!preg_match_all($patternLike, $like, $matches)) {
      throw new PDOException("ERROR: Must inform the substitution parameter of LIKE, for example '%?%'");
    }

    $newParams = [];
    for ($i = 0; $i < count($matches[0]); $i++) {
      $deleteCommasInKey = preg_replace('/(\'|")/', "", $matches[0][$i]);
      $newParams[] = str_replace('?', strval($paramsValues[$i]), $deleteCommasInKey);
    }

    $query = preg_replace($patternLike, '?', $like);

    return $this->where($query, $newParams, $operator);
  }

  public function where(string $where, mixed $params, string $operator = 'AND')
  {
    $paramsValues = is_array($params) ? array_values($params) : [$params];

    $this->where = empty($this->where) ? "WHERE $where" : "{$this->where} $operator $where";
    $this->params = empty($this->params) ? $paramsValues : array_merge($this->params, $paramsValues);

    return $this;
  }

  public function group(string $group)
  {
    $this->group = "GROUP BY $group";
    return $this;
  }

  public function limit(int $limit)
  {
    $this->limit = "LIMIT $limit";
    return $this;
  }

  public function offset(int $offset)
  {
    $this->limit = "$this->limit OFFSET $offset";
    return $this;
  }

  public function order(string $order)
  {
    $this->order = "ORDER BY $order";
    return $this;
  }

  private function querySelect()
  {
    return sprintf(
      '%s FROM %s %s %s %s %s',
      $this->select ?? 'SELECT *',
      $this->table,
      $this->where ?? '',
      $this->group ?? '',
      $this->order ?? '',
      $this->limit ?? ''
    );
  }
}
