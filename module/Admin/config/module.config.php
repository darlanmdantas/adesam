<?php

namespace Admin;

return array(
    'service_manager' => array(
        'invokables' => array(
            'Admin\Model\PerfilModel' => 'Admin\Model\PerfilModel',
            'Admin\Model\UsuarioModel' => 'Admin\Model\UsuarioModel',
            'Admin\Model\UsuarioPerfilModel' => 'Admin\Model\UsuarioPerfilModel',
            'Admin\Service\UsuarioPerfilService' => 'Admin\Service\UsuarioPerfilService',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Usuarios' => 'Admin\Controller\UsuariosController',
            'Admin\Controller\Perfis' => 'Admin\Controller\PerfisController',
            'Admin\Controller\PerfisUsuarios' => 'Admin\Controller\PerfisUsuariosController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'module'        => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller][/:action][/:id][/:idtwo]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9]+',
                                'idtwo'      => '[0-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'            => __DIR__ . '/../view/layout/layout.phtml',
            'layout/layout_config_tool'=> __DIR__ . '/../view/layout/layout-config-tool.phtml',
            'layout/layout_login'=> __DIR__ . '/../view/layout/layout-login.phtml',
            'layout/layout_menu_top'   => __DIR__ . '/../view/layout/layout-menu-top.phtml',
            'layout/layout_siderbar'   => __DIR__ . '/../view/layout/layout-siderbar.phtml',
            'admin/index/index'        => __DIR__ . '/../view/admin/index/index.phtml',
            'error/404'                => __DIR__ . '/../view/error/404.phtml',
            'error/index'              => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view/layout',
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
);