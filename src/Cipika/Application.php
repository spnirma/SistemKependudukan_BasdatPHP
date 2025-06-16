<?php

namespace Cipika;

use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

class Application
{
    /**
     * Singleton instance.
     *
     * @var Application
     */
    private static $instance;

    /**
     * Service container.
     *
     * @var ContainerBuilder
     */
    private $container;

    /**
     * Block object creation.
     *
     */
    private function __construct()
    {
    }

    /**
     * Get singleton instance.
     *
     * @return Application
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
            self::$instance->initContainer();
        }

        return self::$instance;
    }

    /**
     * Get service container.
     *
     * @return ContainerBuilder
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Initialize service container.
     */
    private function initContainer()
    {
        $cachedContainerFile = __DIR__ . '/../../var/cache/cached_service_container.php';

        if (file_exists($cachedContainerFile)) {
            require_once $cachedContainerFile;
            return $this->container = new \CachedServiceContainer();
        }

        $containerFactory = new DependencyInjection\ContainerFactory();
        $this->container  = $containerFactory->createContainer();

        $applicationExtension = new DependencyInjection\ApplicationExtension();
        $this->container->registerExtension($applicationExtension);
        $this->container->loadFromExtension($applicationExtension->getAlias());

        $registerListenersPass = new RegisterListenersPass(
            'cipika.event_dispatcher',
            'cipika.event_listener',
            'cipika.event_subscriber'
        );
        $this->container->addCompilerPass($registerListenersPass);

        $this->container->compile();

        $dumper = new PhpDumper($this->container);
        file_put_contents(
            $cachedContainerFile,
            $dumper->dump(array('class' => 'CachedServiceContainer'))
        );
    }
}
