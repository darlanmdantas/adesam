<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Core\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;

class CRUDController extends BaseController
{

    protected $menuBar = array();

    protected $entity;
    protected $form;
    protected $actionBase;
    protected $label;
    protected $model;

    /**
     * @param $entity
     * @param $model
     * @param $form
     * @param $actionBase
     * @param $label
     */
    function __construct($entity, $model, $form, $actionBase, $label)
    {
        $this->entity = $entity;
        $this->model = $model;
        $this->form = $form;
        $this->actionBase = $actionBase;
        $this->label = $label;
    }

    /**
     * @return array|object
     */
    protected function getModel()
    {
        if (!is_object($this->model)) {
            $this->model = $this->getService($this->model);
        }

        return $this->model;
    }

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $resultSet = $this->getModel()->findAll();

        $novo = new MenuBarButton();
        $novo->setName('Novo')
            ->setAction($this->actionBase . '/create')
            ->setIcon('fa fa-plus')
            ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'resultSet' => $resultSet
            )
        );
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function createAction()
    {
        $form = $this->form;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $dataObject = $this->entity;

            $form->setInputFilter($dataObject->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $dataObject->exchangeArray($form->getData());

                $this->getModel()->save($dataObject);

                $this->flashMessenger()->setNamespace('success')->addMessage($this->label . ' salvo com sucesso!');
                return $this->redirect()->toUrl($this->actionBase);
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function updateAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        $repository = $this->getEntityManager();
        $request = $this->getRequest();

        $form = $this->form;
        $form->setAttribute('action', $this->actionBase . '/update');

        if ($id) {
            $myRepository = $this->getModel()->getById($id);

            if (!$myRepository) {
                $this->flashMessenger()->setNamespace('danger')->addMessage($this->label . ' não existe!');
                return $this->redirect()->toUrl($this->actionBase);
            } else {
                $form->setData($myRepository->getArrayCopy());
            }
        }
        else if ($request->isPost()) {
            $dataObject = $this->entity;

            $form->setInputFilter($dataObject->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $dataObject->exchangeArray($form->getData());

                $this->getModel()->update($dataObject, $dataObject->getId());

                $this->flashMessenger()->setNamespace('success')->addMessage($this->label . ' atualizado com sucesso!');
                return $this->redirect()->toUrl($this->actionBase);
            }
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl($this->actionBase);
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * @return \Zend\Http\Response
     */
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id');

        if ($id) {
            $this->getModel()->delete($id);

            $this->flashMessenger()->setNamespace('success')->addMessage($this->label . ' excluído com sucesso!');

            return $this->redirect()->toUrl($this->actionBase);
        }
        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl($this->actionBase);
    }
}