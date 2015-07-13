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

class PessoaJuridicaForm extends Form
{
    public function __construct()
    {
        parent::__construct('novoPessoaJuridica');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('action', '/admin/pessoa-juridica/create');

        $seqPessoa = new Element\Hidden('seqPessoa');

        $nomFantasia = new Element\Text('nomFantasia');
        $nomFantasia->setName('nomFantasia')
            ->setAttribute('id', 'nomFantasia')
            ->setAttribute('placeholder', 'Nome de Fantasia')
            ->setAttribute('class', 'form-control')
            ->setLabel('Nome de fantasia')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $numCnpj = new Element\Password('numCnpj');
        $numCnpj->setName('numCnpj')
            ->setAttribute('id', 'numCnpj')
            ->setAttribute('placeholder', 'CNPJ')
            ->setAttribute('class', 'form-control')
            ->setLabel('CNPJ')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
            ->setAttribute('class', 'btn btn-info');

        $this->add($seqPessoa)
            ->add($nomFantasia)
            ->add($numCnpj)
            ->add($submit);
    }
}