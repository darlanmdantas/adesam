<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Core\Service;

use Zend\Crypt\Password\Bcrypt;
use Zend\Session\Container as SessionContainer;

class AuthService extends BaseService
{
    /**
     * função de autenticação do sistema
     * @param $params
     * @return bool
     */
    public function authenticate($params)
    {

        if (!isset($params['nomUsuario']) || $params['nomUsuario'] == '' || !isset($params['desSenha']) ||  $params['desSenha'] == '') {
            return false;
        }

        $user = $this->getService()
            ->getRepository('Admin\Entity\TbUsuario')
            ->getUserAuth($params);

        $user = current($user);

        if ($user) {
            $bcrypt = new Bcrypt();
            $verify = $bcrypt->verify($params['desSenha'], $user->getDesSenha());

            if ($verify) {
                $session = $this->getServiceManager()->get('Session');
                $session->offsetSet('zf2base_loggeduser', $user);
                return true;
            }
        }
        return false;
    }

    /**
     * função de verificação se usuário esta logado
     * @return bool
     */
    public function isLogged()
    {
        $session = $this->getServiceManager()->get('Session');
        $user = $session->offsetGet('zf2base_loggeduser');
        if ( isset($user) ) {
            return true;
        }
        return false;
    }

    /**
     * função para realizar o logout do sistema.
     * @return bool
     */
    public function logout()
    {
        $session = $this->getServiceManager()->get('Session');
        $session->offsetUnset('zf2base_loggeduser');
        return true;
    }
}