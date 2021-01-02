<?php

namespace Domain;

use Utility\DB;

/**
 * Class Board
 * @package Domain
 *
 * @property int $id
 * @property string $name
 * @property string $passing_average
 * @property string $return_format
 */
class Board
{
    const ID = 'id';
    const NAME = 'name';
    const PASSING_AVERAGE = 'passing_average';
    const RETURN_FORMAT = 'return_format';

    private DB $db;

    public function __construct(int $id)
    {
        $this->db = new DB();
    }
}