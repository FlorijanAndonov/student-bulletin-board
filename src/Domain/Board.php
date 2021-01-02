<?php

namespace Domain;

use Utility\DB;
use Utility\Exceptions\Board\BoardException;

/**
 * Class Board
 * @package Domain
 *
 * @property int $id
 * @property string $name
 * @property string $passing_average
 * @property string $return_format
 * @property boolean $discard_lowest
 * @property boolean $populateModel
 * @property int $minimum_grades
 */
class Board implements ModelInterface
{
    const ID = 'id';
    const NAME = 'name';
    const PASSING_AVERAGE = 'passing_average';
    const RETURN_FORMAT = 'return_format';
    const DISCARD_LOWEST = 'discard_lowest';
    const MINIMUM_GRADES = 'minimum_grades';

    private DB $db;
    private $id;
    private $populateModel = false;

    public function __construct()
    {
        $this->db = new DB();
    }



    /**
     * @return array|Board
     * @throws BoardException
     */
    public function getById()
    {
        if (empty($this->id)) {
            throw new BoardException('Invalid Board Id', 10001);
        }
        $sql = "SELECT `name`,`passing_average`,`return_format`,`discard_lowest`,`minimum_grades` FROM `school_boards` WHERE id = :boardId";
        $arguments = [
            'boardId' => $this->id
        ];

        if ($this->populateModel) {
            return $this->populateModel($this->db->read($sql, $arguments));
        }

        return $this->db->read($sql, $arguments);
    }

    /**
     * @param array|null $data
     * @return Board
     */
    public function populateModel(?array $data): Board
    {

        if (is_null($data)) {
            $this->populateModel = true;
            return $this;
        }


        foreach ($data['list'] as $board) {
            $this->name = (string)$board['name'];
            $this->passing_average = (int)$board['passing_average'];
            $this->return_format = (string)$board['return_format'];
            $this->discard_lowest = (boolean)$board['discard_lowest'];
            $this->minimum_grades = (boolean)$board['minimum_grades'];
        }

        return $this;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}