<?php

declare(strict_types=1);

namespace App\Renderer\Exception;

use Exception;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\ErrorHandler\Renderer\PlainTextRenderer;
use Yiisoft\Http\Status;

use App\Response\ResponseDataFactory;

final class SimpleExceptionRenderer
{
    public function __construct(
        private LoggerInterface $logger,
        private ResponseDataFactory $responseDataFactory,
        private DataResponseFactoryInterface $dataResponseFactory
    ) {}

    public function __invoke(Exception $e, int $status = Status::INTERNAL_SERVER_ERROR): ResponseInterface
    {
        $this->logger->error(PlainTextRenderer::throwableToString($e), ['exception' => $e, 'category' => get_class($e)]);

        $responseData = $this->responseDataFactory->createResponseData()
            ->setStatus($status)
            ->setMessage($e->getMessage() ?: Status::TEXTS[$status]);

        if ($code = $e->getCode()) {
            $responseData->setReason($code);
        }

        return $this->dataResponseFactory->createResponse(data: $responseData, code: $status);
    }
}
