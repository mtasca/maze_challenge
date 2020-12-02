<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

use MazeChallenge\Application\Exception\InvalidArgumentValueException;
use MazeChallenge\Application\Exception\MissingArgumentException;
use MazeChallenge\Domain\Foundation\Entity\ValueObject;

final class MazeType extends ValueObject
{
    const CHARACTERS  = 'characters';

    public function __construct($value)
    {
        if(empty($value)) {
            throw new MissingArgumentException();
        }

        if(!in_array($value, $this->getValidTypes())){
            throw new InvalidArgumentValueException();
        }

        $this->value = $value;
    }

    private function getValidTypes()
    {
        return [
            self::CHARACTERS,
        ];
    }

    public function isLettersType()
    {
        return $this->getValue() === self::LETTERS;
    }

}