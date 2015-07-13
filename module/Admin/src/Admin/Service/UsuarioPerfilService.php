<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Admin\Service;

use Core\Service\BaseService;

class UsuarioPerfilService extends BaseService
{
    public function getUsuarioPerfil()
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT
                  tu.nom_usuario
                 ,p.des_perfil
                 ,tu.des_email
                 ,up.seq_usuario_perfil
                 ,up.seq_usuario
                 ,up.seq_perfil
                FROM tb_usuario tu
                INNER JOIN tb_usuario_perfil up on up.seq_usuario = tu.seq_usuario
                INNER JOIN tb_perfil p on p.seq_perfil = up.seq_perfil ";
        $res = $repository->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);
        return $res;
    }
}