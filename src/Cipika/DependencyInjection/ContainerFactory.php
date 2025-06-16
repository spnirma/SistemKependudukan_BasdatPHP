<?php

namespace Cipika\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class ContainerFactory
{
    /**
     * Create container.
     *
     * @return ContainerBuilder
     */
    public function createContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }
}
