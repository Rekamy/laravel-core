<?php

namespace Rekamy\LaravelCore\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * FIXME:
 * This interface should specify as Builder Class abstraction
 *  - make() : build factory
 *  - get() : get factory instance
 *  - addStack() : add factory stack
 *
 */
interface CrudableBloc
{

    public function registerRequest(CrudableRequest $request);

    public function registerRepository(RepositoryInterface $repository);

    public function index(array $input);

    public function store(array $input);

    public function show(string $id);

    public function update(string $id, array $input);

    public function destroy(string $id);

    public static function permission(string $name);

}
