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

class UsuarioPerfilRecursoForm extends Form
{
    public function __construct()
    {
        /* solucao do problema do campo do tipo select, caso tenha em algum form*/
        $this->setUseInputFilterDefaults(false);

        parent::__construct('novoUsuarioPerfilRecurso');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('action', '/admin/perfil-usuario-recurso/create');

        $seqUsuario = new Element\Select('seqUsuario');
        $seqUsuario->setName('seqUsuario')
            ->setAttribute('id', 'seqUsuario')
            ->setAttribute('placeholder', 'Usuário')
            ->setAttribute('class', 'form-control')
            ->setLabel('Usuário')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'))
            ->setEmptyOption('Selecione o usuário');

        $seqRecurso = new Element\Select('seqRecurso');
        $seqRecurso->setName('seqRecurso')
            ->setAttribute('id', 'seqRecurso')
            ->setAttribute('placeholder', 'Recurso')
            ->setAttribute('class', 'form-control')
            ->setLabel('Recurso')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'))
            ->setEmptyOption('Selecione o recurso');

        $seqPerfil = new Element\Select('seqPerfil');
        $seqPerfil->setName('seqPerfil')
            ->setAttribute('id', 'seqPerfil')
            ->setAttribute('placeholder', 'Perfil')
            ->setAttribute('class', 'form-control')
            ->setLabel('Perfil')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'))
            ->setEmptyOption('Selecione o perfil');

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
            ->setAttribute('class', 'btn btn-info');

        $this->add($seqUsuario)
            ->add($seqRecurso)
            ->add($seqPerfil)
            ->add($submit);
    }
}