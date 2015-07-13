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

class PerfilForm extends Form
{
    public function __construct()
    {
        /* solucao do problema do campo do tipo select, caso tenha em algum form*/
        $this->setUseInputFilterDefaults(false);

        parent::__construct('novoPerfil');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('action', '/admin/perfis/create');

        $seqPerfil = new Element\Hidden('seqPerfil');

        $nomPerfil = new Element\Text('nomPerfil');
        $nomPerfil->setName('nomPerfil')
            ->setAttribute('id', 'nomPerfil')
            ->setAttribute('placeholder', 'Nome do perfil')
            ->setAttribute('class', 'form-control')
            ->setLabel('Nome do perfil')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $desPerfil = new Element\Text('desPerfil');
        $desPerfil->setName('desPerfil')
            ->setAttribute('id', 'desPerfil')
            ->setAttribute('placeholder', 'Descrição do perfil')
            ->setAttribute('class', 'form-control')
            ->setLabel('Descrição do perfil')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
            ->setAttribute('class', 'btn btn-info');

        $this->add($seqPerfil)
            ->add($nomPerfil)
            ->add($desPerfil)
            ->add($submit);
    }
}