<?php

declare(strict_types = 1);

class CommandRegisterRoutes implements ICommand
{
    private Kernel $kernel;
    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $this->kernel->routeCollection = require __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routing.php';
        $this->kernel->containerBuilder->set('route_collection', $this->kernel->routeCollection);
    }

}
