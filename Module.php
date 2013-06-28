<?php

namespace SpeckCartCookie;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use SpeckCart\Service\CartEvent;
use Zend\EventManager\SharedEventManager;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $cookieService = $e->getApplication()->getServiceManager()->get('speckcartcookie_cartcookie_service');

        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE, array($cookieService, 'retrieveCartVerifierCookie'), -50);

        // Attach the cart create and delete events to the shared event manager
        $sem = $e->getApplication()->getEventManager()->getSharedManager();
        $sem->attach('SpeckCart\Service\CartService', CartEvent::EVENT_CREATE_CART_POST, array($cookieService, 'setCartVerifierCookie'));
        $sem->attach('SpeckCart\Service\CartService', CartEvent::EVENT_DELETE_CART_POST, array($cookieService, 'removeCartVerifierCookie'));
    }


    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'speckcartcookie_cartcookieveririfer_mapper' => function($sm) {
                    $mapper = new Mapper\CartCookieVerifierMapper;
                    $mapper->setDbAdapter($sm->get('speckcartcookie_db'));
                    return $mapper;
                },
                'speckcartcookie_cartcookie_service' => function($sm) {
                    $service = new Service\CartCookie();
                    $service->setRequest($sm->get('request'));
                    $service->setResponse($sm->get('response'));
                    $service->setCookieVerifierMapper($sm->get('speckcartcookie_cartcookieveririfer_mapper'));
                    $service->setCookieConfig($sm->get('config')['speckcartcookie']);
                    return $service;
                }
            ),
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
