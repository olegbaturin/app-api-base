<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;

use App\ApplicationParams;
use App\Renderer\DataRenderer;
use App\Resource\AboutResource;

final class IndexAction
{
    public function __invoke(
        DataRenderer $dataRenderer,
        ApplicationParams $applicationParams,
    ): ResponseInterface {
        $data = new AboutResource(
            name: $applicationParams->name,
            version: $applicationParams->version,
        );

        return $dataRenderer->render($data);
    }
}
