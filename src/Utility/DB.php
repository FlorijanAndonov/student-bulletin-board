<?php

namespace Utility;

use PDO;
use PDOException;

class DB extends PDO
{
    private $connection;

    private string $user = 'root';
    private string $pasword = 'Root123!@#';
    private string $host = 'localhost';
    private string $charset = 'utf8mb4';
    private string $db = 'student_board';

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            parent::__construct($dsn, $this->user, $this->pasword, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function read($sql, $arguments)
    {
        try {
            $data = [];
            if (is_null($arguments)) {
                $this->query($sql);
                $data['success'] = true;
                $data['insert_id'] = $this->lastInsertId();
            } else {
                $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->prepare($sql);

                if (count($arguments) !== count($arguments, COUNT_RECURSIVE)) {
                    foreach ($arguments as $paramArr) {
                        $stmt->execute($paramArr);
                        $data['affected_rows'][] = $stmt->rowCount();
                        $data['success'][] = true;
                        $data['insert_id'][] = $this->lastInsertId();
                    }
                } else {
                    $stmt->execute($arguments);
                    $data['affected_rows'] = $stmt->rowCount();
                    $data['success'] = true;
                    $data['insert_id'] = $this->lastInsertId();
                }

            }

            return $data;
        } catch (PDOException $exception) {
            return 'PDOError: ' . $sql . ' ' . $exception->getCode() . " Query Message: " . $exception->getMessage();
        }
    }


}