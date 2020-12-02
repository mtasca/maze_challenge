<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

use MazeChallenge\Application\Exception\InvalidArgumentValueException;
use MazeChallenge\Application\Exception\MissingArgumentException;
use MazeChallenge\Domain\Foundation\Entity\ValueObject;

final class MazeSolutionStatus extends ValueObject
{
    const INPROGRESS = 'in_progress';
    const SUCCESS = 'success';
    const FAILED = 'failed';

    public function __construct($value)
    {
        if(empty($value)) {
            throw new MissingArgumentException();
        }

        if(!in_array($value, $this->getValidStatuses())){
            throw new InvalidArgumentValueException();
        }

        $this->value = $value;
    }

    private function getValidStatuses()
    {
        return [
            self::INPROGRESS,
            self::SUCCESS,
            self::FAILED
        ];
    }

    public function isInProgress()
    {
        return $this->getValue() === self::INPROGRESS;
    }
    public function isFailed()
    {
        return $this->getValue() === self::FAILED;
    }

    public function isSuccess()
    {
        return $this->getValue() === self::SUCCESS;
    }

}