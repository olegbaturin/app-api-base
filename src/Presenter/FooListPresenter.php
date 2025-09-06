<?php

declare(strict_types=1);

namespace App\Presenter;

use App\Resource\FooResource;

final class FooListPresenter implements PresenterInterface
{
    public function present(object $entity): FooResource
    {
        $resource = new FooResource(
            id: (string) $entity->id,
            name: $entity->name,
        );

        $resource->setComment($entity->desc);

        return $resource;
    }
}
