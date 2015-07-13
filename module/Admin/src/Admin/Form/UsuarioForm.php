<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UsuarioForm extends Form
{
    public function __construct()
    {
        parent::__construct('novousuario');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('action', '/admin/usuarios/create');

        $seqUsuario = new Element\Hidden('seqUsuario');
        $seqUsuarioCadastrou = new Element\Hidden('seqUsuarioCadastrou');

        $nomUsuario = new Element\Text('nomUsuario');
        $nomUsuario->setName('nomUsuario')
            ->setAttribute('id', 'nomUsuario')
            ->setAttribute('placeholder', 'Nome do usuário')
            ->setAttribute('class', 'form-control')
            ->setLabel('Nome do usuário')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $desSenha = new Element\Password('desSenha');
        $desSenha->setName('desSenha')
            ->setAttribute('id', 'desSenha')
            ->setAttribute('placeholder', 'Senha')
            ->setAttribute('class', 'form-control')
            ->setLabel('Senha')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
            ->setAttribute('class', 'btn btn-info');

        $this->add($seqUsuario)
            ->add($seqUsuarioCadastrou)
            ->add($nomUsuario)
            ->add($desSenha)
            ->add($submit);
    }
}