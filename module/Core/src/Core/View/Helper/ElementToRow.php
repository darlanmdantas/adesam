<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Core\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\View\Helper;
use Zend\Form\ElementInterface;

class ElementToRow extends AbstractHelper
{

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $formLabel = new Helper\FormLabel();
        $formElement = new Helper\FormElement();
        $formErrors = new Helper\FormElementErrors();
        $view = $this->getView();
        $formElement->setView($view);
        $formErrors->setView($view);

        $errorMsg = $formErrors($element);

        if (strlen($errorMsg) > 0) {
            $html = "<div class='form-group has-error has-feedback'>";

            $htmlFooter = "<span class='fa fa-times form-control-feedback'></span>
                       <span class='error-block'>" . $errorMsg . "</span>";
        } else if ($element->getValue() != null) {
            $html = "<div class='form-group has-success has-feedback'>";

            $htmlFooter = "<span class='fa fa-check form-control-feedback'></span>";
        } else {
            $html = "<div class='form-group'>";

            $htmlFooter = '';
        }

        $html .= $formLabel($element) . "
             <div class='col-sm-9'>
                 " . $formElement($element);

        $html .= $htmlFooter;

        $html .= "</div></div>";

        return $html;
    }

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function __invoke(ElementInterface $element)
    {
        return $this->render($element);
    }
}