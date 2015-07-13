<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;

class PerfisUsuariosController extends BaseController
{
    protected $menuBar = array();

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $repository = $this->getEntityManager()->getRepository('Admin\Entity\TbUsuario');
        $usuarios = $repository->findAll();

        $usuarioPerfil = $this->getService("Admin\Service\UsuarioPerfilService");
        $criteria = array();
        $resUsuarioPerfil = $usuarioPerfil->getUsuarioPerfil($criteria);

        $novo = new MenuBarButton();
        $novo->setName('Novo')
            ->setAction('/admin/perfis-usuarios/create')
            ->setIcon('fa fa-plus')
            ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'usuarioPerfil' => $resUsuarioPerfil
            )
        );
    }

    /**
     * @return ViewModel
     */
    public function createAction()
    {
        $form = new UsuarioPerfilForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $usuarioPerfil = new TbUsuarioPerfil();
            $form->setInputFilter($usuarioPerfil->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $usuarioPerfil->exchangeArray($form->getData());
                $usuarioPerfilModel = $this->getService("Admin\Model\UsuarioPerfilModel");

                $usuarioPerfilModel->save($usuarioPerfil);

                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil concedido com sucesso!');
                return $this->redirect()->toUrl('/admin/perfis-usuarios');
            }
        }

        /*popula a combobox do perfil*/
        $perfiloModel = $this->getService("Admin\Model\PerfilModel");
        $form->get('seq_perfil')->setValueOptions($perfiloModel->getAllItensToSelect('seq_perfil', 'des_perfil'));

        /*popula a combobox do usuario*/
        $usuarioModel = $this->getService("Admin\Model\UsuarioModel");
        $form->get('seq_usuario')->setValueOptions($usuarioModel->getAllItensToSelect('seq_usuario', 'nom_usuario'));

        return new ViewModel(
            array('form' => $form)
        );
    }

    /**
     * @return ViewModel
     */
    public function updateAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        $request = $this->getRequest();

        $form = new UsuarioPerfilForm();
        $form->setAttribute('action', '/admin/perfis-usuarios/update');
        $usuarioPerfilModel = $this->getService("Admin\Model\UsuarioPerfilModel");

        if ($id) {
            $usuarioPerfilData = $usuarioPerfilModel->getById($id);
            if (!$usuarioPerfilData) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Perfil não existe!');
                return $this->redirect()->toUrl('/admin/perfis-usuarios');
            } else {
                $form->setData($usuarioPerfilData->getArrayCopy());
            }
        } else if ($request->isPost()) {
            $usuarioPerfilEntity = new TbUsuarioPerfil();
            $form->setInputFilter($usuarioPerfilEntity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $usuarioPerfilEntity->exchangeArray($form->getData());
                $usuarioPerfilModel->update($usuarioPerfilEntity, $usuarioPerfilEntity->seq_usuario_perfil);
                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil do usuário atualizado com sucesso!');
                return $this->redirect()->toUrl('/admin/perfis-usuarios');
            }
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl('/admin/perfis-usuarios');
        }

        /*popula a combobox do perfil*/
        $perfiloModel = $this->getService("Admin\Model\PerfilModel");
        $form->get('seq_perfil')->setValueOptions($perfiloModel->getAllItensToSelect('seq_perfil', 'des_perfil'));

        /*popula a combobox do usuario*/
        $usuarioModel = $this->getService("Admin\Model\UsuarioModel");
        $form->get('seq_usuario')->setValueOptions($usuarioModel->getAllItensToSelect('seq_usuario', 'nom_usuario'));

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
        if ($id > 0) {
            $perfilModel = $this->getService("Admin\Model\UsuarioPerfilModel");
            $perfilModel->delete($id);
            $this->flashMessenger()->setNamespace('success')->addMessage('Perfil do usuário excluído com sucesso!');
            return $this->redirect()->toUrl('/admin/perfis-usuarios');
        }
        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/perfis-usuarios');
    }
}