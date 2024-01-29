<?php

namespace Bank\App\DB;

use Bank\App\DB\DataBase;
use PDO;

class MariaBase implements DataBase
{
    private $pdo = null;
    private $tableName = null;

    public function __construct($name){
        $host = 'localhost';
        $db   = "php_bank";
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';
        
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $user, $pass, $options);
        $this->tableName = $name;
}

    public function create(object $data) : int
    {
        $sql = "
            INSERT INTO {$this->tableName} (id, name, surname, id_code, iban, balance, deleted )
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$data->id, $data->name, $data->surname, $data->id_code, $data->iban, $data->balance, $data->deleted]);

        return $this->pdo->lastInsertId();
    }
    
    public function update(int $id, object $data) : bool
    {
        $sql = "
            UPDATE {$this->tableName}
            SET balance = ?, deleted = ?
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$data->balance, $data->deleted, $id]);
    }
    
    public function delete(int $id) : bool
    {
        $sql = "
            UPDATE {$this->table}
            SET deleted = true
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }
    
    public function show(int $id) : object
    {
        $sql = "
            SELECT *
            FROM {$this->tableName}
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$id]);

        $acc = $stmt->fetch();
        $acc = (object)$acc;
        return $acc;
    }
    
    public function showAll() : array
    {
        $sql = "
            SELECT *
            FROM {$this->tableName}
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll();
    }
}