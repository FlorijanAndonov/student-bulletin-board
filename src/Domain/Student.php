<?php


namespace Domain;

use Utility\DB;

class Student
{
    const NAME = "name";
    const ID = "id";

    private $id;
    private $db;

    public function __construct(int $id)
    {
        $this->db = new DB;
    }

    public function getBoardRelation()
    {

    }

    public function getData()
    {

    }
}