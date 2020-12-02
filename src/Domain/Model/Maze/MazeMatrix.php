<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

use MazeChallenge\Application\Exception\MazeNodeNotFoundException;

class MazeMatrix
{

    /**
     * @var array
     */
    private $matrix;

    public function __construct()
    {
        $this->matrix = [];
    }

    public function addNode(MazeNode $node) : void
    {
        $this->matrix[$node->getRow()][$node->getColumn()] = $node;
    }

    /**
     * @param int $row
     * @param int $column
     * @return MazeNode
     * @throws MazeNodeNotFoundException
     */
    public function getNode(int $row, int $column) : MazeNode
    {
        if (isset($this->matrix[$row][$column])) {
            return $this->matrix[$row][$column];
        } else {
            throw new MazeNodeNotFoundException();
        }
    }

    public function getRowsSize() : int
    {
        return count($this->matrix);
    }

    public function getColumnsSize() : int
    {
        $max_size = 0;
        foreach ($this->matrix as $v) {
            $size = count($v);
            if($max_size < $size) {
                $max_size = $size;
            }
        }
        return $max_size;
    }
}