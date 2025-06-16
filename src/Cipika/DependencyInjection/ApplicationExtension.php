<?php

namespace Cipika\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Extension\Extension;

class ApplicationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator(__DIR__ . '/../Resources/config');
        $xmlLoader = new XmlFileLoader(
            $container,
            $fileLocator
        );

        $envConfigPath = __DIR__ . '/../../../application/config/' . ENVIRONMENT;
        $envConfigFile = $envConfigPath . '/services.xml';

        $xmlLoader->load('services.xml');
 
        if (is_file($envConfigFile)) {
            $fileLocator = new FileLocator($envConfigPath);
            $xmlLoader = new XmlFileLoader(
                $container,
                $fileLocator
            );
            $xmlLoader->load('services.xml');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'cipika';
    }
}
