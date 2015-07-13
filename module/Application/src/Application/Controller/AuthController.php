<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\BaseController;
use Application\Form\Login;

class AuthController extends BaseController
{
    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $form = new Login();
        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * @return \Zend\Http\Response
     */
    public function loginAction()
    {

        $request = $this->getRequest();

        if (!$request->isPost()) {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso proibido!');
            return $this->redirect()->toUrl('/application/auth');
        }

        $data = $request->getPost();

        $service = $this->getService("Core\Service\AuthService");
        $auth = $service->authenticate(
            array(
                'nomUsuario' => $data['nomUsuario'],
                'desSenha' => $data['desSenha']
            )
        );

        if ($auth) {
            return $this->redirect()->toUrl('/admin');
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Usuário e/ou senha inválido(s)');
            return $this->redirect()->toUrl('/application/auth');
        }
    }

    /**
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $service = $this->getService('Core\Service\AuthService');
        $service->logout();
        return $this->redirect()->toUrl('/');
    }
}