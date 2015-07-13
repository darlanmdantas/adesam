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

class PessoaFisicaForm extends Form
{
    public function __construct()
    {
        parent::__construct('novoPessoaFisica');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('action', '/admin/pessoa-fisica/create');

        $seqPessoa = new Element\Hidden('seqPessoa');

        $numCpf = new Element\Text('numCpf');
        $numCpf->setName('numCpf')
            ->setAttribute('id', 'numCpf')
            ->setAttribute('placeholder', 'CPF')
            ->setAttribute('class', 'form-control')
            ->setLabel('CPF')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $numRg = new Element\Password('numRg');
        $numRg->setName('numRg')
            ->setAttribute('id', 'numRg')
            ->setAttribute('placeholder', 'RG')
            ->setAttribute('class', 'form-control')
            ->setLabel('RG')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $codSexo = new Element\Radio('codSexo');
        $codSexo->setName('codSexo')
            ->setAttribute('id', 'codSexo')
            ->setAttribute('class', 'form-control')
            ->setLabel('Sexo')
            ->setOptions(array(
                'F' => 'Feminino',
                'M' => 'Masculino',
            ))
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
            ->setAttribute('class', 'btn btn-info');

        $this->add($seqPessoa)
            ->add($numCpf)
            ->add($numRg)
            ->add($codSexo)
            ->add($submit);
    }
}