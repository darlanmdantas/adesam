<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;

class MenuBar extends AbstractHelper
{

    /**
     * @param $menuItens
     */
    public function __invoke($menuItens)
    {
        echo "<div class='col-md-12 alert alert-normal'>";
        foreach ($menuItens as $value) {
            $icon = $value->getIcon() != '' ? $value->getIcon() : '';
            $style = $value->getStyle() != '' ? $value->getStyle() : '';

            $button = "<a class='btn " . $style . "' href='" . $value->getAction() . "'>";
            $button .= "<i class='" . $icon . "'></i> " . $value->getName() . "</a>";
            $button .= "&nbsp;&nbsp;";

            echo $button;
        }
        echo "</div>";
    }
}