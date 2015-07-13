<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Admin\Controller;

use Admin\Entity\TbPerfil;
use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;
use Admin\Form\PerfilForm;

class PerfisController extends BaseController
{
    protected $menuBar = array();

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {

        $request = $this->getRequest();
        $perfil = $this->getService("Admin\Model\PerfilModel");

        $criteria = array();
        if (isset($request->getPost()['nomPerfil']) && $request->getPost()['nomPerfil']) {
            $criteria = array('nomPerfil' => $request->getPost()['nomPerfil']);
        }

        $perfis = $perfil->getByAttributes($criteria);

        $novo = new MenuBarButton();
        $novo->setName('Novo')
            ->setAction('/admin/perfis/create')
            ->setIcon('fa fa-plus')
            ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'perfis' => $perfis
            )
        );
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function createAction()
    {
        $form = new PerfilForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $perfil = new TbPerfil();

            $form->setInputFilter($perfil->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $perfil->exchangeArray($form->getData());

                $perfilModel = $this->getService("Admin\Model\PerfilModel");

                $perfilModel->save($perfil);

                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil salvo com sucesso!');
                return $this->redirect()->toUrl('/admin/perfis');
            }
        }

        return new ViewModel(
            array('form' => $form)
        );
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function updateAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        $request = $this->getRequest();

        $form = new PerfilForm();
        $form->setAttribute('action', '/admin/perfis/update');

        $perfilModel = $this->getService("Admin\Model\PerfilModel");

        if ($id) {
            $perfilData = $perfilModel->getById($id);

            if (!$perfilData) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Perfil não existe!');
                return $this->redirect()->toUrl('/admin/perfis');
            } else {
                $form->setData($perfilData->getArrayCopy());
            }
        } else if ($request->isPost()) {
            $perfilEntity = new TbPerfil();
            $form->setInputFilter($perfilEntity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $perfilEntity->exchangeArray($form->getData());

                $perfilModel->update($perfilEntity, $perfilEntity->getSeqPerfil());

                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil atualizado com sucesso!');
                return $this->redirect()->toUrl('/admin/perfis');
            }
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl('/admin/perfis');
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * @return \Zend\Http\Response
     */
    public function inactiveAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        $form = new PerfilForm();
        $form->setAttribute('action', '/admin/perfis/update');

        $perfilModel = $this->getService("Admin\Model\PerfilModel");

        if ($id > 0) {
            $perfilData = $perfilModel->getById($id);
            $perfilData->setSitPerfil('I');

            if (!$perfilData) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Perfil não existe!');
                return $this->redirect()->toUrl('/admin/perfis');
            } else {
                $form->setData($perfilData->getArrayCopy());
                $perfilModel->update($perfilData, $perfilData->getSeqPerfil());
                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil excluído com sucesso!');
            }
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Erro ao tentar excluir perfil!');
            return $this->redirect()->toUrl('/admin/perfis');
        }

        return $this->redirect()->toUrl('/admin/perfis');
    }

    /**
     * @return \Zend\Http\Response
     */
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id');

        if ($id) {
            $perfilModel = $this->getService("Admin\Model\PerfilModel");

            $perfilModel->delete($id);
            $this->flashMessenger()->setNamespace('success')->addMessage('Perfil excluído com sucesso!');
            return $this->redirect()->toUrl('/admin/perfis');
        }
        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/perfis');
    }
}
