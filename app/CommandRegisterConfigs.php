<?php

declare(strict_types = 1);

use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;

class CommandRegisterConfigs implements ICommand
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
        try {
            $fileLocator = new FileLocator(__DIR__ . DIRECTORY_SEPARATOR . 'config');
            $loader = new PhpFileLoader($this->kernel->containerBuilder, $fileLocator);
            $loader->load('parameters.php');
        } catch (Throwable $e) {
            die('Cannot read the config file. File: ' . __FILE__ . '. Line: ' . __LINE__);
        }
    }
}
