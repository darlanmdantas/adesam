<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Admin\Controller;

use Admin\Entity\TbUsuario;
use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;

use Core\Util\MenuBarButton;
use Admin\Form\UsuarioForm;

class UsuariosController extends BaseController
{

    protected $menuBar = array();

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $repository = $this->getEntityManager()->getRepository('Admin\Entity\TbUsuario');
        $usuarios = $repository->findAll();

        $novo = new MenuBarButton();
        $novo->setName('Novo')
            ->setAction('/admin/usuarios/create')
            ->setIcon('fa fa-plus')
            ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'usuarios' => $usuarios
            )
        );
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function createAction()
    {
        $form = new UsuarioForm;

        $request = $this->getRequest();
        $usuarioSessao = $this->getServiceLocator()->get('Session');
        $user = $usuarioSessao->offsetGet('zf2base_loggeduser');
        if ($request->isPost()) {
            $usuario = new TbUsuario();

            $form->setInputFilter($usuario->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                try {
                    $usuario->exchangeArray($form->getData());
                    $bcrypt = new Bcrypt();
                    $usuario->setDesSenha($bcrypt->create($usuario->getDesSenha()));
                    $usuario->setSeqUsuarioCadastrou($user->getSeqUsuario());
                    $repository = $this->getEntityManager();
                    $repository->persist($usuario);
                    $repository->flush();

                    $this->flashMessenger()->setNamespace('success')->addMessage('Usuário cadastrado com sucesso!');

                } catch (\Exception $e) {
                    $this->flashMessenger()->setNamespace('danger')->addMessage($e->getMessage());
                }
                return $this->redirect()->toUrl('/admin/usuarios');
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

        $form = new UsuarioForm();
        $form->setAttribute('action', '/admin/usuarios/update');

        if ($id) {
            $usuarioRepository = $repository->find('Admin\Entity\TbUsuario', $id);

            if (!$usuarioRepository) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Usuário não existe!');
                return $this->redirect()->toUrl('/admin/usuarios');
            } else {
                $usuarioRepository->setDesSenha(null);
                $form->setData($usuarioRepository->getArrayCopy());
            }
        } else if ($request->isPost()) {
            $usuario = new TbUsuario();
            $form->setInputFilter($usuario->getInputFilter());
            $form->setData($request->getPost());
            $form->getInputFilter()->get('desSenha')->setRequired(false);

            if ($form->isValid()) {
                $usuario->exchangeArray($form->getData());
                $usuarioRepository = $repository->find('Admin\Entity\TbUsuario', $usuario->getSeqUsuario());
                $usuario->setDatCadastro($usuarioRepository->getDatCadastro());

                if (!$usuario->getDesSenha()) {
                    $desSenha = $usuarioRepository->getDesSenha();
                } else {
                    $bcrypt = new Bcrypt();
                    $desSenha = $bcrypt->create($usuario->getDesSenha());
                }

                $usuarioSessao = $this->getServiceLocator()->get('Session');
                $user = $usuarioSessao->offsetGet('zf2base_loggeduser');

                $usuarioRepository->setNomUsuario($usuario->getNomUsuario());
                $usuarioRepository->setSeqUsuarioCadastrou($user->getSequsuario());
                $usuarioRepository->setDesEmail($usuario->getDesEmail());
                $usuarioRepository->setDesSenha($desSenha);
                $usuarioRepository->setDatCadastro($usuario->getDatCadastro());
                $usuarioRepository->setSitUsuario('A');
                $usuarioRepository->setDatAlteracao(new \DateTime('now'));
                $repository->flush();

                $this->flashMessenger()->setNamespace('success')->addMessage('Usuário atualizado com sucesso!');
                return $this->redirect()->toUrl('/admin/usuarios');
            }
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl('/admin/usuarios');
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
        $form = new UsuarioForm();
        $form->setAttribute('action', '/admin/usuarios/update');

        $usuarioModel = $this->getService("Admin\Model\UsuarioModel");

        if ($id > 0) {
            $usuarioSessao = $this->getServiceLocator()->get('Session');
            $user = $usuarioSessao->offsetGet('zf2base_loggeduser');
            $usuarioData = $usuarioModel->getById($id);
            $usuarioData->setSitUsuario('I');
            $usuarioData->setSeqUsuarioCadastrou($user->getSequsuario());

            if (!$usuarioData) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Usuário não existe!');
                return $this->redirect()->toUrl('/admin/usuarios');
            } else {
                $form->setData($usuarioData->getArrayCopy());
                $usuarioModel->update($usuarioData, $usuarioData->getSeqUsuario());
                $this->flashMessenger()->setNamespace('success')->addMessage('Usuário excluído com sucesso!');
            }
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Erro ao tentar excluir usuário!');
            return $this->redirect()->toUrl('/admin/usuarios');
        }

        return $this->redirect()->toUrl('/admin/usuarios');
    }

    /**
     * @return \Zend\Http\Response
     */
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        $repository = $this->getEntityManager();

        if ($id) {
            $usuarioRepository = $repository->find('Admin\Entity\TbUsuario', $id);

            try {
                $repository->remove($usuarioRepository);
                $repository->flush();

                $this->flashMessenger()->setNamespace('success')->addMessage('Usuário excluído com sucesso!');
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Não foi possível excluir o usuário!');
            }

            return $this->redirect()->toUrl('/admin/usuarios');
        }
        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/usuarios');
    }
}