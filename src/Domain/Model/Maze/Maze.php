<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

use MazeChallenge\Application\Exception\InvalidMazeMatrixException;
use MazeChallenge\Domain\Foundation\Entity\Entity;
use MazeChallenge\Domain\Foundation\Entity\EntityIdInterface;
use MazeChallenge\Domain\Model\EntityType;

class Maze extends Entity
{

    /**
     * @var MazeType
     */
    private $maze_type;

    /**
     * @var MazeSequence
     */
    private $sequence;

    /**
     * @var MazeEntrance
     */
    private $entrance;

    /**
     * @var MazeNode
     */
    private $entrance_node;

    /**
     * @var MazeExit
     */
    private $exit;

    /**
     * @var MazeNode
     */
    private $exit_node;

    /**
     * @var MazeMatrix
     */
    private $matrix;

    /**
     * @var MazeSolutionCollection
     */
    private $solutions;

    public function __construct(EntityIdInterface $id, MazeType $maze_type, MazeSequence $sequence, MazeEntrance $entrance, MazeExit $exit)
    {
        $this->maze_type = $maze_type;
        $this->sequence  = $sequence;
        $this->entrance  = $entrance;
        $this->exit      = $exit;

        $this->matrix = new MazeMatrix();
        $this->entrance_node = null;
        $this->exit_node = null;

        parent::__construct($id, []);
    }

    public function getType(): string
    {
        return EntityType::MAZE;
    }

    /**
     * @return MazeType
     */
    public function getMazeType(): MazeType
    {
        return $this->maze_type;
    }

    /**
     * @param MazeType $maze_type
     */
    public function setMazeType(MazeType $maze_type): void
    {
        $this->maze_type = $maze_type;
    }

    /**
     * @return MazeSequence
     */
    public function getSequence(): MazeSequence
    {
        return $this->sequence;
    }

    /**
     * @param MazeSequence $sequence
     */
    public function setSequence(MazeSequence $sequence): void
    {
        $this->sequence = $sequence;
    }

    /**
     * @return MazeEntrance
     */
    public function getEntrance(): MazeEntrance
    {
        return $this->entrance;
    }

    /**
     * @param MazeEntrance $entrance
     */
    public function setEntrance(MazeEntrance $entrance): void
    {
        $this->entrance = $entrance;
    }

    /**
     * @return MazeNode
     */
    public function getEntranceNode(): MazeNode
    {
        return $this->entrance_node;
    }

    /**
     * @param MazeNode $entrance_node
     */
    public function setEntranceNode(MazeNode $entrance_node): void
    {
        $this->entrance_node = $entrance_node;
    }

    /**
     * @return MazeExit
     */
    public function getExit(): MazeExit
    {
        return $this->exit;
    }

    /**
     * @param MazeExit $exit
     */
    public function setExit(MazeExit $exit): void
    {
        $this->exit = $exit;
    }

    /**
     * @return MazeNode
     */
    public function getExitNode(): MazeNode
    {
        return $this->exit_node;
    }

    /**
     * @param MazeNode $exit_node
     */
    public function setExitNode(MazeNode $exit_node): void
    {
        $this->exit_node = $exit_node;
    }

    /**
     * @return MazeMatrix
     */
    public function getMatrix(): MazeMatrix
    {
        return $this->matrix;
    }

    /**
     * @param MazeMatrix $matrix
     */
    public function setMatrix(MazeMatrix $matrix): void
    {
        $this->matrix = $matrix;
    }

    /**
     * @return MazeSolutionCollection
     */
    public function getSolutions(): MazeSolutionCollection
    {
        return $this->solutions;
    }

    /**
     * @param MazeSolutionCollection $solutions
     */
    public function setSuccessSolution(MazeSolutionCollection $solutions): void
    {
        $this->solutions = $solutions;
    }

    public function toArray(): array
    {
        return [
            "type" => $this->type->getValue(),
            "sequence" => $this->sequence->getValue(),
            "entrance" => $this->entrance->getValue(),
            "exit" => $this->exit->getValue(),
            "maze" => $this->maze->toArray(),
            "solutions" => $this->solutions->toArray(),
        ];
    }

    /**
     * @param array $matrix
     */
    public function setMazeMatrixFromArray(array $matrix) : void
    {
        $row = 0;
        $rows_size = count($matrix);

        foreach ($matrix as $v) {
            $column = 0;
            $columns_size = count($v);
            foreach ($v as $node_value) {
                $node = new MazeNode($node_value, $row, $column);
                $this->matrix->addNode($node);

                //check if it is a border node it is a entrance or exit candidate
                if($row == 0 || $row == $rows_size-1 || $column == 0 || $column == $columns_size-1) {
                    if(is_null($this->entrance_node)
                        && $node->getValue() == $this->entrance->getValue()) {
                        $this->setEntranceNode($node);
                    } elseif (is_null($this->exit_node) && $node->getValue() == $this->exit->getValue()) {
                        $this->setExitNode($node);
                    }
                }
                ++$column;
            }
            ++$row;
        }

        if(is_null($this->entrance_node)) {
            throw new InvalidMazeMatrixException('Entrance node not found');
        }
        if(is_null($this->exit_node)) {
            throw new InvalidMazeMatrixException('Exit node not found');
        }
    }
}