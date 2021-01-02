<?php

namespace Domain;

use Utility\DB;

class Grade
{
    const ID = 'id';
    const VALUE = 'value';
    const STUDENT_ID = 'student_id';
    /**
     * @var DB
     */
    private DB $db;

    public function __construct(int $id)
    {
        $this->db = new DB;
    }
}