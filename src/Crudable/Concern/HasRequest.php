<?php

namespace Rekamy\LaravelCore\Crudable\Concerns;

use Rekamy\LaravelCore\Contracts\CrudableRequest;

trait HasRequest
{
    public function registerRequest(CrudableRequest $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

}
