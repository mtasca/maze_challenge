<?php
declare(strict_types=1);

namespace MazeChallenge\Application\Response;

use Fig\Http\Message\StatusCodeInterface;

class BadRequestResponse extends ApiResponse
{
    public function __construct(array $data = [], int $status = StatusCodeInterface::STATUS_BAD_REQUEST, array $headers = [])
    {
        parent::__construct($data, $status, $headers);
    }
}