<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Path;
use Vigihdev\FakerReflection\Exceptions\FakerReflectionException;
use VigihDev\SymfonyBridge\Config\ConfigBridge;

final class AppKernel
{

    private const PACKAGE_NAME = 'faker-reflection';
    private const VENDOR_PACKAGE_NAME = 'vendor/vigihdev/faker-reflection';

    public function __construct(
        private readonly string $basepath,
        private readonly array $envFilenames = ['.env'],
    ) {

        $this->boot();
    }

    private function boot(): void
    {
        $basepath = $this->actualBasepath($this->basepath);

        if (!is_dir($basepath)) {
            throw FakerReflectionException::directoryNotFound((string) $basepath);
        }

        $fileService = Path::join($basepath, 'config', 'services.yaml');
        if (!is_file($fileService)) {
            throw FakerReflectionException::fileNotFound((string) $fileService);
        }

        // define PROJECT_DIR
        if (!defined('PROJECT_DIR')) {
            define('PROJECT_DIR', realpath($basepath));
        }

        // Load env
        $envDefaults = ['PROJECT_DIR' => realpath($basepath)];
        $dotEnv = new Dotenv();
        $dotEnv->usePutenv(true);
        $dotEnv->populate($envDefaults, true);

        // boot container
        $container = ConfigBridge::boot(
            basePath: $basepath,
            configDir: 'config',
            enableAutoInjection: true
        );

        // load env
        foreach ($this->envFilenames as $filename) {
            $envPath = Path::join($basepath, $filename);
            if (is_file($envPath)) {
                $container->loadEnv($envPath);
            }
        }
    }

    private function actualBasepath(string $basepath): string
    {

        $basepath = realpath($basepath);
        if ($basepath === false) {
            throw FakerReflectionException::directoryNotFound((string) $basepath);
        }

        $basename = pathinfo($basepath, PATHINFO_BASENAME);
        if ($basename === self::PACKAGE_NAME && is_dir(Path::join($basepath, 'vendor'))) {
            return $basepath;
        }

        $basepath = Path::join($basepath, self::VENDOR_PACKAGE_NAME);
        if (!is_dir($basepath)) {
            throw FakerReflectionException::directoryNotFound((string) $basepath);
        }

        return $basepath;
    }
}
