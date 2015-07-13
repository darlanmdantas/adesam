<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Admin\Repository;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    public function getUserAuth($params)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.nomUsuario = :nomUsuario')->setParameter('nomUsuario', $params['nomUsuario'])
            ->andWhere('u.sitUsuario = :sitUsuario')->setParameter('sitUsuario', 'A');
        return $query->getQuery()->getResult();
    }
}

