<?php
namespace Core;

use Core\ErrorHandler;

require_once __DIR__ . '/Settings/settings.php';

class DB extends \PDO
{
    const FETCH_ALL = 'all';
    const FETCH_ONE = 'one';
    
    private $pdo;
    private $errorHandler;

    public function __construct()
    {
        $this->errorHandler = new ErrorHandler();
        $this->pdo = $this->connect();
    }

    /**
     * Запрос с самописным sql запросом(для более сложных запросов)
     */
    public function select_with_sql($table, $sql, $params = [], $fetch = self::FETCH_ALL)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        if ($fetch == self::FETCH_ALL) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function select($table, array $where = [], $fetch = self::FETCH_ALL)
    {
        if (!empty($where)) {
            $pdo_masks = $this->genPDOMasks($where);
            $sql = sprintf("SELECT * FROM %s WHERE %s", $table, $pdo_masks);
        } else {
            $sql = sprintf("SELECT * FROM %s", $table);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($where);

        if ($fetch === self::FETCH_ALL) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function insert($table, array $params)
    {
        $columns = sprintf('(%s)', implode(', ', array_keys($params)));
        $pdo_masks = sprintf('(:%s)', implode(', :', array_keys($params)));
        $sql = sprintf("INSERT INTO %s %s VALUES %s", $table, $columns, $pdo_masks);
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }

    public function delete($table, $where)
    {
        $pdo_masks = $this->genPDOMasks($where);
        $sql = sprintf("DELETE FROM %s WHERE %s", $table, $pdo_masks);

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($where);
    }

    public function update($table, array $set, array $where)
    {
        $pdo_masks = $this->genPDOMasks($set);

        $param = [];
		foreach ($where as $key => $value) {
			$param[] = "$key=$value";
		}
		$where = implode(', ', $param);
        
        $sql = sprintf("UPDATE %s SET %s WHERE %s", $table, $pdo_masks, $where);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($set);
    }

    /**
     * Генерирует pdo шаблон
     * 
     * @return string
     */
    private function genPDOMasks(array $params)
    {
        $pdo_masks = [];
        foreach (array_keys($params) as $param) {
            $pdo_masks[] = $param . '=:' . $param;
        }
        $pdo_masks = implode(" AND ", $pdo_masks);
        
        return $pdo_masks;
    }

    private function connect()
    {
        $dsn = sprintf("mysql:host=%s;dbname=%s", DB['host'], DB['db_name']);
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];

        try {
            $pdo = new \PDO($dsn, DB['login'], DB['password'], $opt);
            return $pdo;
        } catch (\PDOException $e) {
            $this->errorHandler->error500();
            exit();
        }
    }

}
