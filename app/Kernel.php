<?php

declare(strict_types = 1);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;

class Kernel
{
    /**
     * @var RouteCollection
     */
    public RouteCollection $routeCollection;

    /**
     * @var ContainerBuilder
     */
    public ContainerBuilder $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $registerConfigs = new CommandRegisterConfigs($this);
        $registerRoutes = new CommandRegisterRoutes($this);
        $process = new CommandProcess($this, $request);
        $invoker = new Invoker();
        $invoker->action($registerConfigs);
        $invoker->action($registerRoutes);
        return $invoker->action($process);
    }
}
