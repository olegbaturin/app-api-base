<?php

declare(strict_types=1);

use Yiisoft\DataResponse\Formatter\JsonDataResponseFormatter;
use Yiisoft\DataResponse\Formatter\XmlDataResponseFormatter;

return [
    'yiisoft/input-http' => [
        'requestInputParametersResolver' => [
            'throwInputValidationException' => true,
        ],
    ],

    'yiisoft/data-response' => [
        'contentFormatters' => [
            'application/json' => JsonDataResponseFormatter::class,
            'application/xml' => XmlDataResponseFormatter::class,
        ],
    ],
];
