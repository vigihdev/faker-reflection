<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Path;
use Vigihdev\FakerReflection\Exceptions\FakerReflectionException;
use VigihDev\SymfonyBridge\Config\ConfigBridge;

final class AppKernel
{

    public function __construct(
        private readonly string $basepath,
        private readonly array $envFilenames = ['.env'],
    ) {

        $this->boot();
    }

    private function boot(): void
    {

        if (!is_dir($this->basepath)) {
            throw FakerReflectionException::directoryNotFound((string) $this->basepath);
        }

        $fileService = Path::join($this->basepath, 'config', 'services.yaml');
        if (!is_file($fileService)) {
            throw FakerReflectionException::fileNotFound((string) $fileService);
        }

        // define PROJECT_DIR
        if (!defined('PROJECT_DIR')) {
            define('PROJECT_DIR', realpath($this->basepath));
        }

        // Load env
        $envDefaults = ['PROJECT_DIR' => realpath($this->basepath)];
        $dotEnv = new Dotenv();
        $dotEnv->usePutenv(true);
        $dotEnv->populate($envDefaults, true);

        // boot container
        $container = ConfigBridge::boot(
            basePath: $this->basepath,
            configDir: 'config',
            enableAutoInjection: true
        );

        // load env
        foreach ($this->envFilenames as $filename) {
            $envPath = Path::join($this->basepath, $filename);
            if (is_file($envPath)) {
                $container->loadEnv($envPath);
            }
        }
    }
}
