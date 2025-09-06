<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;

use Yiisoft\DataResponse\DataResponseFactoryInterface;

final class PingAction
{
    public function __invoke(
        DataResponseFactoryInterface $responseFactory
    ): ResponseInterface {
        return $responseFactory->createResponse();
    }
}
