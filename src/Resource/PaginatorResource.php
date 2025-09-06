<?php

declare(strict_types=1);

namespace App\Resource;

final readonly class PaginatorResource
{
    public function __construct(
        public int $page,
        public int $size,
    ) {}

    public int $count;
    public int $pages;

    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function setPages(int $pages): void
    {
        $this->pages = $pages;
    }
}
