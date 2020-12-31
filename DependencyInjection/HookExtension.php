<?php

namespace ScyLabs\HookBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HookExtension extends Extension
{
    public function __construct() {

    }

    public function load(array $configs,ContainerBuilder $container){

        $bundleRoot = new FileLocator(dirname(__DIR__));
        $loader = new YamlFileLoader($container,$bundleRoot);
        $loader->load('Resources/config/services.yaml');

    }
}