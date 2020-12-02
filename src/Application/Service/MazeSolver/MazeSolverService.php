<?php
declare(strict_types=1);

namespace MazeChallenge\Application\Service\MazeSolver;

use MazeChallenge\Application\Exception\MazeNodeNotFoundException;
use MazeChallenge\Application\Exception\MazeSolutionNotFoundException;
use MazeChallenge\Application\Exception\MethodNotImplementedException;
use MazeChallenge\Domain\Model\Maze\Maze;
use MazeChallenge\Domain\Model\Maze\MazeMatrixCollection;
use MazeChallenge\Domain\Model\Maze\MazeSolution;
use MazeChallenge\Domain\Model\Maze\MazeSolutionCollection;
use MazeChallenge\Domain\Model\Maze\MazeSolutionStatus;
use MazeChallenge\Domain\Model\Maze\MazeType;

class MazeSolverService
{
    public function solveMaze(Maze $maze) : MazeSolutionCollection
    {
        switch ($maze->getMazeType()->getValue()) {
            case MazeType::CHARACTERS:
                $solutions = $this->solveCharactersMaze($maze);
                break;
            default:
                throw new MethodNotImplementedException();
        }

        return $solutions;
    }

    private function solveCharactersMaze(Maze $maze) : MazeSolutionCollection
    {
        $entrance_node = $maze->getEntranceNode();
        $exit_node = $maze->getExitNode();
        $sequence = $maze->getSequence();
        $matrix = $maze->getMatrix();
        $rows_size = $matrix->getRowsSize();
        $columns_size = $matrix->getColumnsSize();

        $current_node = $entrance_node;

        $solutions = new MazeSolutionCollection();

        $in_progress_solution = new MazeSolution();
        $in_progress_solution->addNode($current_node);

        $solutions->addMazeSolution($in_progress_solution);

        do {
            for ($i = 0; $i < $sequence->getLength(); $i++) {
                $in_progress_solution->setSequenceIndex($i);
                $current_row = $current_node->getRow();
                $current_column = $current_node->getColumn();

                $next_character = $sequence->getCharacter($i);
                $neighbors = $this->getNeighbours($current_row, $current_column, $rows_size, $columns_size);

                $possible_next_nodes = [];
                foreach ($neighbors as $neighbor) {
                    $node = $matrix->getNode($neighbor[0], $neighbor[1]);

                    try {
                        $in_progress_solution->getNode($neighbor[0], $neighbor[1]);
                        // If the node is in the solution we should choose another path
                        continue;
                    } catch (MazeNodeNotFoundException $e){
                        // DO NOTHING
                    }

                    if ($node->getValue() == $next_character) {
                        //next node found
                        $possible_next_nodes[] = $node;
                    } elseif (!$node->equals($entrance_node) && $node->equals($exit_node)) {
                        $in_progress_solution->addNode($node);
                        $in_progress_solution->setStatus(new MazeSolutionStatus(MazeSolutionStatus::SUCCESS));
                    }

                }

                if($in_progress_solution->getStatus()->getValue() == MazeSolutionStatus::SUCCESS) {
                    try {
                        $in_progress_solution = $solutions->getFirstInProgressSolution();
                        $current_node = $in_progress_solution->getLastNode();
                        $i = $in_progress_solution->getSequenceIndex();
                        continue;
                    } catch (MazeSolutionNotFoundException $e) {
                        //All the solutions where analyzed
                        break;
                    }
                }

                if(empty($possible_next_nodes)){
                    $in_progress_solution->setStatus(new MazeSolutionStatus(MazeSolutionStatus::FAILED));
                    try {
                        $in_progress_solution = $solutions->getFirstInProgressSolution();
                        $current_node = $in_progress_solution->getLastNode();
                        $i = $in_progress_solution->getSequenceIndex();
                        continue;
                    } catch (MazeSolutionNotFoundException $e) {
                        //All the solutions where analyzed
                        break;
                    }
                }

                if(count($possible_next_nodes) > 1) {
                    for($j=1;$j<count($possible_next_nodes); $j++){
                        $s = clone $in_progress_solution;
                        $s->addNode($possible_next_nodes[$j]);
                        $solutions->addMazeSolution($s);
                    }
                }
                $in_progress_solution->addNode($possible_next_nodes[0]);
                $current_node = $possible_next_nodes[0];
            }

        } while($solutions->existsInProgressSolution());

        return $solutions;
    }


    /**
     * Possible Neighbours
     * Every node could have 8 neighbours
     * given a node row:r, column:c the possibilities are
     * | (r-1,c-1) | (r-1,c) | (r-1,c+1) |
     * |  (r,c-1)  |  (r,c)  |  (r,c+1)  |
     * | (r+1,c-1) | (r+1,c) | (r+!,c+1) |
     */
    private function getNeighbours(int $current_row, int $current_column, int $rows_size, int $columns_size) : array
    {
        $possible_neighbours[] = [$current_row - 1, $current_column - 1];
        $possible_neighbours[] = [$current_row - 1, $current_column];
        $possible_neighbours[] = [$current_row - 1, $current_column + 1];
        $possible_neighbours[] = [$current_row, $current_column - 1];
        $possible_neighbours[] = [$current_row, $current_column + 1];
        $possible_neighbours[] = [$current_row + 1, $current_column - 1];
        $possible_neighbours[] = [$current_row + 1, $current_column];
        $possible_neighbours[] = [$current_row + 1, $current_column + 1];

        // Remove invalid values
        foreach ($possible_neighbours as $key => $neighbour) {
            if($neighbour[0] < 0 || $neighbour[0] >= $rows_size || $neighbour[1] < 0 || $neighbour[1] >= $columns_size) {
                unset($possible_neighbours[$key]);
            }
        }

        return $possible_neighbours;
    }
}