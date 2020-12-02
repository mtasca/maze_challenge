<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

use MazeChallenge\Application\Exception\MazeNodeNotFoundException;

class MazeSolution
{

    /**
     * @var array
     */
    private $path;

    /**
     * @var MazeSolutionStatus
     */
    private $status;

    /**
     * @var int
     */
    private $sequence_index;

    public function __construct()
    {
        $this->path = [];
        $this->status = new MazeSolutionStatus(MazeSolutionStatus::INPROGRESS);
    }

    public function addNode(MazeNode $node) : void
    {
        $this->path[] = $node;
    }

    /**
     * @param int $row
     * @param int $column
     * @return MazeNode
     * @throws MazeNodeNotFoundException
     */
    public function getNode(int $row, int $column) : MazeNode
    {
        foreach ($this->path as $node) {
            if ($node->getRow() == $row && $node->getColumn() == $column) {
                return $node;
            }
        }
        throw new MazeNodeNotFoundException();
    }

    public function getLastNode()
    {
        return $this->path[count($this->path) - 1];
    }

    public function getStatus() : MazeSolutionStatus
    {
        return $this->status;
    }

    public function setStatus(MazeSolutionStatus $status) : void
    {
        $this->status = $status;
    }

    public function setSequenceIndex(int $index)
    {
        $this->sequence_index = $index;
    }

    /**
     * @return int
     */
    public function getSequenceIndex(): int
    {
        return $this->sequence_index;
    }

    public function toArray() : array
    {
        $path = [];
        foreach ($this->path as $node) {
            $path[] = $node->toArray();
        }
        return [
            'status' => $this->status->getValue(),
            'path' => $path,
        ];
    }

    public function toArrayWithSolutionMatrix(int $rows_size, int $columns_size) : array
    {
        $path = [];
        foreach ($this->path as $node) {
            $path[] = $node->toArray();
        }
        return [
            'status' => $this->status->getValue(),
            'matrix' => $this->getSolutionMatrix($rows_size, $columns_size),
            'path' => $path,
        ];
    }

    public function getSolutionMatrix(int $rows_size, int $columns_size)
    {
        $matrix = [];
        // create a matrix only with -
        for($i = 0; $i < $rows_size; $i++) {
            for ($j = 0; $j < $columns_size; $j++){
                $matrix[$i][$j] = "-";
            }
        }
        //fulfill the matrix with the solution path
        foreach ($this->path as $node) {
            $matrix[$node->getRow()][$node->getColumn()] = $node->getValue();
        }
        //implode to text
        for($i = 0; $i < $rows_size; $i++) {
            $matrix[$i] = implode($matrix[$i], "|");
        }

        return $matrix;
    }
}