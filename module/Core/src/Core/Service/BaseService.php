<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Core\Service;

use DoctrineORMModule\Options\EntityManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Doctrine\DBAL\DriverManager;

abstract class BaseService implements ServiceManagerAwareInterface
{
    protected $serviceManager;
    protected $entityManager;

    /**
     * função seta o serviço
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * função retorna o gerenciamento do serviço
     * @return mixed
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * função retorna o serviço
     * @param $service
     * @return mixed
     */
    public function getService($service = null)
    {
        if (!$service) {
            return $this->getServiceManager()->get('doctrine.entitymanager.orm_default');
        }
        return $this->getServiceManager()->get($service);
    }

    /**
     * função retorna a entity
     * @return mixed
     */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = $this->getService('Doctrine\ORM\EntityManager');
        }
        return $this->entityManager;
    }

    /**
     * função
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function getDbalConnection()
    {
        $config = new \Doctrine\DBAL\Configuration;

        $params = $this->getServiceManager()->get('Config');
        $params = $params['doctrine']['connection']['orm_default']['params'];

        return DriverManager::getConnection($params, $config);
    }
}