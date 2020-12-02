<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

use MazeChallenge\Application\Exception\InvalidArgumentValueException;
use MazeChallenge\Application\Exception\MissingArgumentException;
use MazeChallenge\Domain\Foundation\Entity\ValueObject;

final class MazeSequence extends ValueObject
{

    public function __construct($value)
    {
        if(empty($value)) {
            throw new MissingArgumentException();
        }

        $this->value = $value;
    }

    public function getCharacter(int $position)
    {
        return $this->getCleanValue()[$position];
    }

    public function getLength()
    {
        return strlen($this->getCleanValue());
    }

    private function getCleanValue()
    {
        return str_replace('-', '', $this->value);
    }

}