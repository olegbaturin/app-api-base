<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;

use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Reader\Iterable\IterableDataReader;
use Yiisoft\Router\HydratorAttribute\RouteArgument;

use App\Renderer\EntityRenderer;
use App\Presenter\FooPresenter;
use App\Presenter\FooListPresenter;
use App\Renderer\PaginatorRenderer;

class FooController
{
    public const PER_PAGE = 25;

    public function index(
        PaginatorRenderer $renderer,
        FooListPresenter $presenter,
        #[RouteArgument('page')] int $pageNum = 1
    ): ResponseInterface
    {
        $data = [
            (object) ['id' => 1, 'name' => 'foo name1', 'status' => 1, 'address' => 'foo address1', 'desc' => 'foo comment1'],
            (object) ['id' => 2, 'name' => 'foo name2', 'status' => 2, 'address' => 'foo address2', 'desc' => 'foo comment2'],
        ];
        $sort = Sort::only(['id', 'name'])->withOrder(['name' => 'asc']);
        $dataReader = (new IterableDataReader($data))->withSort($sort);
        $paginator = (new OffsetPaginator($dataReader))
            ->withPageSize(self::PER_PAGE)
            ->withCurrentPage($pageNum);

        return $renderer->render($paginator, $presenter);
    }

    public function view(
        EntityRenderer $renderer,
        FooPresenter $presenter,
        #[RouteArgument('id')] int $id,
    ): ResponseInterface
    {
        $data = (object) [
            'id' => $id,
            'name' => "foo{$id} name",
            'status' => 1,
            'address' => "foo{$id} address",
            'desc' => "foo{$id} comment"
        ];

        return $renderer->render($data, $presenter);
    }
}
