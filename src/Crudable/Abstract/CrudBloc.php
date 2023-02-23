<?php

namespace Rekamy\LaravelCore\Crudable\Abstract;

use Rekamy\LaravelCore\Contracts\CrudableRequest;
use Rekamy\LaravelCore\Crudable\Concerns\CrudableBloc;
use Rekamy\LaravelCore\Crudable\Concerns\HasRepository;
use Rekamy\LaravelCore\Crudable\Concerns\HasRequest;

abstract class CrudBloc implements CrudableRequest
{
    use HasRepository, HasRequest, CrudableBloc;

    protected $moduleName;

}
