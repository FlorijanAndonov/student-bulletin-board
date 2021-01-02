<?php


namespace Domain;

use Services\BoardService;
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
 */
class Student implements ModelInterface
{
    const NAME = "name";
    const ID = "id";
    const BOARD_ID = "board_id";

    private $id;
    private $db;
    private $populateModel = false;

    private $name;
    private $board_id;

    public function __construct()
    {
        $this->db = new DB;
    }

    public function getBoardRelation(int $id): Board
    {
        $boardService = new BoardService();
        return $boardService->getBoard($id);
    }

    /**
     * @return array|string
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
            $this->populateModel($this->db->read($sql, $arguments));
        }

        return $this->db->read($sql, $arguments);
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
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

        return $this;
    }
}