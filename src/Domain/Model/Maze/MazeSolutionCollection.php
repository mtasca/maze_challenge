<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

use MazeChallenge\Application\Exception\MazeSolutionNotFoundException;

class MazeSolutionCollection
{

    /**
     * @var array
     */
    private $collection;

    public function __construct()
    {
        $this->collection = [];
    }

    public function addMazeSolution(MazeSolution $solution) : void
    {
        $this->collection[] = $solution;
    }

    public function getFirstInProgressSolution() : MazeSolution
    {
        foreach ($this->collection as $solution) {
            if($solution->getStatus()->isInProgress()){
                return $solution;
            }
        }
        throw new MazeSolutionNotFoundException();
    }

    public function existsInProgressSolution() : bool
    {
        foreach ($this->collection as $solution) {
            if($solution->getStatus()->isInProgress()){
                return true;
            }
        }
        return false;
    }

    public function count()
    {
        return count($this->collection);
    }

    public function toArray(?MazeSolutionStatus $status = null) : array
    {
        $array_response = [];
        foreach ($this->collection as $item) {
            if(!is_null($status) && $status->getValue() !== $item->getStatus()->getValue()){
                continue;
            }
            $array_response[] = $item->toArray();
        }
        return $array_response;
    }

    public function toArrayWithSolutionMatrix(?MazeSolutionStatus $status = null, int $rows_size, int $columns_size) : array
    {
        $array_response = [];
        foreach ($this->collection as $item) {
            if(!is_null($status) && $status->getValue() !== $item->getStatus()->getValue()){
                continue;
            }
            $array_response[] = $item->toArrayWithSolutionMatrix($rows_size, $columns_size);
        }
        return $array_response;
    }
}