<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Http\Status;

use App\Response\ResponseDataFactory;

final class CsrfFailureHandler implements RequestHandlerInterface
{
    public function __construct(
        private ResponseDataFactory $responseDataFactory,
        private DataResponseFactoryInterface $dataResponseFactory
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $responseData = $this->responseDataFactory->createResponseData()
            ->setStatus(Status::UNPROCESSABLE_ENTITY)
            ->setMessage(Status::TEXTS[Status::UNPROCESSABLE_ENTITY]);

        return $this->dataResponseFactory->createResponse(data: $responseData, code: Status::UNPROCESSABLE_ENTITY);
    }
}
