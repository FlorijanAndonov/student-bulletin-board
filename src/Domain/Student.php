<?php


namespace Domain;

use Services\BoardService;
use Services\GradeService;
use Utility\DB;
use Utility\Exceptions\Student\StudentException;

/**
 * Class Student
 * @package Domain
 *
 * @property int $id;
 * @property string $name;
 * @property int $board_id;
 * @property bool $populateModel;
 * @property bool $passed;
 * @property Board $board;
 * @property array $grades;
 */
class Student implements ModelInterface
{
    const NAME = "name";
    const ID = "id";
    const BOARD_ID = "board_id";

    private $id;
    private $db;
    private $populateModel = false;

    public $name;
    public $board_id;
    public $grades = [];
    public bool $passed;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getBoardRelation(int $id): Board
    {
        $boardService = new BoardService();
        return $boardService->getBoard($id);
    }

    /**
     * @return array|Student
     * @throws StudentException
     */
    public function getById()
    {
        if (empty($this->id)) {
            throw new StudentException('Invalid Student Id', 10001);
        }
        $sql = "SELECT `name`,`board_id` FROM `students` WHERE id = :studentId";
        $arguments = [
            'studentId' => $this->id
        ];

        if ($this->populateModel) {
            return $this->populateModel($this->db->read($sql, $arguments));
        }

        return $this->db->read($sql, $arguments);
    }

    public function setPassedFlag(bool $flag): void
    {
        $this->passed = $flag;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param array|null $data
     * @return $this
     */
    public function populateModel(?array $data): Student
    {
        if (is_null($data)) {
            $this->populateModel = true;
            return $this;
        }
        foreach ($data['list'] as $student) {
            $this->name = $student['name'];
            $this->board_id = $student['board_id'];
        }

        $this->board = $this->getBoardRelation($this->board_id);
        $this->grades = $this->getGrades();

        return $this;
    }

    private function getGrades()
    {
        $gradeService = new GradeService();
        return $gradeService->getStudentGrades($this->id);
    }
}