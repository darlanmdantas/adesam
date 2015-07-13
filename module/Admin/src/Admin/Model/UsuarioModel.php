<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Admin\Model;

use Core\Model\BaseModel;

class UsuarioModel extends BaseModel
{
    public function __construct()
    {
        $this->setEntity('Admin\Entity\TbUsuario');
    }
}