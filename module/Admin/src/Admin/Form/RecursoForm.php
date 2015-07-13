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

class RecursoForm extends Form
{
    public function __construct()
    {
        /* solucao do problema do campo do tipo select, caso tenha em algum form*/
        $this->setUseInputFilterDefaults(false);

        parent::__construct('novoRecurso');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('action', '/admin/recurso/create');

        $seqRecurso = new Element\Hidden('seqRecurso');

        $desRecurso = new Element\Text('desRecurso');
        $desRecurso->setName('desRecurso')
            ->setAttribute('id', 'desRecurso')
            ->setAttribute('placeholder', 'Nome do Recurso')
            ->setAttribute('class', 'form-control')
            ->setLabel('Nome do recurso')
            ->setLabelAttributes(array('class' => 'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
            ->setAttribute('class', 'btn btn-info');

        $this->add($seqRecurso)
            ->add($desRecurso)
            ->add($submit);
    }
}