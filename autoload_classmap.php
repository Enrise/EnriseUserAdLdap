<?php
include (dirname(__FILE__) . "/vendor/adLDAP/lib/adLDAP/adLDAP.php");

return array(
    'EnriseUserAdLdap\Module'                            => __DIR__ . '/Module.php',
    'EnriseUserAdLdap\Authentication\Adapter\Ldap'       => __DIR__ . '/src/EnriseUserAdLdap/Authentication/Adapter/Ldap.php',
    'EnriseUserAdLdap\Entity\User'                       => __DIR__ . '/src/EnriseUserAdLdap/Entity/User.php',
    'EnriseUserAdLdap\Mapper\User'                       => __DIR__ . '/src/EnriseUserAdLdap/Mapper/User.php',
    'EnriseUserAdLdap\Options\ModuleOptions'             => __DIR__ . '/src/EnriseUserAdLdap/Options/ModuleOptions.php',
    'EnriseUserAdLdap\Service\LdapInterface'             => __DIR__ . '/src/EnriseUserAdLdap/Service/LdapInterface.php',
    'EnriseUserAdLdap\ServiceFactory\LdapServiceFactory' => __DIR__ . '/src/EnriseUserAdLdap/ServiceFactory/LdapServiceFactory.php',
);