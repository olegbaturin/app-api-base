<?php

declare(strict_types=1);

use Yiisoft\Auth\Middleware\Authentication;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;

use App\Controller\FooController;
use App\Controller\IndexAction;
use App\Controller\PingAction;
use App\Exception\EntityNotFoundException;

/**
 * @var array $params
 */

return [
    Route::get('/')
        ->action(IndexAction::class)
        ->name('app/index'),
    Route::get('/ping')
        ->name('app.ping')
        ->action(PingAction::class),

    Route::get('/missed-entity')
        ->name('app/missed-entity')
        ->action(static fn() => throw new EntityNotFoundException(code: 801)),
    Route::get('/domain-error')
        ->name('app/domain-error')
        ->action(static fn() => throw new DomainException(message: 'Domain logic failed!', code: 101)),

    Group::create('/foo')->routes(
        Route::get('[/page{page:\d+}]')
            ->name('foo.index')
            ->action([FooController::class, 'index']),
        Route::get('/{id:\d+}')
            ->name('foo.view')
            ->action([FooController::class, 'view']),
    ),
];
