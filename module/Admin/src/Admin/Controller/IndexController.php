<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{

    /**
     * @return array|ViewModel
     */
	public function indexAction()
    {
        return new ViewModel();
    }
}