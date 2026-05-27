<?php

namespace MyProject\Services;

class Db
{
    private $pdo;
    private static $instance;
    private static $instanceCount = 0;

    private function __construct()
    {
        self::$instanceCount++;

        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];
        $dbPath = __DIR__ . '/../../' . $dbOptions['dbname'];

        $this->pdo = new \PDO(
            'sqlite:' . $dbPath,
            null,
            null,
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]
        );

        $sqlFile = __DIR__ . '/../../../database.sql';
        if (file_exists($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            $this->pdo->exec($sql);
        }
    }

    public function query(string $sql, $params = [], string $className = \stdClass::class): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        if ($className !== \stdClass::class) {
            $sth->setFetchMode(\PDO::FETCH_CLASS, $className);
        }
        return $sth->fetchAll();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
