<?php

declare(strict_types=1);

//use DomainException;

use Yiisoft\Data\Paginator\PaginatorException;
use Yiisoft\DataResponse\Middleware\FormatDataResponse;
use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Definitions\Reference;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\ErrorHandler\Middleware\ExceptionResponder;
use Yiisoft\Http\Status;
use Yiisoft\Input\Http\HydratorAttributeParametersResolver;
use Yiisoft\Input\Http\RequestInputParametersResolver;
use Yiisoft\Middleware\Dispatcher\CompositeParametersResolver;
use Yiisoft\Middleware\Dispatcher\MiddlewareDispatcher;
use Yiisoft\Middleware\Dispatcher\ParametersResolverInterface;
use Yiisoft\RequestProvider\RequestCatcherMiddleware;
use Yiisoft\Router\Middleware\Router;
use Yiisoft\Yii\Http\Application;
use Yiisoft\Yii\Middleware\Subfolder;

use App\Exception\EntityNotFoundException;
use App\Handler\ApplicationFallbackHandler;
use App\Renderer\Exception\InputValidationExceptionRenderer;
use App\Renderer\Exception\SimpleExceptionRenderer;

/** @var array $params */

return [
    Application::class => [
        '__construct()' => [
            'dispatcher' => DynamicReference::to([
                'class' => MiddlewareDispatcher::class,
                'withMiddlewares()' => [
                    [
                        RequestCatcherMiddleware::class,
                        FormatDataResponse::class,
                        ErrorCatcher::class,
                        ExceptionResponder::class,
                        Subfolder::class,
                        Router::class,
                    ],
                ],
            ]),
            'fallbackHandler' => Reference::to(ApplicationFallbackHandler::class),
        ],
    ],

    ExceptionResponder::class => [
        '__construct()' => [
            'exceptionMap' => [
                PaginatorException::class => Status::NOT_FOUND,
                EntityNotFoundException::class => Status::NOT_FOUND,
                DomainException::class => static fn (DomainException $exception, SimpleExceptionRenderer $renderer) => $renderer($exception, Status::BAD_REQUEST),
                InputValidationException::class => static fn (InputValidationException $exception, InputValidationExceptionRenderer $renderer) => $renderer($exception),
            ]
        ],
    ],

    ParametersResolverInterface::class => [
        'class' => CompositeParametersResolver::class,
        '__construct()' => [
            Reference::to(HydratorAttributeParametersResolver::class),
            Reference::to(RequestInputParametersResolver::class),
        ],
    ],
];
