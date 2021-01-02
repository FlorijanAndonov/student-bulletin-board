<?php

namespace Domain;

use Utility\DB;

/**
 * Class Grade
 * @package Domain
 *
 * @property DB $db
 * @property int id
 */
class Grade implements ModelInterface
{
    const ID = 'id';
    const VALUE = 'value';
    const STUDENT_ID = 'student_id';

    private DB $db;
    private $id;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getById()
    {
        // TODO: Implement getById() method.
    }

    /**
     * @param array|null $data
     * @return $this|array
     */
    public function populateModel(?array $data)
    {
        if (is_null($data)) {
            $this->populateModel = true;
            return $this;
        }

        $grades = [];
        foreach ($data['list'] as $board) {
            $this->name = (string)$board['name'];
            $this->passing_average = (int)$board['passing_average'];
            $this->return_format = (string)$board['return_format'];
            $this->discard_lowest = (boolean)$board['discard_lowest'];
            $grades[] = $this;
        }

        return $grades;
    }

    public function getStudentsGrades(int $studentId)
    {
        $sql = "SELECT `value` FROM `grades` WHERE `student_id` = :studentId";
        $arguments = [
            'studentId' => $studentId
        ];
        return $this->db->read($sql, $arguments);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}