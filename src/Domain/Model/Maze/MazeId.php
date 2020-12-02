<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

use MazeChallenge\Domain\Foundation\Entity\EntityId;
use MazeChallenge\Domain\Model\EntityType;

class MAzeId extends EntityId
{
    public function isValid($id) : bool
    {
        if(!is_string($id)) {
            return false;
        }

        return true;
    }

    public function getType(): string
    {
        return EntityType::MAZE;
    }


}