<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        $sharedEvents->attach(
            'Zend\Mvc\Controller\AbstractActionController',
            MvcEvent::EVENT_DISPATCH,
            array($this, 'controllerPreDispatch'),
            100
        );

        $translator = $e->getApplication()->getServiceManager()->get('MvcTranslator');
        $translator->addTranslationFile(
            'phpArray',
            'vendor/zendframework/zendframework/resources/languages/pt_BR/Zend_Validate.php'
        );

        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);

    }

    public function controllerPreDispatch($e)
    {
        $serviceLocator = $e->getTarget()->getServiceLocator();
        $routeMatch = $e->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');

        $controllerName = $routeMatch->getParam('controller');
        $controllerName = explode("\\", $controllerName);
        $controllerName = strtolower($controllerName[2]);

        $actionName = strtolower($routeMatch->getParam('action'));

        $authService = $serviceLocator->get('Core\Service\AuthorizationService');
        if (!$authService->grantAccess($moduleName, $controllerName, $actionName)) {
            $redirect = $e->getTarget()->redirect();

            $auth = $serviceLocator->get('Core\Service\AuthService');
            if ($auth->isLogged()) {
                $redirect->toUrl('/');
            } else {
                $redirect->toUrl('/application/auth');
            }
        }

        return true;
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
