<?php

/**
 * This file is part of the EnriseUserAdLdap Module (https://github.com/RobQuistNL/EnriseUserAdLdap)
 *
 * Copyright (c) 2013 Rob Quist (https://github.com/RobQuistNL/EnriseUserAdLdap)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.txt that was distributed with this source code.
 */

namespace EnriseUserAdLdap;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
require_once (dirname(__FILE__) . "/vendor/adLDAP/lib/adLDAP/adLDAP.php");

class Module {

    /**
     * Bootstrapper for module
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e) 
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * Get the autoloader configuration
     * @return array $autoloaderconfig
     */
    public function getAutoloaderConfig() 
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * get Service config
     * @return $serviceConfig array|null|\EnriseUserAdLdap\Options\ModuleOptions|\EnriseUserAdLdap\Mapper\User|\ZfcUser\Mapper\User
     */
    public function getServiceConfig() 
    {
        return array(
            'invokables' => array(
                'EnriseUserAdLdap\Authentication\Adapter\Ldap' => 'EnriseUserAdLdap\Authentication\Adapter\Ldap',
            ),
            'factories' => array(
                'zfcuser_ldap_service' => 'EnriseUserAdLdap\ServiceFactory\Ldap',
                'ldap_interface' => 'EnriseUserAdLdap\ServiceFactory\LdapServiceFactory',
                'zfcuser_module_options' => function ($sm) {
                    $config = $sm->get('Configuration');
                    return new Options\ModuleOptions(isset($config['zfcuser']) ? $config['zfcuser'] : array());
                },
                'zfcuser_user_mapper' => function ($sm) {
                    return new \EnriseUserAdLdap\Mapper\User(
                            $sm->get('ldap_interface'), $sm->get('zfcuser_module_options')
                    );
                },
                'zfcuser_user_db_mapper' => function ($sm) {
                    $options = $sm->get('zfcuser_module_options');
                    $mapper = new \ZfcUser\Mapper\User();
                    $mapper->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
                    $entityClass = $options->getUserEntityClass();
                    $mapper->setEntityPrototype(new $entityClass);
                    $mapper->setHydrator(new \ZfcUser\Mapper\UserHydrator());
                    return $mapper;
                },
            ),
        );
    }

    /**
     * Include the module config
     */
    public function getConfig() 
    {
        return include __DIR__ . '/config/module.config.php';
    }

}
