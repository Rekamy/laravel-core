<?php

namespace Rekamy\LaravelCore\Crudable\Concerns;

use Prettus\Repository\Contracts\RepositoryInterface;

trait HasRepository
{
    public function registerRepository(RepositoryInterface $repository)
    {
        $this->repo = $repository;
    }

    public function getRepo()
    {
        return $this->repo;
    }


}
