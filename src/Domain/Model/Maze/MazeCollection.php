<?php
declare(strict_types=1);

namespace MazeChallenge\Domain\Model\Maze;

use MazeChallenge\Application\Exception\InvalidArgumentException;
use MazeChallenge\Domain\Foundation\Entity\EntityCollection;
use MazeChallenge\Domain\Foundation\Entity\EntityInterface;

class MazeCollection extends EntityCollection
{
    public function addEntity(EntityInterface $entity) : void
    {
        if(!($entity instanceof Maze)){
            throw new InvalidArgumentException();
        }
        parent::addEntity($entity);
    }
}