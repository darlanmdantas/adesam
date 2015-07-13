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

class PessoaForm extends Form
{
    public function __construct()
    {
        parent::__construct('novoPessoa');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('action', '/admin/pessoa/create');

        $seqPessoa = new Element\Hidden('seqPessoa');

        $nomPessoa = new Element\Text('nomPessoa');
        $nomPessoa->setName('nomPessoa')
            ->setAttribute('id', 'nomPessoa')
            ->setAttribute('placeholder', 'Nome')
            ->setAttribute('class', 'form-control')
            ->setLabel('Nome')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $tipPessoa = new Element\Radio('tipPessoa');
        $tipPessoa->setName('tipPessoa')
            ->setAttribute('id', 'tipPessoa')
            ->setAttribute('class', 'form-control')
            ->setLabel('Sexo')
            ->setOptions(array(
                'F' => 'Pessoa Fisíca',
                'J' => 'Pessoa Jurídica',
            ))
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
            ->setAttribute('class', 'btn btn-info');

        $this->add($seqPessoa)
            ->add($nomPessoa)
            ->add($tipPessoa)
            ->add($submit);
    }
}