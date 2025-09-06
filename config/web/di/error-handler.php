<?php

declare(strict_types=1);

use Yiisoft\ErrorHandler\ThrowableRendererInterface;

use App\Renderer\Error\ErrorJsonRenderer;

/**
 * @var array $params
 */

return [
    ThrowableRendererInterface::class => ErrorJsonRenderer::class,
];
