<?php

namespace Utility;

use PDO;
use PDOException;

class DB extends PDO
{

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

    public function write(string $sql, ?array $arguments = null)
    {
        try {
            $data = [];
            if (is_null($arguments)) {
                $this->exec($sql);
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

    public function read(string $sql, ?array $arguments = null)
    {
        $data = null;
        try {

            if (is_null($arguments)) {
                $stmt = $this->query($sql);
                $data['list'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $data['total'] = $stmt->rowCount();
                $data['success'] = true;
            } else {
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $stmt = $this->prepare($sql);
                $stmt->execute($arguments);
                $data['success'] = true;
                $data['total'] = $stmt->rowCount();
                $data['list'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $data;
        } catch (PDOException $exception) {
            return 'PDOError: ' . $sql . ' ' . $exception->getCode() . " Query Message: " . $exception->getMessage();
        }
    }
}