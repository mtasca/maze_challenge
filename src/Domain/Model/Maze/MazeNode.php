<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

class MazeNode
{

    /**
     * @var string
     */
    private $value;

    /**
     * @var int
     */
    private $row;

    /**
     * @var int
     */
    private $column;

    public function __construct($value, $row, $column)
    {
        $this->value = $value;
        $this->row = $row;
        $this->column = $column;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * @param int $row
     */
    public function setRow(int $row): void
    {
        $this->row = $row;
    }

    /**
     * @return int
     */
    public function getColumn(): int
    {
        return $this->column;
    }

    /**
     * @param int $column
     */
    public function setColumn(int $column): void
    {
        $this->column = $column;
    }

    public function equals(self $node) : bool
    {
        return $this->getValue() == $node->getValue()
            && $this->getRow() == $node->getRow()
            && $this->getColumn() == $this->getColumn();
    }

    public function toArray() : array
    {
        return [
            'row' => $this->getRow(),
            'column' => $this->getColumn(),
            'value' => $this->getValue()
        ];
    }

}