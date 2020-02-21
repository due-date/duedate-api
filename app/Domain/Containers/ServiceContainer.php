<?php

namespace App\Domain\Containers;

class ServiceContainer
{
    private $service;

    public function getService($service)
    {
        return $this->service[$service];
    }

    public function addService($service)
    {
        $this->service[get_class($service)] = $service;
    }
}
