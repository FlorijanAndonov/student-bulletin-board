<?php

namespace Services;

use Domain\Board;
use Utility\Exceptions\Board\BoardException;

/**
 * Class BoardService
 * @package Services
 *
 * @property Board $board;
 */
class BoardService
{
    private $board;

    public function __construct()
    {
        $this->board = new Board();
    }

    public function getBoard(int $id): Board
    {
        try {
            $this->board->setId($id);
            return $this->board->populateModel(null)->getById($id);
        } catch (BoardException $exception) {
            die("error ".$exception->getMessage());
        }
    }

}