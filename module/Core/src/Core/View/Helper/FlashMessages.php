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

class FlashMessages extends AbstractHelper
{

    protected $flashMessenger;

    /**
     * @param $flashMessenger
     */
    public function setFlashMessenger($flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        $namespaces = array(
            'danger', 'success', 'info', 'warning'
        );
        $messageString = '';
        foreach ($namespaces as $ns) {

            $this->flashMessenger->setNamespace($ns);

            $messages = array_merge(
                $this->flashMessenger->getMessages(),
                $this->flashMessenger->getCurrentMessages()
            );

            if (!$messages) continue;

            $messageString .= "<p class='flashmessages bg-$ns'>";
            $messageString .= implode('<br />', $messages);
            $messageString .= '</p>';
        }

        return $messageString;
    }
}