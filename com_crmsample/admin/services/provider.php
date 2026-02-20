<?php
defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Component\Router\RouterFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use CrmSample\Component\Crmsample\Administrator\Extension\CrmsampleComponent;

return new class implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $container->registerServiceProvider(new MVCFactory('\\CrmSample\\Component\\Crmsample'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\CrmSample\\Component\\Crmsample'));
        $container->registerServiceProvider(new RouterFactory('\\CrmSample\\Component\\Crmsample'));

        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new CrmsampleComponent(
                    $container->get(ComponentDispatcherFactoryInterface::class)
                );
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));
                $component->setRouterFactory($container->get(RouterFactoryInterface::class));

                return $component;
            }
        );
    }
};