<?php
declare(strict_types=1);

namespace MazeChallenge\HttpApi\Controller;

use MazeChallenge\Application\Exception\InvalidMazeMatrixException;
use MazeChallenge\Application\Service\MazeSolver\MazeSolverService;
use MazeChallenge\Domain\Model\Maze\MazeEntrance;
use MazeChallenge\Domain\Model\Maze\MazeExit;
use MazeChallenge\Domain\Model\Maze\MAzeId;
use MazeChallenge\Domain\Model\Maze\MazeSequence;
use MazeChallenge\Domain\Model\Maze\MazeSolutionStatus;
use MazeChallenge\Domain\Model\Maze\MazeType;
use MazeChallenge\Domain\Model\Maze\Maze;
use MazeChallenge\Application\Response\ApiResponse;
use MazeChallenge\Application\Response\BadRequestResponse;
use MazeChallenge\Domain\Model\Artist\ArtistName;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

class MazeController extends ApiController
{
    public function solve(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $maze_solver_service = $this->container->get(MazeSolverService::class);

        $body_request = json_decode($request->getBody()->getContents(), true);

        if(empty($body_request['type'])
            || empty($body_request['sequence'])
            || empty($body_request['entrance'])
            || empty($body_request['exit'])
            || empty($body_request['maze'])
        ){
            return new BadRequestResponse(['message' => 'invalid body request, please check the docs']);
        }

        try {
            $id = new MazeId(Uuid::uuid4()->toString());
            $type = new MazeType($body_request['type']);
            $sequence = new MazeSequence($body_request['sequence']);
            $entrance = new MazeEntrance($body_request['entrance']);
            $exit = new MazeExit($body_request['exit']);
            $maze = new Maze($id, $type, $sequence, $entrance, $exit);
            $maze->setMazeMatrixFromArray($body_request['maze']);
        } catch (InvalidMazeMatrixException $e) {
            return new BadRequestResponse(['message' => sprintf('Invalid Maze Matrix. %s', $e->getMessage())]);
        }

        $solutions = $maze_solver_service->solveMaze($maze);
        $successful_paths = $solutions->toArrayWithSolutionMatrix(
            new MazeSolutionStatus(MazeSolutionStatus::SUCCESS),
            $maze->getMatrix()->getRowsSize(),
            $maze->getMatrix()->getColumnsSize()
        );
        $failed_paths = $solutions->toArrayWithSolutionMatrix(
            new MazeSolutionStatus(MazeSolutionStatus::FAILED),
            $maze->getMatrix()->getRowsSize(),
            $maze->getMatrix()->getColumnsSize()
        );

        return new ApiResponse(
            [
                'paths_count' => $solutions->count(),
                'successful_solutions' => [
                    'paths_count' => count($successful_paths),
                    'successful_paths' => $successful_paths,
                ],
                'failed_solutions' => [
                    'paths_count' => count($failed_paths),
                    'failed_paths' => $failed_paths
                ]
            ]
        );
    }
}