<?php
/**
 * Autoloader for classmaps.
 */
return array(
    'EnriseUserAdLdap\Module'                            => __DIR__ . '/Module.php',
    'EnriseUserAdLdap\Authentication\Adapter\Ldap'       => __DIR__ . '/src/EnriseUserAdLdap/Authentication/Adapter/Ldap.php',
    'EnriseUserAdLdap\Entity\User'                       => __DIR__ . '/src/EnriseUserAdLdap/Entity/User.php',
    'EnriseUserAdLdap\Mapper\User'                       => __DIR__ . '/src/EnriseUserAdLdap/Mapper/User.php',
    'EnriseUserAdLdap\Options\ModuleOptions'             => __DIR__ . '/src/EnriseUserAdLdap/Options/ModuleOptions.php',
    'EnriseUserAdLdap\Service\LdapService'               => __DIR__ . '/src/EnriseUserAdLdap/Service/LdapService.php',
    'EnriseUserAdLdap\ServiceFactory\LdapServiceFactory' => __DIR__ . '/src/EnriseUserAdLdap/ServiceFactory/LdapServiceFactory.php',
);