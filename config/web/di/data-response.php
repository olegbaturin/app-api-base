<?php

declare(strict_types=1);

use Yiisoft\DataResponse\DataResponseFormatterInterface;
use Yiisoft\DataResponse\Formatter\JsonDataResponseFormatter;

/* @var $params array */

return [
    DataResponseFormatterInterface::class => JsonDataResponseFormatter::class,
];
