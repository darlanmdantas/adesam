<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\DBAL\DriverManager;

class BaseController extends AbstractActionController
{
    protected $entityManager;

    /**
     * @return array|object
     */
    protected function getEntityManager()
    {
    	if (null === $this->entityManager)
    	{
    		$this->entityManager = $this->getService('Doctrine\ORM\EntityManager');
    	}
    	return $this->entityManager;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function getDbalConnection()
    {
    	$config = new \Doctrine\DBAL\Configuration;

    	$params = $this->getService('Config');
    	$params = $params['doctrine']['connection']['orm_default']['params'];

    	return DriverManager::getConnection($params, $config);
    }

    /**
     * @param $service
     * @return array|object
     */
    protected function getService($service)
    {
    	return $this->getServiceLocator()->get($service);
    }

    /**
     * @return array|object
     */
    protected function getServiceReport(){
        return $this->getService('Core\Service\ReportService');
    }
}
