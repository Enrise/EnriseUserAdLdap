<?php
/**
 * This file is part of the EnriseUserAdLdap Module (https://github.com/RobQuistNL/EnriseUserAdLdap)
 *
 * Copyright (c) 2013 Rob Quist (https://github.com/RobQuistNL)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.txt that was distributed with this source code.
 */
namespace EnriseUserAdLdap\Mapper;


use ZfcUser\Mapper\User as ZfcUserMapper;
use EnriseUserAdLdap\Options\ModuleOptions;
use EnriseUserAdLdap\Service\LdapInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class User extends ZfcUserMapper
{
    /** 
     * @var \EnriseUserAdLdap\Service\LdapInterface 
     */
    protected $ldap;
    
    /**
     * @var \EnriseUserAdLdap\Options\ModuleOptions
     */
    protected $options;

    /**
     * Constructor
     * @param LdapInterface $ldap
     * @param ModuleOptions $options
     */
    public function __construct(LdapInterface $ldap, ModuleOptions $options)
    {
        $this->ldap      = $ldap;
        $this->options = $options;
        $entityClass = $this->options->getUserEntityClass();
        $this->entity = new $entityClass();
    }

    /**
     * @see \ZfcUser\Mapper\User::findByUsername()
     */
    public function findByUsername($username)
    {
        return $this->entity;
    }
    
    /**
     * @see \ZfcUser\Mapper\User::findById()
     */
    public function findById($id)
    {
        return $this->entity;
    }

    /**
     * @see \ZfcUser\Mapper\User::findByEmail()
     */
    public function findByEmail($email)
    {
        return $this->entity;
    }
    
    /**
     * getEntity
     * 
     * @return EnriseUserAdLdap\Entity\User
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * Authenticate the user, using the ADLDAP class
     * 
     * @param string $identity
     * @param string $credential
     * @return \EnriseUserAdLdap\Mapper\User|boolean
     */
    public function authenticate($identity, $credential)
    {
        $auth = $this->ldap->authenticate($identity, $credential);
        if ($auth !== false) {
            $this->entity->setDisplayName($auth[0]['displayname'][0]);
            
            //@TODO Make the mail domain configurable
            if (isset($auth[0]['mail'][0])) {
                $mail_exp = explode('.', $auth[0]['mail'][0]);
            } else {
                $mail_exp[0] = 'enrise';
                $mail_exp[1] = 'com';
            }
            $this->entity->setEmail($auth[0]['samaccountname'][0] . '@' . $mail_exp[count($mail_exp)-2] . '.' . $mail_exp[count($mail_exp)-1]);
            
            $this->entity->setId($auth[0]['objectsid'][0]);
            $this->entity->setUsername($auth[0]['samaccountname'][0]);
            return $this; 
       } else {
           return false;
       }
    }

    /**
     * @see \ZfcUser\Mapper\User::insert()
     */
    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        return false;
    }

    /**
     * @see \ZfcUser\Mapper\User::update()
     */
    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        return false;
    }
}